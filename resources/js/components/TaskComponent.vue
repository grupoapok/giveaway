<template>
    <div class="task-container"
         :class="[task.class,task.completed && 'done', this.executed && 'completed']"
         @click="askForExtras">

        <moon-spinner v-if="loading"></moon-spinner>
        <template v-else>
            <brand-icon v-if="!task.icon" class="icon" :brand="task.type"></brand-icon>
            <font-awesome-icon v-else :icon="task.icon" class="icon"></font-awesome-icon>
        </template>

        <font-awesome-icon icon="check" class="text-secondary" size="3x"
                           v-if="!canExecute"></font-awesome-icon>
        <template v-else>
            <p v-if="lang[task.type]" v-html="lang[task.type]">{{ task.description }}</p>
            <p v-else>{{ task.description }}</p>
        </template>

        <b-modal id="tickets_list" v-model="showExtraModal" centered hide-footer>
            <h5 class="modal-title text-dark font-weight-bold" slot="modal-title">
                {{ task.type | capitalize}}
            </h5>
            <form @submit.prevent="executeTask">
                <div class="form-group" v-for="(extra,i) in task.extras" :key="`extra_${i}`">
                    <label>{{ extra['label'] }}</label>
                    <input class="form-control" type="text" v-model="extraModel[extra.name]">
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">
                        <font-awesome-icon icon="check"></font-awesome-icon>
                    </button>
                </div>
            </form>
        </b-modal>

        <!--<div class="modal fade" ref="extra_modal">
            <form @submit.prevent="executeTask">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark font-weight-bold">
                                {{ task.type | capitalize}}
                            </h5>
                            <button type="button" class="text-dark close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" v-for="(extra,i) in task.extras" :key="`extra_${i}`">
                                <label>{{ extra['label'] }}</label>
                                <input class="form-control" type="text" v-model="extraModel[extra.name]">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                <font-awesome-icon icon="check"></font-awesome-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>-->

    </div>
</template>

<script>
    import {mapActions, mapState} from 'vuex';
    import BrandIcon from './BrandIcon';

    export default {
        name: "Task",
        components: {BrandIcon},
        data() {
            return {
                showExtraModal: false,
                extraModel: {},
                executed: false,
                loading: false,
                lang: {},
            }
        },
        props: {
            task: {
                type: Object,
                default: {
                    id: 0,
                    url: null,
                    description: null,
                    completed: false,
                    type: null,
                    repeatable: false,
                    tickets: 0,
                    extras: []
                }
            },
            autoExecute: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            ...mapState(['email']),
            canExecute() {
                return this.task.repeatable || !this.task.completed;
            },
            hasExtras() {
                return !!this.task.extras && this.task.extras.length > 0;
            }
        },
        methods: {
            ...mapActions(["updateUserInfo", "updateTicketsList"]),
            askForExtras() {
                if (this.canExecute) {
                    if (this.hasExtras) {
                        this.showExtraModal = true;
                    } else {
                        this.executeTask();
                    }
                }
            },
            executeTask() {
                this.showExtraModal = false;
                if (this.canExecute) {
                    if (this.task.url) {
                        window.open(this.task.url.replace(":email", this.email), '_blank');
                        return
                    }

                    this.loading = true;
                    let promise = null;
                    if (this.task.type === 'facebook') {
                        promise = this.facebookTask();
                    } else if (this.task.type === 'linkedin') {
                        promise = this.linkedInTask();
                    } else if (this.task.type === 'twitter') {
                        promise = this.twitterTask();
                    } else if (this.task.type === 'instagram') {
                        promise = this.instagramTask();
                    }

                    if (promise === null) {
                        this.loading = false;
                        return
                    }

                    promise.then(this.markTaskAsCompleted)
                        .then(response => {
                            this.updateUserInfo({tickets: response.tickets});
                            this.executed = true;
                            this.loading = false;
                            this.updateTicketsList();
                            this.notifyTaskCompleted()
                        })
                        .catch(error => {
                            console.error(error);
                            if (error.response && error.response.data.url) {
                                window.location = error.response.data.url;
                            }
                            this.loading = false;
                        });
                }
            },
            markTaskAsCompleted() {
                const extras = {};
                if (this.hasExtras) {
                    this.task.extras.forEach(e => {
                        extras[e.name] = this.extraModel[e.name];
                        this.extraModel[e.name] = '';
                    })
                }
                return this.$axios.post(`/tasks/${this.task.id}/complete`, {
                    data: {extras}
                }).then(({data}) => data.data);
            },
            notifyTaskCompleted() {
                setTimeout(() => {
                    this.$emit('taskCompleted', this.task.id)
                }, 1000) //Wait 1 sec for the animation to finish
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
            },
            instagramTask() {
                return new Promise((resolve) => {
                    window.open('https://www.instagram.com/grupoapok', '_blank');
                    resolve();
                })
            }
        },
        mounted() {
            if (this.autoExecute) {
                this.executeTask();
                this.$cookies.remove("execute_task");
            }
            this.$axios.get(`/lang/task/${this.task.id}`)
                .then(({data}) => this.lang = data);
        }
    }
</script>

<style scoped lang="scss">
    @import "../../sass/app";

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

    label {
        color: initial;
    }

    .form-control {
        border-width: 1px !important;
        border-color: $primary !important;
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
