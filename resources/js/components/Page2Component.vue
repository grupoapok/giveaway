<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <layout>
        <template v-slot:col1>
            <div id="col1_content">
                <div id="title">
                    <img :src="page2ImgHeader"/>
                </div>

                <p id="tasks-title" class="text-secondary" v-html="lang.available_tasks"></p>

                <div id="tasks" class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-xl-4" :key="`task_${i}`"
                             v-for="(t,i) in tasks">
                            <task class="task mb-4"
                                  @taskCompleted="completeTask"
                                  :auto-execute="$cookies.get('execute_task') === t.type"
                                  :task="t"/>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:col2>
            <div id="col2_content" class="text-center text-lg-right">
                <p id="gracias" class="text-secondary" v-html="lang.thanks"></p>
                <p v-html="lang.text_1_1_ticket" v-if="tickets == 1" class="text-primary"></p>
                <p v-html="lang.text_1" v-else class="text-primary"></p>

                <div id="tickets_text_container">
                    <p class="text-dark mb-0 font-weight-bold">
                        <template v-if="tickets === 0" v-html="lang.no_tickets"></template>
                        <template v-else>
                            <span v-html="ticketsMessage"></span>
                        </template>
                    </p>
                    <p v-if="tickets > 0" id="view_tickets_message" class="cursor-pointer" @click="toggleTicketsModal"
                       v-html="lang.view_my_tickets"></p>
                </div>

                <p class="text-primary mt-5" v-html="lang.winner_announcement"></p>
                <p class="my-5 text-primary" v-html="lang.good_luck"></p>
            </div>

            <b-modal id="tickets_list" v-model="showTicketsModal" centered hide-footer>
                <h5 class="modal-title text-dark font-weight-bold" slot="modal-title">
                    <span v-html="lang.my_tickets"></span><br/>
                    <span class="font-weight-normal">{{ name }} ({{ email }})</span>
                </h5>
                <tickets :tickets="ticketsList" :tooltip-header="lang.task_completed_at"/>
            </b-modal>
        </template>
    </layout>
</template>

<script>
    import {mapActions, mapState} from 'vuex';
    import Layout from './Layout';
    import Task from './TaskComponent';
    import Tickets from './TicketsComponent';
    import LangMixin from '../mixin/lang';
    import page2ImgHeader from '../../img/page2_text_es.svg';

    export default {
        name: "Page2Component",
        mixins: [LangMixin('step2')],
        components: {Layout, Task, Tickets},
        data() {
            return {
                showTicketsModal: false,
                page2ImgHeader,
                tasks: [],
            }
        },
        computed: {
            ...mapState(['name', 'email', 'tickets', 'ticketsList']),
            ticketsMessage() {
                if (this.lang) {
                    return this.lang['ticket_number'].replace(":tickets", this.tickets)
                }
                return null
            },
        },
        methods: {
            ...mapActions(['alignElementsToRight', 'updateUserInfo']),
            loadTasks() {
                console.log("loadTasks", this.$cookies.get("token"));
                this.$axios.get('/subscribers/tasks').then(response => {
                    this.tasks = response.data.data.map(t => {
                        if (t.type === 'form') {
                            return {...t, icon: ['fas', 'comments'], class: 'secondary'};
                        }
                        return t;
                    });
                })
            },
            completeTask(id) {
                const newTasks = this.tasks.concat();
                newTasks.forEach((t, i) => {
                    if (t.id === id) {
                        newTasks[i].completed = true;
                    }
                });
                this.tasks = newTasks;
            },
            toggleTicketsModal() {
                this.showTicketsModal = !this.showTicketsModal;
                if (this.showTicketsModal) {
                    fbq('track', 'ViewContent', {
                        page: "Tickets Modal"
                    });
                }
            },
        },
        mounted() {
            this.loadTasks();
            this.alignElementsToRight();
            fbq('track', 'ViewContent', {
                page: "Tasks Page"
            });
        }
    }
</script>

<style scoped lang="scss">
    @import '../../sass/app';

    #col1_content {
        display: flex;
        flex-direction: column;
        height: 100%;

        /*#tasks {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            flex-grow: 1;
            align-content: space-between;
            justify-content: space-between;

            .task {
                @media(max-width: 576px) {
                    width: 100%;
                    &:first-child {
                        margin-top: 0;
                    }
                }
                @media(min-width: 576px) {
                    width: 30%;
                    !*&:last-child {
                        margin-right: 35% !important;
                    }*!
                }
                @media(min-width: 1200px) {
                    &:nth-child(2) {
                        margin-right: 35% !important;
                    }
                }
            }
        }*/

        #tasks-title {
            font-size: 2.25rem;
            font-weight: 300;
            text-transform: uppercase;
            margin: 2rem 0;
        }

        #title {
            img {
                max-width: 100%;
            }
        }

    }

    #gracias {
        text-transform: uppercase;
        font-size: 3rem;
    }

    #col2_content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
        font-size: 1.25rem;
        @media(max-width: 768px) and (min-width: 576px) {
            p {
                flex-grow: 1;
            }
        }
    }

    .modal-title {
        span {
            & + br + span {
                font-size: 1rem;
            }
        }
    }

    #tickets_text_container {
        width: fit-content;
        align-self: flex-end;
        @media(max-width: 768px) {
            align-self: center;
        }

        #view_tickets_message {
            text-align: center;
            color: rgba($azul_oscuro, .5);
            text-transform: uppercase;
            font-size: .75rem;
            font-weight: bold;
            letter-spacing: .1rem;
            transition: all .3s ease-in-out;

            &:hover {
                color: $naranja;
            }
        }
    }
</style>
