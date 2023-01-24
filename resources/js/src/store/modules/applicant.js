import axios from 'axios'
import Vuex from 'vuex'
import Vue from 'vue'
import { camelCase } from 'lodash';


//load Vuex
Vue.use(Vuex);

export const applicant = {
    namespaced: true,
    state: () => ({
        applicantData: {},
        submitLoading: false,
        applicantError: null,
        registrationLoading: false
    }),

    getters: {
       getApplicant: state => state.applicantData,
       getSubmitLoading: state => state.submitLoading,
       getRegistrationLoading: state => state.registrationLoading,
       getApplicantError: state => state.applicantError
    },

    mutations: {
        SAVE_APPLICANT: (state, applicantData) => state.applicantData = applicantData,
        DESTROY_APPLICANT: (state) => state.applicantData = {},
        SET_SUBMIT_LOADING: (state, data) => state.submitLoading = data,
        SET_REGISTRATION_LOADING: (state, data) => state.registrationLoading = data,
        SET_APPLICANT_ERROR: (state, data) => state.applicantError = data,
    },

    actions: {
        saveApplicant ({commit}, applicantData) {
            commit('SAVE_APPLICANT', applicantData)
        },
        submitApplicant ({commit}, applicantData) {
            applicantData.applicantStatus = 'PENDING'

            commit('SET_SUBMIT_LOADING', true)

            var formData = new FormData();

            for ( var key in applicantData ) {
                formData.append(key, applicantData[key]);
            }

            var url = ''
            var config = {}

            if (this.$auth.isEmployee()) {
                url = 'admission/applicants/create'
                config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Authorization': 'Bearer ' + this.$auth.token()
                    }
                }
            } 
            else {
                url = 'admission/applicants/online/create'
                config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }
            }

            this.$axios.post(url, formData, config)
                .then(res => {
                    if (res.data.message == "Student Successfully Added") {
                        commit('DESTROY_APPLICANT')
                        commit('SET_SUBMIT_LOADING', false)
                        if (this.$auth.isEmployee()) {
                            this.$router.push({ name: 'View Applicant', params: {id: res.data.results.studentNumber} })
                        } else {
                            this.$router.push({name: 'Success Applicant', params: {id: res.data.results.studentNumber}})
                        }
                    }
                })
                .catch(err => {
                    commit('SET_SUBMIT_LOADING', false)
                    commit('SET_APPLICANT_ERROR', err.response.data.results)
                })
        },
        resetApplicant({commit}) {
            commit('DESTROY_APPLICANT')
        },
        getApplicant({commit}, id) {
            commit('SET_REGISTRATION_LOADING', true)
            const config = {
                headers: {
                        'Authorization': 'Bearer ' + this.$auth.token()
                    }
            }
            this.$axios.get(`admission/applicants/${id}`, config)
                .then(res => {
                    commit('SAVE_APPLICANT', res.data.results)
                    commit('SET_REGISTRATION_LOADING', false)
                })
                .catch(err => {
                    console.error(err)
                    commit('SET_REGISTRATION_LOADING', false)
                })
        },
        updateApplicant({commit}, applicantData) {

            commit('SET_SUBMIT_LOADING', true)

            applicantData.branch = applicantData.branch.code
                if (applicantData.program) {
                    applicantData.program = applicantData.program.code
                }
                if (applicantData.strand) {
                    applicantData.strand = applicantData.strand.code
                }

            var formData = new FormData();

            for ( var key in applicantData ) {
                if (applicantData[key]) {
                    formData.append(key, applicantData[key]);
                }  
            }

            const config = {
                headers: {
                    'Content-Type' : 'multipart/form-data',
                    'Authorization': 'Bearer ' + this.$auth.token()
                }
            }

            formData.append('_method', 'PUT')
            
            this.$axios.post('admission/applicants/update/' + applicantData.priorityNumber, formData, config)
                .then(res => {
                    commit('SET_SUBMIT_LOADING', false)
                    this.$router.push({name: 'View Applicant', params: {id: res.data.results.studentNumber}})
                })
                .catch(err => {
                    commit('SET_SUBMIT_LOADING', false)
                    console.error(err)
                })
        }
    }
}
