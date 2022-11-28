<template>
    <div>
        <form @submit.prevent="getReportData()">
            <label>Месяу: </label>
            <select v-model="reportMonth">
                <option value="1">Январь</option>
                <option value="2">Февраль</option>
                <option value="3">Март</option>
                <option value="4">Апрель</option>
                <option value="5">Май</option>
                <option value="6">Июнь</option>
                <option value="7">Июль</option>
                <option value="8">Август</option>
                <option value="9">Сентябрь</option>
                <option value="10">Октябрь</option>
                <option value="11">Ноябрь</option>
                <option value="12">Декабрь</option>
            </select>
            <label>Год: </label>
            <select v-model="reportYear">
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
            </select>
            <br/>
            <button>Показать отчет</button>
        </form>
    </div>
    <div v-for="(data, currency) in this.data">
        <h3>{{currency}}</h3>
        <ul>
            <li v-for="(amount, groupName) in data.groups">
                {{groupName}} <strong>{{amount}}</strong>
            </li>
        </ul>
        <strong>Total {{data.total}}</strong> {{currency}}
    </div>
</template>

<script>
export default {
    name: "CostReport.vue",
    data(){
        return{

            reportMonth: new Date().getMonth() + 1,
            reportYear: new Date().getFullYear(),
            data: [],
        }
    },
    methods:{
        async getReportData(){
            let payload= {
                month: this.reportMonth,
                year: this.reportYear,
            };
            let response = await axios.post('/costs/report', JSON.stringify(payload),{
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if(response.status === 200){
                this.data = response.data.data;
            }else{
                console.log('Failed to load report data...');
            }
        }
    },
    mounted() {
        this.getReportData();
    }
}
</script>

<style scoped>

</style>
