<template>
    <div class="task-container" :class="[task.class,task.completed && 'done', this.executed && 'completed']"
         @click="executeTask">
        <moon-spinner v-if="loading"></moon-spinner>
        <i v-else :class="['icon', iconClass]"></i>
        <p>{{ task.description }}</p>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        name: "Task",
        data() {
            return {
                executed: false,
                loading: false
            }
        },
        props: {
            task: {
                type: Object,
                default: {
                    id: 0,
                    description: null,
                    completed: false,
                    type: null,
                    tickets: 0,
                }
            },
            autoExecute: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            iconClass() {
                return `icon-${this.task.type}-logo`
            },
            isValid() {
                return this.task.id > 0;
            }
        },
        methods: {
            ...mapActions(["updateUserInfo"]),
            notifyTaskCompleted(){
                setTimeout(() => {
                    this.$emit('taskCompleted', this.task.id)
                }, 1000) //Espero 1seg para que termine la animacion
            },
            markTaskAsCompleted(){
                return this.$axios.post(`/tasks/${this.task.id}/complete`).then(({data}) => data.data)
            },
            executeTask() {
                if (this.isValid) {
                    this.loading = true;
                    let promise = null;
                    if (this.task.type === 'facebook') {
                        promise = this.facebookTask();
                    } else if (this.task.type === 'linkedin') {
                        promise = this.linkedInTask();
                    } else if (this.task.type === 'twitter') {
                        promise = this.twitterTask();
                    }

                    promise
                        .then(this.markTaskAsCompleted)
                        .then(response => {
                            this.updateUserInfo({ tickets: response.tickets});
                            this.executed = true;
                            this.loading = false;
                            this.notifyTaskCompleted()
                        })
                        .catch(() => {
                            this.loading = false;
                        });
                }
            },
            facebookTask() {
                return new Promise((resolve, reject) => {
                    FB.ui({
                        method: 'share',
                        quote: 'Hey Listen'
                    }, function (response) {
                        if (response && !response.error_message) {
                            resolve();
                        } else {
                            reject('error');
                        }
                    });
                });
            },
            linkedInTask() {
                return this.$axios.post('/share/linkedin', null)
                    .catch(error => {
                        if (error.response.data.goto) {
                            window.location = error.response.data.goto;
                            throw new Error("Unauthorized");
                        }
                    })
            },
            twitterTask() {
                return new Promise((resolve, reject) => {
                    if (!this.$cookies.get("twitter_token")) {
                        return this.$axios.post('/twitter/token')
                            .then(response => {
                                if (response.data.data) {
                                    window.location = response.data.data;
                                    reject()
                                }
                            }).catch(reject)
                    } else {
                        return this.$axios.post('/share/twitter').then(resolve).catch(reject)
                    }
                })
            }
        },
        mounted() {
            if (this.autoExecute) {
                this.executeTask();
                this.$cookies.remove("execute_task")
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../sass/colors";

    moon-spinner {
        --moon-spinner__color: #FFF;
    }

    .task-container {
        cursor: pointer;
        display: flex;
        flex-direction: column;
        height: 220px;
        background: #00AED1;
        border-radius: 10px;
        padding: 32px;
        align-items: center;
        justify-content: space-between;
        color: white;

        &.naranja {
            background: $naranja;
        }
        &.done {
            background: $azul_oscuro;
        }

        &.completed {
            animation: flip ease-in-out 1s forwards;
        }

        .icon {
            font-size: 4.375rem;
        }

        p {
            font-size: .75rem;
            text-align: center;
            font-weight: bold;
            margin-bottom: 0 !important;
        }
    }

    @keyframes flip {
        0% {
            transform: none;
        }
        50% {
            transform: rotateY(90deg);
        }
        100% {
            transform: none;
            background: $azul_oscuro2;
        }
    }
</style>