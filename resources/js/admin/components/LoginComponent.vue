<template>
    <div id="login_container">
        <b-row>
            <b-col>
                <b-form @submit.prevent="doLogin">
                    <b-form-group>
                        <b-form-input v-model="user" placeholder="Username"/>
                    </b-form-group>
                    <b-form-group>
                        <b-form-input type="password" v-model="password" placeholder="Password"/>
                    </b-form-group>
                    <b-form-group class="text-center">
                        <b-button type="submit" variant="primary">Login</b-button>
                    </b-form-group>
                </b-form>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                user: '',
                password: '',
            }
        },
        methods: {
            doLogin() {
                this.$cookies.set("session_token", "asdasd");
                this.$router.push({ name: 'Home' })
            }
        }
    }
</script>

<style scoped lang="scss">
    @import '../../../sass/app';
    #login_container {
        display: flex;
        height: 100%;
        align-items: center;
        justify-content: center;
        form {
            background: rgba($lightPrimary, .25);
            padding: 1rem;
            border-radius: 4px;
        }
    }
</style>
