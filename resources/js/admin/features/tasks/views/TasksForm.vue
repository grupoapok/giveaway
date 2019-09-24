<template>
    <b-form @submit.prevent="doSubmit">
        <b-form-row>
            <b-col>
                <b-form-group label="Type" label-class="mb-2">
                    <input type="hidden" v-model="task.id">
                    <b-input v-model="task.type" :disabled="loading"></b-input>
                </b-form-group>
            </b-col>
            <b-col>
                <b-form-group label="Tickets" label-class="mb-2">
                    <b-input type="number" :disabled="loading" v-model="task.tickets"></b-input>
                </b-form-group>
            </b-col>
            <b-col>
                <b-form-group label="Confirmation Type" label-class="mb-2">
                    <b-form-select v-model="task.confirm_type" :disabled="loading" plain :options="['auto','manual']"></b-form-select>
                </b-form-group>
            </b-col>
        </b-form-row>
        <b-form-row>
            <b-col>
                <b-form-group label="Description" label-class="mb-2">
                    <b-textarea v-model="task.description" :disabled="loading"/>
                </b-form-group>
            </b-col>
        </b-form-row>
        <h2 class="mt-4" v-if="task.extras && task.extras.length">
            Extras
            <button type="button" class="btn btn-light" :disabled="loading" @click="addExtra">New Extra</button>
        </h2>
        <b-form-row v-for="(extra,i) in task.extras" :key="`extra_${i}`">
            <b-col>
                <b-form-group label="Name" label-class="mb-2">
                    <b-input v-model="extra.name" :disabled="loading"></b-input>
                </b-form-group>
            </b-col>
            <b-col>
                <b-form-group label="Label" label-class="mb-2">
                    <b-input v-model="extra.label" :disabled="loading"></b-input>
                </b-form-group>
            </b-col>
            <b-col>
                <b-button type="button" variant="danger" v-if="task.extras.length > 1" @click="deleteExtra(i)">
                    <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                </b-button>
            </b-col>
        </b-form-row>
        <b-button type="submit" variant="primary" :disabled="loading">
            <b-spinner v-if="loading" small></b-spinner>
            <template v-else>Aceptar</template>
        </b-button>
        <b-button type="button" variant="secondary" @click="goBack">Cancelar</b-button>
    </b-form>

</template>

<script>
    import {mapActions, mapState} from 'vuex';
    import cloneDeep from 'lodash/cloneDeep';

    export default {
        name: "TasksForm",
        data() {
            return {
                task: {
                    id: 0
                },
                fields: [],
            };
        },
        props: ['id'],
        computed: {
            ...mapState('tasks', ['currentItem', 'loading'])
        },
        watch: {
            currentItem(newVal) {
                if (newVal && newVal.id) {
                    this.task = cloneDeep(newVal);
                }
            }
        },
        methods: {
            ...mapActions('tasks', ['getItem', 'saveItem']),
            goBack() {
                this.$router.go(-1);
            },
            addExtra() {
                this.task.extras.push({
                    name: '',
                    label: ''
                })
            },
            doSubmit() {
                this.saveItem({ ...this.task, extras: JSON.stringify(this.task.extras) })
                    .then(() => {
                        this.$router.go(-1);
                    });
            },
            deleteExtra(i) {
                this.task.extras.splice(i,1);
            }
        },
        mounted() {
            if (parseInt(this.id,10) !== 0) {
                this.getItem(this.id);
            }
        }
    };
</script>

<style scoped lang="scss">
    .form-group {
        .form-control {
            border-width: 1px !important;
        }
    }
</style>
