import Vue from 'vue';
import {
    CHANGE_PAGE,
    DELETE_ITEM,
    GET_ITEM,
    GET_ITEM_LIST,
    RESET_ITEM,
    RESET_LIST,
    SAVE_ITEM,
} from "../../../store/ListTypes";

export const getItemList = (context, {page, size}) => {
    return new Promise((resolve, reject) => {
        context.commit(GET_ITEM_LIST, {meta: 'PENDING'});
        Vue.$axios.get(`tasks?page=${page}&size=${size}`)
            .then(r => {
                context.commit(GET_ITEM_LIST, {meta: 'SUCCESS', data: r.data});
                resolve();
            })
            .catch(() => {
                context.commit(GET_ITEM_LIST, {meta: 'ERROR'});
                reject();
            })
    });
};

export const resetList = context => context.commit(RESET_LIST);

export const changePage = (context, page) => context.commit(CHANGE_PAGE, parseInt(page, 10));

export const getItem = (context, id) => {
    return new Promise((resolve, reject) => {
        context.commit(GET_ITEM, {meta: 'PENDING'});
        Vue.$axios.get(`tasks/${id}`)
            .then(r => {
                context.commit(GET_ITEM, {meta: 'SUCCESS', data: r.data});
                resolve();
            })
            .catch(() => {
                context.commit(GET_ITEM, {meta: 'ERROR'});
                reject();
            })
    });
};

export const resetItem = context => context.commit(RESET_ITEM);

export const deleteItem = (context, id) => context.commit(DELETE_ITEM, id);

export const saveItem = (context, data) => {
    let savePromise;
    if (data.id !== 0) {
        savePromise = Vue.$axios.put(`tasks/${data.id}`, data)
    } else {
        savePromise = Vue.$axios.post(`tasks`, data);
    }
    return new Promise((resolve, reject) => {
        context.commit(SAVE_ITEM, {meta: 'PENDING'});
        return savePromise
            .then((response) => {
                context.commit(SAVE_ITEM, {meta: 'SUCCESS', data: response.data});
                resolve();
            })
            .catch((error) => {
                context.commit(SAVE_ITEM, {meta: 'ERROR', data: error});
                reject(error);
            });
    });
};
