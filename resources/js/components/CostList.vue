<template>
    <div v-for="(data, date) in costList">
        <h3>{{ date }}</h3>
        <ul>
            <li v-for="cost in data.costs">{{cost.name}} ({{cost.amount}} {{cost.currency}})</li>
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
        async getCosts(){
            let response = await axios.get('/costs');
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
