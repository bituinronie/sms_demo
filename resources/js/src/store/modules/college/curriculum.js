import axios from 'axios'
import Vuex from 'vuex'
import Vue from 'vue'
import { camelCase } from 'lodash';


//load Vuex
Vue.use(Vuex);

export const curriculum = {
    namespaced: true,
    state: () => ({
        curriculum: {},
        curriculumLoading: false,
    }),
    mutations: {
        SET_CURRICULUM: (state, data) => state.curriculum = data,
        SET_CURRICULUM_LOADING: (state, data) => state.curriculumLoading = data,
    },
    actions: {
        createCurriculum({commit}, data) {
            this.$axios.post(`college/curriculums/create`, data)
                .then(res => {
                    this.$router.push({name: 'Curriculum'})
                })
                .catch(err => {
                    console.error(err.response)
                })
        },
        getCurriculum({commit}, branch) {
            commit('SET_CURRICULUM_LOADING', true)
            const id = this.$router.currentRoute.params.id
            return this.$axios.get(`college/curriculums/${branch}/${id}`)
                .then(res => {
                    commit('SET_CURRICULUM', res.data.results)
                    commit('SET_CURRICULUM_LOADING', false)
                })
                .catch(err => {
                    commit('SET_CURRICULUM_LOADING', false)
                    console.error(err.response)
                })
        },
        updateCurriculum({commit}, data) {
            let curr = data
            curr.branch = data.branch.code
            curr.department = data.department.code
            curr.program = data.program.code
            this.$axios.put(`college/curriculums/update/${curr.branch}/${curr.code}`, curr)
                .then(res => {
                    this.$router.push({name: 'Curriculum'})
                })
                .catch(err => {
                    console.error(err.response)
                })
        },
    }
}
