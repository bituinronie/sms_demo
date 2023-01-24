import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex);
export const applicantList = {
    namespaced: true,
    state: () => ({
        list: [],
        status: [
            'PENDING',
            'ACCEPTED',
            'DENIED',
            'ASSIGNED',
            'OFFICIAL'
        ],
        schoolYear: [],
        listOption: 'OFFICIAL LIST',
    }),

    getters: {
        getterListOption: state => state.listOption
    },

    mutations: {
        FETCH_LIST(state, data) {
            state.list = data
        },
        SET_LIST(state, data) {
            state.listOption = data
        },
        FETCH_SCHOOL_YEAR(state, data) {
            state.schoolYear = data
        },
    },

    actions: {
        setListOption({
            commit
        }, data) {
            commit('SET_LIST', data)
        },
        getLists({
            commit
        }, data) {
            let url = ''
            if (data == 'OFFICIAL LIST') {
                url = 'admission/applicants'
            } else {
                url = 'admission/applicants/archive/list'
            }
            const config = {
                method: 'get',
                url: url,
                // headers: {
                //     'Authorization': 'Bearer ' + this.$auth.token()
                // }
            }
            this.$axios(config)
                .then(response => {
                    let value = response.data.results;
                    let middleName
                    for (var i = 0; i < value.length; i++) {
                        middleName = value[i].middleName != null ? value[i].middleName : ''
                        value[i]['fullName'] = value[i].lastName + ', ' + value[i].firstName + ' ' + middleName
                        value[i]['date'] = this.$dateFormat.mdy(value[i].createdAt)
                    }

                    let schoolYear = []
                    for (var i = 0; i < value.length; i++) {
                        schoolYear.push(value[i].schoolYear)
                    }
                    const unique = (value, index, self) => {
                        return self.indexOf(value) === index
                    }

                    commit('FETCH_LIST', value);
                    commit('FETCH_SCHOOL_YEAR', schoolYear.filter(unique).sort());
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
        changeData({
            commit,
            dispatch
        }, data) {

            let url = ''
            let method = ''

            if (data.function == 'Delete') {
                url = 'admission/applicants/delete/' + data.id
                method = 'delete'
            } else if (data.function == 'Restore') {
                url = 'admission/applicants/restore/' + data.id
                method = 'patch'
            } else {
                url = 'admission/applicants/archive/' + data.id
                method = 'delete'
            }
            const config = {
                method: method,
                url: url,
                // headers: {
                //     'Authorization': 'Bearer ' + this.$auth.token()
                // }
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

                    if (data.function == 'Restore') {
                        this.$router.push({
                            name: 'View Applicant',
                            params: {
                                id: data.id
                            }
                        })
                        commit('notificationMessage/SET_REDIRECT_MESSAGE', response.data.message, {
                            root: true
                        })

                    } else if (data.function == 'Delete') {
                        commit('notificationMessage/SET_MESSAGE', message, {
                            root: true
                        })
                        commit('SET_LIST', 'ARCHIVE LIST')
                        dispatch('getLists', 'ARCHIVE LIST')
                    } else {
                        this.$router.push({
                            name: 'Applicant',
                        })
                        commit('notificationMessage/SET_SECOND_REDIRECT', response.data.message, {
                            root: true
                        })
                        commit('SET_LIST', 'ARCHIVE LIST')
                        dispatch('getLists', 'ARCHIVE LIST')
                    }

                })
                .catch(err => {
                    let message = []
                    if (err.response.status == 422) {
                        var message_val = err.response.data.results
                        message.push(Object.values(message_val)[0])
                    } else {
                        message.push(err.response.data.message)
                    }

                    commit('notificationMessage/SET_OTHER_MESSAGE', message, {
                        root: true
                    })
                    commit('loading/SET_PAGE_LOADING', false, {
                        root: true
                    })
                })
        }
    }
}
