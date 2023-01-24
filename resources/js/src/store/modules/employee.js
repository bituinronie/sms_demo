import axios from 'axios'
import Vuex from 'vuex'
import Vue from 'vue'
import { camelCase } from 'lodash';


//load Vuex
Vue.use(Vuex);

export const employee = {
    namespaced: true,
    state: () => ({
        employeeData: {},
        submitLoading: false,
        employeeError: null,
        employeeLoading: false,
        employees: [],
    }),
    getters: {
       getEmployee: state => state.employeeData,
       getSubmitLoading: state => state.submitLoading,
       getRegistrationLoading: state => state.employeeLoading,
       getEmployeeError: state => state.employeeError,
    },
    mutations: {
        SAVE_EMPLOYEE: (state, data) => state.employeeData = data,
        DESTROY_EMPLOYEE: (state) => state.employeeData = {},
        SET_SUBMIT_LOADING: (state, data) => state.submitLoading = data,
        SET_EMPLOYEE_LOADING: (state, data) => state.employeeLoading = data,
        SET_EMPLOYEE_ERROR: (state, data) => state.employeeError = data,
        SET_EMPLOYEES: (state, data) => state.employees = data,
    },
    actions: {
        saveEmployee ({commit}, employeeData) {
            commit('SAVE_EMPLOYEE', employeeData)
        },
        submitEmployee ({commit}, employeeData) {
            commit('SET_SUBMIT_LOADING', true)

            var formData = new FormData();

            for ( var key in employeeData ) {
                formData.append(key, employeeData[key]);
            }

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Authorization': 'Bearer ' + this.$auth.token()
                }
            }

            this.$axios.post('human-resource/employees/create', formData, config)
                .then(res => {
                    commit('DESTROY_EMPLOYEE')
                    commit('SET_SUBMIT_LOADING', false)
                    this.$router.push({ 
                        name: 'View Employee', 
                        params: {id: res.data.results.employeeNumber} 
                    })
                })
                .catch(err => {
                    commit('SET_SUBMIT_LOADING', false)
                    commit('SET_EMPLOYEE_ERROR', err.response.data.results)
                })
        },
        resetEmployee({commit}) {
            commit('DESTROY_EMPLOYEE')
        },
        getEmployee({commit}) {
            commit('SET_EMPLOYEE_LOADING', true)
            const id =  this.$router.currentRoute.params.id
            const config = {
                headers: {
                        'Authorization': 'Bearer ' + this.$auth.token()
                    }
            }
            this.$axios.get(`human-resource/employees/${id}`, config)
                .then(res => {
                    commit('SAVE_EMPLOYEE', res.data.results)
                    commit('SET_EMPLOYEE_LOADING', false)
                })
                .catch(err => {
                    console.error(err)
                    commit('SET_EMPLOYEE_LOADING', false)
                })
        },
        updateEmployee({commit}, employeeData) {

            commit('SET_SUBMIT_LOADING', true)

            employeeData.branch = employeeData.branch.code
            employeeData.department = employeeData.department.code

            var formData = new FormData();

            for ( var key in employeeData ) {
                if (employeeData[key]) {
                    formData.append(key, employeeData[key]);
                }  
            }

            const config = {
                headers: {
                    'Content-Type' : 'multipart/form-data',
                    'Authorization': 'Bearer ' + this.$auth.token()
                }
            }

            formData.append('_method', 'PUT')
            
            this.$axios.post('human-resource/employees/update/' + employeeData.employeeNumber, formData, config)
                .then(res => {
                    commit('SET_SUBMIT_LOADING', false)
                    this.$router.push({
                        name: 'View Employee', 
                        params: {id: res.data.results.employeeNumber}
                    })
                })
                .catch(err => {
                    commit('SET_SUBMIT_LOADING', false)
                    console.error(err)
                })
        },
        getEmployees({commit}) {
            this.$axios.get(`human-resource/employees`)
                .then(res => {
                    commit('SET_EMPLOYEES', res.data.results)
                })
                .catch(err => {
                    console.error(err)
                })
        },
        
    }
}
