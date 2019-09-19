<template>
    <div class="task-container" :class="[task.class,task.completed && 'done', this.executed && 'completed']"
         @click="executeTask">

        <moon-spinner v-if="loading"></moon-spinner>
        <template v-else>
            <brand-icon v-if="!task.icon" class="icon" :brand="task.type"></brand-icon>
            <font-awesome-icon v-else :icon="task.icon" class="icon"></font-awesome-icon>
        </template>

        <font-awesome-icon icon="check" class="text-secondary" size="3x" v-if="!task.repeatable && task.completed"></font-awesome-icon>
        <p v-else v-html="lang[task.type]">{{ task.description }}</p>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import BrandIcon from './BrandIcon';
    import LangMixin from './lang_mixin';

    export default {
        name: "Task",
        mixins: [LangMixin('tasks')],
        components: {BrandIcon},
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
                    repeatable: false,
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
            notifyTaskCompleted() {
                setTimeout(() => {
                    this.$emit('taskCompleted', this.task.id)
                }, 1000) //Espero 1seg para que termine la animacion
            },
            markTaskAsCompleted() {
                return this.$axios.post(`/tasks/${this.task.id}/complete`).then(({data}) => data.data)
            },
            executeTask() {
                if (this.task.repeatable || !this.task.completed) {
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
                            this.updateUserInfo({tickets: response.tickets});
                            this.executed = true;
                            this.loading = false;
                            this.notifyTaskCompleted()
                        })
                        .catch(error => {
                            if (error.response && error.response.data.url) {
                                window.location = error.response.data.url;
                            }
                            this.loading = false;
                        });
                }
            },
            facebookTask() {
                return new Promise((resolve, reject) => {
                    FB.ui({
                        method: 'share_open_graph',
                        action_type: 'og.likes',
                        action_properties: JSON.stringify({
                            object: `${process.env.MIX_APP_URL}`,
                        })
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
                return this.$axios.post('/share/linkedin')
            },
            twitterTask() {
                return this.$axios.post('/share/twitter')
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
    @import "../sass/app";

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

        &.secondary {
            background: $secondary;
        }
        &.done {
            background: $azul_oscuro2;
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
