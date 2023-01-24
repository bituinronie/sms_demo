import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex);
export const loading = {
    namespaced: true,
    state: () => ({
        pageLoading: true,
        partLoading: true,
    }),

    getters: {
        getterPageLoading: state => state.pageLoading,
        getterPartLoading: state => state.partLoading,
    },

    mutations: {
        SET_PAGE_LOADING(state, loading) {
            state.pageLoading = loading
        },
        SET_PART_LOADING(state, loading) {
            state.partLoading = loading
        },
    },

    actions: {
        resetPageLoading({ commit }) {
            commit('SET_PAGE_LOADING', true)
        },
        resetPartLoading({ commit }) {
            commit('SET_PART_LOADING', true)
        },
        setPageLoading({ commit }) {
            commit('SET_PAGE_LOADING', false)
        },
    }
}
