<template>
    <layout :grow="false">
        <template v-slot:col1>
            <h2 class="text-dark text-upper extra-bold" v-html="lang.title_1"></h2>
            <p class="text semi-bold mt-4" v-html="lang.text_1"></p>
            <form action="" id="subscribe_form" @submit.prevent="register">
                <div class="form-group mt-4">
                    <input class="form-control" type="text" :placeholder="lang.name_placeholder" v-model="name" :disabled="loading">
                </div>
                <div class="form-group">
                    <input class="form-control" type="email" :placeholder="lang.email_placeholder" v-model="email" :disabled="loading">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-outline-secondary text-uppercase" :disabled="loading">
                        <font-awesome-icon icon="circle-notch" spin v-if="loading"></font-awesome-icon>
                        <template v-else>{{ lang.register }}</template>
                    </button>
                </div>
                <p class="text-center" v-html="lang.terms_conditions"></p>
            </form>
            <div>
                <h3 class="mt-5 mb-2" v-html="lang.details_title"></h3>
                <ul>
                    <li v-for="(t, i) in lang.details_text.split('|')">{{ t }}</li>
                </ul>
            </div>
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
                    email: this.email,
                    grecaptcha: document.getElementsByName('grecaptcha')

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
                        fbq('track', 'CompleteRegistration');
                        this.$router.push('/step2');
                    })
                    .catch(() => {
                        this.loading = false;
                    })
            }
        },
        mounted() {
            this.alignElementsToLeft();
            fbq('track', 'ViewContent', {
                page: "Register Page"
            });
        }
    }
</script>

<style scoped lang="scss">
    @import "../../sass/colors";

    #left {
        h3 {
            color: $azul_oscuro;
            font-weight: bold;
            font-size: 1.25rem;
        }

        ul {
            list-style-type: none;
            padding: 0;
            li {
                &::before {
                    margin-right: .5rem;
                    display: inline-block;
                    content: '✔'
                }
            }
        }

        h2 {
            line-height: 1em;
            color: $dark !important;
            font-size: 3rem;
            text-transform: uppercase;
            @media(max-width: 576px) {
                text-align: center;
                font-size: 3rem;
            }
        }
        p {
            @media(max-width: 576px) {
                text-align: center;
            }
            font-size: .75rem;
            color: $azul_oscuro;
            &.text {
                font-style: normal;
                font-size: 1.25rem;
                line-height: 1.6875rem;
                font-feature-settings: 'liga' off;
                @media(min-width: 1200px) {
                    width: 570px;
                }
                color: #575757 !important;
            }
        }
        form {
            width: 66%;
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
                    margin-top: 30px;
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
            @media(max-width: 576px) {
                font-size: 2rem;
            }
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
