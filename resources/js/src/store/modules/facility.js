import axios from 'axios'
import Vuex from 'vuex'
import Vue from 'vue'
import { camelCase } from 'lodash';


//load Vuex
Vue.use(Vuex);

export const facility = {
    namespaced: true,
    state: () => ({
        laboratories: [],
        rooms: [],
    }),
    mutations: {
        SET_LABORATORIES: (state, data) => state.laboratories = data,
        SET_ROOMS: (state, data) => state.rooms = data,
    },
    actions: {
        getLaboratories({commit}) {
            this.$axios.get(`facility/laboratories/`)
                .then(res => {
                    commit('SET_LABORATORIES', res.data.results)
                })
                .catch(err => {
                    console.error(err)
                })
        },
        getRooms({commit}) {
            this.$axios.get(`facility/rooms/`)
                .then(res => {
                    commit('SET_ROOMS', res.data.results)
                })
                .catch(err => {
                    console.error(err)
                })
        },
        
    }
}
