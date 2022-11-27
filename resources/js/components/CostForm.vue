<template>
    <div class="form_wrapper">
        <form @submit.prevent="create" class="cost_form">
            <input type="date" v-model="costDate"><br/>
            <input type="text" placeholder="выбирите группу расходов" v-model="costGroup" list="cost_groups"><br/>
            <datalist id="cost_groups">
                <option v-for="group in costGroups">{{group.name}}</option>
            </datalist>
            <input placeholder="amount" type="number" v-model="costAmount"><br/>
            <select v-model="costCurrency">
                <option selected v-for="currency in currencies" v-bind:value="currency">{{currency}}</option>
            </select><br/>
            <input placeholder="Описание затрат" type="text" v-model="costDescription"><br/>
            <button>Создать</button>
        </form>
    </div>
</template>

<script>
export default {
    name: "CostForm",
    data(){
        return{

            costGroup: '',
            costAmount: '',
            costCurrency: '',
            costDescription: '',
            costDate: new Date().toISOString().substr(0, 10),
            costGroups: [],
            currencies: []
        }
    },
    methods: {
        async getCostGroups(){
            let response = await axios.get('/cost-groups/1');//TODO: change user_id to dynamic
            this.costGroups = response.data.data;
            console.log(this.costGroups);
        },
        async getCurrencies(){
            let response = await axios.get('/currencies');
            for(let key in response.data.data){
                this.currencies.push(key)
            }
            this.costCurrency = this.currencies[0];

        },
        async create(){

            if(this.costAmount === '' || this.costGroup === ''){
                alert('Заполните обязательные поля');
                return;
            }
            let cost_group_id = this.getCostGroupId();
            if(cost_group_id === -1){
                alert('невозможно получить группу');
                return;
            }

            let payload = {
                cost_group_id: cost_group_id,
                amount: this.costAmount,
                currency: this.costCurrency,
                date: this.costDate,
                description: this.costDescription,
            };

            let response = await axios.post('/costs', JSON.stringify(payload),{
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if(response.status === 200){
                this.costAmount = 0; this.costDescription = '';
                alert("затраты созданы!");
            }
        },
        getCostGroupId(){
            for(let i=0; i<this.costGroups.length; i++){
                if(this.costGroup === this.costGroups[i].name){
                    return this.costGroups[i].id;
                }
            }
            return -1;
        }
    },
    mounted() {
       this.getCostGroups();
       this.getCurrencies();

    }
}
</script>

<style scoped>
.form_wrapper{
    text-align: center;
}
.cost_form input, select, button{
    width: 80%;
    font-size: 100%;
    margin-top: 10px;
    font-size: 32px;
}
</style>
