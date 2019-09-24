<template>
    <div>
        <p>
        <router-link class="btn btn-success" :to="{ name: 'TasksNew' } ">New Task</router-link>
        </p>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th v-for="(field, j) in fields" :key="`field_label_${j}`">
                        {{ field.label }}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,i) in list[currentPage]" :key="`item_${i}`">
                    <td v-for="(field, j) in fields" :key="`field_${i}_${j}`">
                        <template v-if="field.formatter">
                            {{ field.formatter(item[field.name]) }}
                        </template>
                        <template v-else>
                            {{ item[field.name] }}
                        </template>
                    </td>
                    <td>
                        <b-button variant="primary" @click="() => { doEdit(item.id) }">Edit</b-button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from 'vuex';
    import ListMixin from "../../../../mixin/ListMixin";

    export default {
        name: 'TasksList',
        mixins: [ListMixin('tasks')],
        data() {
            return {
                filters: {
                    filter1: null,
                },
                filtersFields: [
                    {
                        model: 'filter1',
                    },
                    {
                        model: 'filter2',
                        type: 'select',
                        props: {
                            options: [
                                {value: 1, text: 'Filter 1'},
                                {value: 2, text: 'Filter 2'},
                                {value: 3, text: 'Filter 3'},
                                {value: 4, text: 'Filter 4'},
                            ]
                        }
                    },
                    {
                        placeholder: 'Filter 3',
                        model: 'filter3',
                        class: 'col-sm-6'
                    }
                ],
                fields: [
                    {name: 'id', label: 'Id'},
                    {name: 'type', label: 'Type'},
                    {name: 'tickets', label: 'Tickets'},
                    {name: 'repeatable', label: 'Repeatable', formatter: this.formatBoolean},
                    {name: 'confirm_type', label: 'Confirmation Type'}
                ],
            }
        },
        computed: {
            ...mapState('tasks', ['result1', 'result2']),
        },
        methods: {
            ...mapActions('tasks', ['action1', 'action1GQL', 'action2']),
            filtersUpdated() {
                console.log(this.filters)
            },
            doEdit(id) {
                this.$router.push({name: 'TasksForm', params: {id}})
            },
            formatBoolean(val) {
                if (val) {
                    return "Yes";
                }
                return "No";
            }
        },
    }
</script>

<style>

</style>
