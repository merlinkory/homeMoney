<template>
    <div v-for="(data, date) in costList">
        <h3>{{ date }}</h3>
        <ul>
            <li v-for="cost in data.costs">{{cost.name}} ({{cost.amount}} {{cost.currency}})  <button @click="deleteCost(cost.id)">X</button></li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "CostList",
    data(){
        return{
            costList: [],
        }
    },
    methods:{
        async deleteCost(id){
            if(!confirm('Вы уверены в удаление ?')) return;

            let response = await axios.delete('/costs/'+id);
            if(response.status === 200){
                alert('Затрата удалена');
                this.getCosts();
            }else{
                alert('Ошибка удаления');
            }
        },
        async getCosts(){
            let response = await axios.get('/costs/2');
            if(response.status == 200){
                this.costList = response.data.data;
                console.log(response.data);
            }else{
                alert('uncathed error');
            }
        }
    },
    mounted() {
        this.getCosts();
    }
}
</script>

<style scoped>

</style>
