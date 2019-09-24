<template>
    <layout :grow="false">
        <template v-slot:col1>
            <h2 class="text-dark text-upper" v-html="lang.title_1"></h2>
            <p class="text" v-html="lang.text_1"></p>
            <form action="" id="subscribe_form" @submit.prevent="register">
                <div class="form-group">
                    <input class="form-control" type="text" :placeholder="lang.name_placeholder" v-model="name" :disabled="loading">
                </div>
                <div class="form-group">
                    <input class="form-control" type="email" :placeholder="lang.email_placeholder" v-model="email" :disabled="loading">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-outline-secondary" :disabled="loading">
                        <font-awesome-icon icon="circle-notch" spin v-if="loading"></font-awesome-icon>
                        <template v-else>{{ lang.register }}</template>
                    </button>
                </div>
                <p class="text-center" v-html="lang.terms_conditions"></p>
            </form>
        </template>
        <template v-slot:col2>
            <h2 v-html="lang.title_2" class="text-dark">
                <!--Una <span>página web</span><br><span class="text-secondary">Gratis</span>-->
            </h2>
        </template>
    </layout>
</template>

<script>
    import Layout from './Layout';
    import {mapActions} from 'vuex';
    import LangMixin from '../mixin/lang';

    export default {
        name: "Page1Component",
        mixins: [LangMixin('step1')],
        components: {Layout},
        data() {
            return {
                loading: false,
                name: '',
                email: ''
            }
        },
        methods: {
            ...mapActions(['alignElementsToLeft', 'updateUserInfo', 'updateTicketsList']),
            register() {
                const data = {
                    name: this.name,
                    email: this.email
                };
                this.loading = true;
                this.$axios.post('/subscribers', data)
                    .then(({data}) => {
                        const {token} = data.data;
                        this.$cookies.set('token', token);
                        return this.$axios.get('/subscribers', {
                            headers: {
                                'Token': token
                            },
                        })
                    })
                    .then(({data}) => {
                        const {name, email, tickets} = data.data;
                        this.updateUserInfo({name, email, tickets});
                        this.updateTicketsList();
                        this.loading = false;
                        this.$router.push('/step2');
                    })
                    .catch(() => {
                        this.loading = false;
                    })
            }
        },
        mounted() {
            this.alignElementsToLeft();
        }
    }
</script>

<style scoped lang="scss">
    @import "../../sass/colors";

    #left {
        h2 {
            line-height: 1em;
            color: $dark !important;
            font-size: 4rem;
            text-transform: uppercase;
            font-weight: 600;
            @media(max-width: 576px) {
                text-align: center;
            }
        }
        p {
            @media(max-width: 576px) {
                text-align: center;
            }
            font-size: .75rem;
            color: $dark;
            a {
                color: $dark;
                text-decoration: underline;
            }
            &.text {
                font-style: normal;
                font-weight: normal;
                font-size: 1.25rem;
                line-height: 1.6875rem;
                font-feature-settings: 'liga' off;
                @media(min-width: 1200px) {
                    width: 484px;
                }
                color: #575757 !important;
            }
        }
        form {
            width: 50%;
            @media(max-width: 768px) {
                width: unset;
            }
            button {
                font-size: 1.125rem;
                font-weight: 600;
                &:hover {
                    color: white !important;
                }
            }
            .form-group {
                & + .form-group {
                    margin-top: 50px;
                }
            }
            .form-control {
                @media(max-width: 768px) {
                    border: 1px solid gray;
                }
            }
        }
    }

    #page1 {
        #main_row {
            flex-grow: unset;
        }

    }

    #right {
        h2 {
            padding-bottom: 1rem;
            font-weight: 300;
            font-size: 3rem;
            line-height: 3.4rem;
            margin-left: 31%;
            text-transform: uppercase;
            @media(max-width: 768px) {
                margin-left: 0;
            }
            span {
                &.text-secondary {
                    font-size: 4.875rem;
                    letter-spacing: -3%;
                    clear: both;
                }
            }
        }
    }

    @media (max-width: 768px) {
        form {
            width: 100%;
        }

        p.text {
            width: auto;
        }

        .form-group {
            width: auto;
        }
    }
</style>
