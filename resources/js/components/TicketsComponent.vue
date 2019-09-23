<template>
    <div id="tickets_chunks">
        <ul v-for="(chunk, i) in chunkedTickets" :key="`chunk_${i}`">
            <ticket
                v-for="ticket in chunk"
                :key="`ticket_${ticket.id}`"
                :ticket="ticket"
                :tooltip-header="tooltipHeader"
            ></ticket>
        </ul>
    </div>
</template>

<script>
    import chunk from 'lodash/chunk';
    import Ticket from './TicketComponent';

    export default {
        name: "Tickets",
        components: {Ticket},
        props: {
            tooltipHeader: {
                type: String,
                default: '',
            },
            tickets: {
                type: Array,
                default() {
                    return [];
                }
            }
        },
        computed: {
            chunkedTickets() {
                if (this.tickets.length) {
                    if (Array.isArray(this.tickets[0])) {
                        return this.tickets;
                    } else {
                        return chunk(this.tickets, 5);
                    }
                }
                return [];
            }
        }
    }
</script>

<style scoped lang="scss">
    #tickets_chunks {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: center;

        ul {
            padding: 0;
            margin-bottom: 0;
            flex-shrink: 0;
            flex-basis: 25%;
            max-width: 22%;
            list-style-type: none;
        }
    }
</style>
