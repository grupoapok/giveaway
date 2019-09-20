<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <layout>
        <template v-slot:col1>
            <div id="col1_content">
                <div id="title">
                    <img :src="vector"/>
                </div>

                <p id="tasks-title" class="text-secondary" v-html="lang.available_tasks"></p>

                <div id="tasks">
                    <task class="task mb-4 mb-xl-0"
                          :key="`task_${i}`"
                          v-for="(t,i) in tasks"
                          @taskCompleted="completeTask"
                          :auto-execute="$cookies.get('execute_task') === t.type"
                          :task="t"></task>
                </div>
            </div>
        </template>
        <template v-slot:col2>
            <div id="col2_content" class="text-center text-lg-right">
                <p id="gracias" class="text-secondary" v-html="lang.thanks"></p>
                <p v-html="lang.text_1"></p>
                <p class="text-dark">
                    <template v-if="tickets === 0" v-html="lang.no_tickets"></template>
                    <template v-else>
                        <span v-html="ticketsMessage"></span>
                    </template>
                </p>
            </div>
        </template>
    </layout>
</template>

<script>
    import Layout from './Layout';
    import Task from './TaskComponent';
    import vector from '../../img/page2_text.svg';
    import {mapActions, mapState} from 'vuex';
    import LangMixin from '../mixin/lang';

    export default {
        name: "Page2Component",
        mixins: [LangMixin('step2')],
        components: {Layout, Task},
        data() {
            return {
                vector,
                tasks: []
            }
        },
        computed: {
            ...mapState(['tickets']),
            ticketsMessage() {
                return this.lang['ticket_number'].replace(":tickets",this.tickets)
            }
        },
        methods: {
            ...mapActions(['alignElementsToRight', 'updateUserInfo']),
            loadTasks() {
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
            }
        },
        mounted() {
            this.loadTasks();
            this.alignElementsToRight();
        }
    }
</script>

<style scoped lang="scss">
    #col1_content {
        display: flex;
        flex-direction: column;
        height: 100%;

        #tasks {
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
                    &:last-child {
                        margin-right: 35% !important;
                    }
                }
                @media(min-width: 1200px) {
                    &:nth-child(2n) {
                        margin-right: 35% !important;
                    }
                    /*&:last-child {
                        margin-right: 0 !important;
                    }*/
                }
            }
        }

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
            flex-direction: row;
            p {
                flex-grow: 1;
            }
        }
    }
</style>
