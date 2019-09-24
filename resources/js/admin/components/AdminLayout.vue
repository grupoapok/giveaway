<template>
    <b-row>
        <b-col :cols="3" :xl="2">
            <b-nav vertical pills>
                <b-nav-item :to="{name: 'Home'}" exact>Home</b-nav-item>
                <b-nav-item :to="{name: 'Tasks'}">Tasks</b-nav-item>
            </b-nav>
        </b-col>
        <b-col>
            <router-view></router-view>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        name: "AdminLayout"
    }
</script>

<style scoped>

</style>
