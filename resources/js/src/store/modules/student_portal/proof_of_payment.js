import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex);
export const studentProofOfPayment = {
    namespaced: true,
    state: () => ({
        list: [],
    }),

    getters: {
        getterListOption: state => state.listOption
    },

    mutations: {
        FETCH_LIST(state, data) {
            state.list = data
        },
    },

    actions: {
        getLists({
            commit
        }) {

            commit('loading/SET_PAGE_LOADING', true, {
                root: true
            })

            const config = {
                method: 'get',
                url: 'student/portal/payments',
                // headers: {
                //     'Authorization': 'Bearer ' + this.$auth.token()
                // }
            }
            this.$axios(config)
                .then(response => {

                    let value = response.data.results
                    let other

                    for (var i = 0; i < value.length; i++) {
                        other = value[i].other != null ? ' | ' + value[i].other : ''
                        value[i]['paymentType'] = value[i].paymentOption + other
                        value[i]['random'] = i + Math.random().toString(36).substr(2, 5)
                    }
                    commit('FETCH_LIST', value)

                    commit('loading/SET_PAGE_LOADING', false, {
                        root: true
                    })
                })
                .catch(err => {
                    let message
                    if (err.response.status == 422) {
                        var message_val = err.response.data.results
                        message = Object.values(message_val)[0]
                    } else {
                        message = err.response.data.message
                    }

                    commit('notificationMessage/SET_ERROR_MESSAGE', 'Error: ' + message, {
                        root: true
                    })
                    commit('loading/SET_PAGE_LOADING', null, {
                        root: true
                    })
                })
        },
        submitData({
            commit,
            dispatch
        }, data) {
            let value = {
                paymentOption: data.values.paymentOption,
                amount: data.values.amount,
            }

            if (data.values.paymentOption == 'OTHER') {
                value['other'] = data.values.other
            } else {
                value['other'] = ''
            }

            if (data.values.paymentReceipt.name != data.item.file) {
                value['paymentReceipt'] = data.values.paymentReceipt
            }

            var formData = new FormData();
            for (var key in value) {
                formData.append(key, value[key]);
            }

            let url
            if (data.item.function == 'Create') {
                url = 'student/portal/payments/create'
            } else {
                url = 'student/portal/payments/update/' + data.item.code
                formData.append('_method', 'PUT')
            }

            var config = {
                method: 'post',
                url: url,
                // headers: {
                //     'Authorization': 'Bearer ' + this.$auth.token()
                // },
                data: formData
            }

            this.$axios(config)
                .then(response => {
                    commit('loading/SET_PAGE_LOADING', true, {
                        root: true
                    })
                    let message = [response.data.message]
                    commit('notificationMessage/SET_MESSAGE', message, {
                        root: true
                    })
                    dispatch('getLists')
                })
                .catch(err => {
                    let errorMessage
                    if (err.response.status == 422) {
                        var message_val = err.response.data.results
                        errorMessage = Object.values(message_val)[0]
                    } else {
                        errorMessage = err.response.data.message
                    }

                    let message = [errorMessage]

                    commit('notificationMessage/SET_OTHER_MESSAGE', message, {
                        root: true
                    })
                    commit('loading/SET_PAGE_LOADING', false, {
                        root: true
                    })
                })
        },
    }
}
