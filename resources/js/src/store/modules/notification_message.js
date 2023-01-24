import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex);
export const notificationMessage = {
    namespaced: true,
    state: () => ({
        message: null,
        redirectMessage: null,
        secondRedirect: null,
        otherMessage: null,
        errorMessage: null,

    }),

    getters: {
        getterMessage: state => state.message,
        getterRedirectMessage: state => state.redirectMessage,
        getterSecondRedirect: state => state.secondRedirect,
        getterOtherMessage: state => state.otherMessage,
        getterErrorMessage: state => state.errorMessage
    },

    mutations: {
        SET_MESSAGE(state, message) {
            state.message = message
        },
        SET_REDIRECT_MESSAGE(state, message) {
            state.redirectMessage = message
        },
        SET_SECOND_REDIRECT(state, message) {
            state.secondRedirect = message
        },
        SET_OTHER_MESSAGE(state, message) {
            state.otherMessage = message
        },
        SET_ERROR_MESSAGE(state, message) {
            state.errorMessage = message
        }
    },

    actions: {
        resetMessage({
            commit
        }) {
            commit('SET_MESSAGE', null)
        },
        resetRedirectMessage({
            commit
        }) {
            commit('SET_REDIRECT_MESSAGE', null)
        },
         resetSecondRedirect({
            commit
        }) {
            commit('SET_SECOND_REDIRECT', null)
        },
        resetOtherMessage({
            commit
        }) {
            commit('SET_OTHER_MESSAGE', null)
        },
         resetErrorMessage({
            commit
        }) {
            commit('SET_ERROR_MESSAGE', null)
        }
    }
}
