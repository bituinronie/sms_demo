import axios from 'axios'
import Vuex from 'vuex'
import Vue from 'vue'
import { camelCase } from 'lodash';


//load Vuex
Vue.use(Vuex);

export const subject = {
    namespaced: true,
    state: () => ({
        subjects: [],
        availableSubjects: [],
    }),
    mutations: {
        SET_SUBJECTS: (state, data) => state.subjects = data,
        SET_AVAILABLE_SUBJECTS: (state, data) => state.availableSubjects = data,
    },
    actions: {
        getSubjects({commit}) {
            const config = {
                headers: {
                        'Authorization': 'Bearer ' + this.$auth.token()
                    }
            }
            this.$axios.get(`college/subjects/`, config)
                .then(res => {
                    commit('SET_SUBJECTS', res.data.results)
                    commit('SET_AVAILABLE_SUBJECTS', res.data.results)
                })
                .catch(err => {
                    console.error(err)
                })
        },
        removeSubject({commit, state}, subjectCode) {
            let data = state.availableSubjects
            data = data.filter(subject => subject.code != subjectCode)
            commit('SET_AVAILABLE_SUBJECTS', data)
        },
        addSubject({commit, state}, subjectCode) {
            let data = state.availableSubjects
            data.push(state.subjects.find(val => val.code == subjectCode))
            commit('SET_AVAILABLE_SUBJECTS', data)
        }
    }
}
