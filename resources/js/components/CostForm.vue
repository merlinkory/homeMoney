<template>
    <div>
        <form @submit.prevent="create">
            <input type="date" v-model="costDate"><br/>
            <input placeholder="выбирите группу расходов" v-model="costGroup" list="cost_groups"><br/>
            <datalist id="cost_groups">
                <option v-for="group in costGroups">{{group.name}}</option>
            </datalist>
            <input placeholder="amount" v-model="costAmount"><br/>
            <select v-model="costCurrency">
                <option v-for="currency in currencies" v-bind:value="currency">{{currency}}</option>
            </select><br/>
            <button>create</button>
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
            costDate: '',
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
            this.currencies =response.data.data;

        },
        async create(){
            let cost_group_id = this.getCostGroupId();
            if(cost_group_id === -1){
                alert('невозможно получить группу');
                return;
            }

            let payload = {
                cost_group_id: cost_group_id,
                amount: this.costAmount,
                currency: this.costCurrency,
                date: this.costDate
            };

            let response = axios.post('/costs', JSON.stringify(payload),{
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            console.log(response.data);
            console.log(payload);
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

</style>
