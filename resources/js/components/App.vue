<template>
    <div class="common-layout">
        <el-container>
            <el-header>
                <router-link to="/">затраты</router-link> /
                <router-link to="/create">создать</router-link> /
                <router-link to="/report">отчеты</router-link> /
            </el-header>
            <el-main>
                <router-view></router-view>
            </el-main>
        </el-container>
    </div>
</template>

<script>
export default {
    name: "App"
}
</script>

<style scoped>

</style>
