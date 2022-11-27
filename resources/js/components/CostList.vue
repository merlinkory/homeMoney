<template>
    <div v-for="(data, date) in costList">
        <el-row>
            <el-col class="cost_date">
                {{ date }}
            </el-col>
        </el-row>
        <el-row v-for="cost in data.costs" class="cost_row">
            <el-col :span="10">
                {{cost.name}}
            </el-col>
            <el-col :span="8">
                <strong>{{getParseCurrencyValue(cost.amount,cost.currency)}}</strong>
            </el-col>
            <el-col :span="3">
                {{cost.currency}}
            </el-col>
            <el-col :span="3">
                <el-button type="danger" circle @click="deleteCost(cost.id)">X</el-button>
            </el-col>
            <el-col class="cost_description">
                {{cost.description}}
            </el-col>
        </el-row>
        <ul>
            <li v-for="(value, currency) in data.total">
                <strong>{{getParseCurrencyValue(value, currency)}}</strong> {{currency}}
            </li>
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
        getParseCurrencyValue(amount, currencyCode){
            return new Intl.NumberFormat("ru", {currency: currencyCode}).format(amount);
        },
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
            if(response.status === 200){
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
.cost_date{
    font-weight: bold;
    font-size: 24px;
}
.cost_description{
    font-style: italic;
}
.cost_row{
    border: 1px solid;
    margin-top: 10px;
    padding: 5px;
}
</style>
