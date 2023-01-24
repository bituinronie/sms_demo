import axios from 'axios'
import Vuex from 'vuex'
import Vue from 'vue'

//load Vuex
Vue.use(Vuex);

export const user = {
    namespaced: true,
    state: () => ({
        user: null,
        loginLoading: false,
        loginError: '',
        logoutLoading: false,
        changePasswordError: null,
        changePasswordLoading: false,
        changePasswordSuccess: false
    }),


    getters: {
       getUser: state => state.user,
       getLoginLoading: state => state.loginLoading,
       getLoginError: state => state.loginError,
       getLogoutLoading: state => state.logoutLoading,
       getChangePasswordLoading: state => state.changePasswordLoading,
       getChangePasswordError: state => state.changePasswordError,
    },

    mutations: {
        SET_USER: (state, data) => state.user = data,
        DESTROY_USER: state => state.user = null,
        SET_LOGIN_LOADING: (state, data) => state.loginLoading = data,
        SET_LOGIN_ERROR: (state, data) => state.loginError = data,
        SET_LOGOUT_LOADING: (state, data) => state.logoutLoading = data,
        SET_CHANGE_PASSWORD_LOADING: (state, data) => state.changePasswordLoading = data,
        SET_CHANGE_PASSWORD_SUCCESS: (state, data) => state.changePasswordSuccess = data,
        SET_CHANGE_PASSWORD_ERROR: (state, data) => state.changePasswordError = data,
    },

    actions: {
        login ({commit}, credentials) {
            commit('SET_LOGIN_ERROR', null)
            commit('SET_LOGIN_LOADING', true)
            let url = this.$router.currentRoute.name == 'Student Login' ? 'student/portal/accounts/login' : 'user/accounts/login'
            this.$axios.post(url, credentials)
            .then(response => {
                commit('SET_USER', response.data.results)
                commit('SET_LOGIN_LOADING', false)
                if (this.$router.currentRoute.name == 'Student Login') {
                    this.$router.push({name: 'Student Dashboard'})
                } else {
                    this.$router.push({name: 'Dashboard'})
                } 
            })
            .catch(err => {
                commit('SET_LOGIN_LOADING', false)
                commit('SET_LOGIN_ERROR', err.response.data.message)
            })
        },
        logout ({commit}) {
            commit('SET_LOGOUT_LOADING', true)
            const config = {
                headers: {
                    'Authorization': 'Bearer ' + this.$auth.token
                }
            }
            let url = this.$auth.isEmployee() ? 'user/accounts/logout' : 'student/portal/accounts/logout'
            this.$axios.post(url, {}, config)
            .then(response => {
                commit('DESTROY_USER')
                commit('SET_LOGOUT_LOADING', false)
                this.$router.push({name: 'Landing Page'})
            })
            .catch(err => {
                commit('DESTROY_USER')
                commit('SET_LOGOUT_LOADING', false)
                this.$router.push({name: 'Landing Page'})
            })
        },
        changePassword ({commit}, passwords) {
            commit('SET_CHANGE_PASSWORD_LOADING', true)
            commit('SET_CHANGE_PASSWORD_ERROR', null)
            commit('SET_CHANGE_PASSWORD_SUCCESS', false)
            const config = {
                headers: {
                    'Authorization': 'Bearer ' + this.$auth.token()
                }
            }
            let url = this.$auth.isEmployee() ? 'user/accounts/change-password' : 'student/portal/accounts/change-password'
            this.$axios.post(url, passwords, config)
            .then(response => {
                commit('SET_CHANGE_PASSWORD_LOADING', false)
                commit('SET_CHANGE_PASSWORD_SUCCESS', true)
                commit('SET_USER', response.data.results)
            })
            .catch(err => {
                if (err.response.data.message == "Incorrect Old Password") {
                    commit('SET_CHANGE_PASSWORD_ERROR', err.response.data.message)
                }
                commit('SET_CHANGE_PASSWORD_LOADING', false)
                commit('SET_CHANGE_PASSWORD_SUCCESS', false)
            })
        }
    }
}


