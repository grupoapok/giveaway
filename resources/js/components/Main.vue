<template>
    <div :class="['layout', !alignRight && 'bg']">
        <div id="big_square" :class="alignRight && 'right'">
            <div></div>
        </div>

        <div id="cuadros" class="d-none d-lg-block">
            <div id="azul_oscuro"></div>
            <div id="azul_claro"></div>
            <div id="blanco"></div>
            <div id="azul_oscuro2"></div>
            <div id="naranja"></div>
        </div>

        <div class="fluid-container" id="main">
            <div class="row">
                <div class="col text-center text-sm-right"><img :src="logo" id="logo"></div>
            </div>
            <transition name="fade">
                <router-view/>
            </transition>
            <div class="row">
                <div class="col" id="social-links-container">
                    <social-links id="social-links" :class="alignRight && 'right'"></social-links>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from 'vuex';
    import logo from '../../img/apok_logo.png';
    import SocialLinks from './SocialLinksComponent'

    export default {
        name: "Main",
        components: {SocialLinks},
        data() {
            return {
                logo,
            }
        },
        props: {
            grow: {
                type: Boolean,
                default: true,
            }
        },
        computed: {
            ...mapState(['alignRight'])
        },
        methods: {
            ...mapActions(['updateUserInfo'])
        },
        mounted() {
            if (this.$cookies.get("token")) {
                this.$axios.get('/subscribers')
                    .then(({data}) => {
                        const {name, email, tickets} = data.data;
                        this.updateUserInfo({name, email, tickets});
                    })
                    .catch(error => {
                        if (error.response.status === 401) {
                            this.$cookies.remove('token');
                            this.$cookies.remove('twitter_token');
                            this.$cookies.remove('twitter_token_secret');
                            this.$cookies.remove('tw_oauth_request_token');
                            this.$cookies.remove('tw_oauth_request_token_secret');
                            this.$cookies.remove('linkedin_token');
                            this.$router.push('/');
                        }
                    });
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../../sass/colors";

    .layout {
        height: 100%;
        position: relative;
        overflow-x: hidden;

        @media(max-width: 1200px) {
            overflow: unset;
        }

        &.bg {
            background: #eee7df url("../../img/blank-clean-device-891679.png") no-repeat right bottom;
            background-size: contain;
        }

        #main {
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 2% 10%;
            @media(max-width: 992px) {
                padding: 10%;
            }
            justify-content: space-between;
        }

        #social-links {
            transition: all 1s ease-in-out;
            @media(max-width: 576px) {
                transition: none;
            }
            &.right {
                transform: translateX(-100%);
                margin-left: 100%;
            }
        }
    }

    #big_square {
        z-index: 0;
        width: 64.6vw;
        height: 64.6vw;
        position: absolute;
        transform: rotate(45deg);
        transition: left .75s ease-in-out;
        left: -20%;
        top: -20%;

        &.right {
            left: 55%;
        }

        @media(max-width: 768px) {
            width: 100vw;
            height: 100vw;
            left: 0;
            top: -70vw;
            &.right {
                right: 0;
            }
        }

        > div {
            width: 100%;
            height: 100%;
            border: 15px solid white;
            -webkit-box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.1);
            -moz-box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.1);
            box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.1);
            background-image: linear-gradient(to bottom right, #93DCEB, white);
        }
    }
</style>
