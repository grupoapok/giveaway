<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <layout>
        <template v-slot:col1>
            <div id="col1_content">
                <div id="title">
                    <img :src="vector"/>
                </div>

                <p id="tasks-title" class="text-secondary">Misiones disponibles</p>

                <transition-group name="scale-up-down" tag="div" id="tasks">
                    <task class="task mb-4 mb-xl-0"
                          :key="`task_${i}`"
                          v-for="(t,i) in tasks"
                          @taskCompleted="completeTask"
                          :auto-execute="$cookies.get('execute_task') === t.type"
                          :task="t"></task>
                </transition-group>
            </div>
        </template>
        <template v-slot:col2>
            <div id="col2_content" class="text-center text-lg-right">
                <p id="gracias" class="text-secondary"><span>¡Gracias</span> por participar!</p>
                <p>
                    Puedes conseguir más tickets con hacer<br class="d-none d-sm-inline-block">
                    cualquiera de nuestras misiones.<br class="d-none d-sm-inline-block">
                    <span class="font-weight-bold">Más tickets, más oportunidad de ganar</span>
                </p>
                <p v-if="tickets === 1">
                    Tienes 1 ticket
                </p>
                <p v-else-if="tickets > 1">
                    Tienes {{ tickets }} tickets
                </p>
                <p v-else>Aún no posees tickets</p>
            </div>
        </template>
    </layout>
</template>

<script>
    import Layout from './Layout';
    import Task from './TaskComponent';
    import vector from '../img/page2_text.svg';
    import {mapActions, mapState} from 'vuex';

    export default {
        name: "Page2Component",
        components: {Layout, Task},
        data() {
            return {
                vector,
                tasks: [],
            }
        },
        computed: {
            ...mapState(['tickets'])
        },
        methods: {
            ...mapActions(['alignElementsToRight']),
            loadTasks() {
                this.$axios.get('/tasks').then(response => {
                    const newTasks = response.data.data;
                    newTasks.push({
                        id: -1,
                        description: 'No se',
                        type: 'help',
                        class: 'naranja'
                    });
                    this.tasks = newTasks;
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
                    &:nth-child(2) {
                        margin-right: 35% !important;
                    }
                    &:last-child {
                        margin-right: 0 !important;
                    }
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

    #gracias span {
        font-weight: 800;
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