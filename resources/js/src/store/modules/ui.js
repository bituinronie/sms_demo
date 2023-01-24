import axios from 'axios'
import Vuex from 'vuex'
import Vue from 'vue'

//load Vuex
Vue.use(Vuex);

export const ui = {
    namespaced: true,
    state: () => ({
        drawer: true,
        darkMode: false,
    }),

    mutations: {
        SET_DRAWER: (state, data) => state.drawer = data,
        SET_DARK_MODE: (state, data) => state.darkMode = data,
    },

    actions: {
        toggleDrawer ({commit, state}) {
            commit('SET_DRAWER', !state.drawer)
        },
        toggleDarkMode ({commit, state}) {
            commit('SET_DARK_MODE', !state.darkMode)
        },
    }
}


