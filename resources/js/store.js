import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        name: '',
        email: '',
        tickets: 0,
        alignRight: false
    },
    mutations: {
        alignRight(state, val){
            state.alignRight = val;
        },
        updateUserInfo(state, payload) {
            if (payload) {
                if (payload.name) {
                    state.name = payload.name;
                }
                if (payload.email) {
                    state.email = payload.email;
                }
                if (payload.tickets) {
                    state.tickets = parseInt(payload.tickets, 10);
                }
            }
        },
        updateTickets(state, n){
            state.tickets = parseInt(n, 10);
        }
    },
    actions: {
        updateTickets(context, n) {
            context.commit('updateTickets', n);
        },
        updateUserInfo(context, payload) {
            context.commit('updateUserInfo', payload);
        },
        alignElementsToRight(context) {
            context.commit('alignRight', true);
        },
        alignElementsToLeft(context) {
            context.commit('alignRight', false);
        }
    }
});

export default store;
