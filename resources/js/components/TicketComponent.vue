<template>
    <li class="ticket cursor-pointer" v-b-tooltip.hover.right.html :title="tooltipTitle">
        <span>{{ ticket.id }}</span>
        <template v-if="ticket.task_completion">
            <brand-icon v-if="ticket.task_completion.task.type !== 'form'"
                        :brand="ticket.task_completion.task.type"></brand-icon>
            <font-awesome-icon v-else :icon="['fas','comments']"></font-awesome-icon>
        </template>
        <font-awesome-icon v-else icon="check"></font-awesome-icon>
    </li>
</template>

<script>
    import BrandIcon from './BrandIcon';

    export default {
        name: "Ticket",
        components: {BrandIcon},
        data() {
            return {
                tooltipTitle: ''
            }
        },
        props: {
            tooltipHeader: {
                type: String,
                default: '',
            },
            ticket: {
                type: Object,
                default() {
                    return {
                        id: 0,
                        task_completion: {
                            id: 0,
                            task: {
                                id: 0,
                                type: null,
                                created_at: null
                            }
                        }
                    }
                }
            }
        },
        watch: {
            ticket: {
                handler: 'updateTooltip',
                immediate: true
            }
        },
        methods: {
            updateTooltip(ticket) {
                let header = '';
                if (this.tooltipHeader !== '') {
                    header = `<h6>${this.tooltipHeader}</h6>`;
                }
                if (ticket.task_completion) {
                    this.tooltipTitle = `${header}${ticket.task_completion.created_at}`;
                } else {
                    this.tooltipTitle = "";
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    @import '../../sass/app.scss';

    .ticket {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: .5rem;
        border: 1px solid $secondary;
        border-radius: .5rem;
        margin-bottom: .5rem;
        transition: all .3s ease-in-out;

        span {
            font-weight: bold;
        }

        &:hover {
            background: $secondary;
            color: white;
        }
    }
</style>
