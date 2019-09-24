<template>
    <div id="layout">
        <b-navbar></b-navbar>
        <main class="container-fluid d-flex flex-column flex-fill">
            <router-view></router-view>
        </main>
        <footer>
            this is the footer
        </footer>
    </div>
</template>

<script>
    export default {
        name: "Admin"
    }
</script>

<style scoped lang="scss">
    @import '../../../sass/app';

    #layout {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }
</style>
