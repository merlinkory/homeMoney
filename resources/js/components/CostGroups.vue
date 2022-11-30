<template>
    <form @submit.prevent="createCostGroup">
        <input type="text" v-model="costGroup">
        <button>Создать</button>
    </form>
    <div>
        <ul>
            <li v-for="costGroup in costGroups">{{costGroup.name}} <button @click="deleteCost(costGroup.id)">X</button></li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "CostGroups",
    data(){
        return{
            costGroup: '',
            costGroups: [],
        }
    },
    methods:{
        async deleteCost(id){
            if(!confirm('Вы уверены?')) return;
            let response = await axios.delete('/cost-groups/' + id);
            if(response.status === 200){
                alert('Группа удалена');
                this.getCostGroups();
            }else{
                alert('Не удалось удалить группу');
            }
        },
        async createCostGroup(){
            if(this.costGroup === ''){
                alert('Введите название группы');
                return;
            }
            let payload = {
                name: this.costGroup,
            }
            let response = await axios.post('/cost-groups', payload,{
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if(response.status === 200){
                this.costGroup = '';
                alert('группа создана');
                this.getCostGroups();
            }
        },
        async getCostGroups(){
            let response = await axios.get('/cost-groups');
            this.costGroups = response.data.data;
            console.log(response.data);
        }
    },
    mounted() {
        this.getCostGroups();
    }
}
</script>

<style scoped>

</style>
