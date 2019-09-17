<template>
    <layout :grow="false">
        <template v-slot:col1>
            <h2 class="text-dark text-upper">
                <span class="extra-bold">Participa</span> y gana
            </h2>
            <p class="text">
                Al registrarte automáticamente participas por una página web y una asesoría de los puntos de contactos
                de tu empresa.
            </p>
            <form action="" id="subscribe_form" @submit.prevent="register">
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Nombres" v-model="name">
                </div>
                <div class="form-group">
                    <input class="form-control" type="email" placeholder="Correo Electrónico" v-model="email">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-outline-secondary">Registrarme</button>
                </div>
                <p class="text-center">
                    Al inscribirte aceptas nuestros <a href="">Términos y Condiciones</a>
                </p>
            </form>
        </template>
        <template v-slot:col2>
            <h2>
                Una <span>página web</span>
                <br><span class="text-secondary">Gratis</span>
            </h2>
        </template>
    </layout>
</template>

<script>
    import Layout from './Layout';
    import {mapActions} from 'vuex';

    export default {
        name: "Page1Component",
        components: {Layout},
        data() {
            return {
                name: '',
                email: ''
            }
        },
        methods: {
            ...mapActions(['alignElementsToLeft', 'updateUserInfo']),
            register() {
                const data = {
                    name: this.name,
                    email: this.email
                };
                this.$axios.post('/subscribers', data)
                    .then(({data}) => {
                        const {name, email, token, tickets} = data.data;
                        this.$cookies.set('token', token);
                        this.updateUserInfo({name, email, tickets});
                        this.$router.push('/step2')
                    }).catch(error => {

                })
            }
        },
        mounted() {
            this.alignElementsToLeft()
        }
    }
</script>

<style scoped lang="scss">
    @import "../sass/colors";

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
        /*background: #eee7df url("../img/blank-clean-device-891679.png") no-repeat right bottom;
        background-size: contain;*/

        #main_row {
            flex-grow: unset;
        }

    }

    #right {
        h2 {
            padding-bottom: 1rem;
            color: $dark;
            text-transform: uppercase;
            font-weight: 300;
            font-size: 3rem;
            line-height: 3.4rem;
            margin-left: 31%;
            @media(max-width: 768px) {
                margin-left: 0;
            }
            span {
                font-weight: 600;
                &.text-secondary {
                    font-size: 4.875rem;
                    font-weight: 800;
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