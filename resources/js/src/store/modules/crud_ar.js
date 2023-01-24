import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex);
export const crudAr = {
    namespaced: true,
    state: () => ({
        list: [],
        item: [],
        listOption: 'OFFICIAL LIST',
    }),

    getters: {
        getterListOption: state => state.listOption,
    },

    mutations: {
        FETCH_LIST(state, data) {
            state.list = data
        },
        FETCH_ITEM(state, data) {
            state.item = data
        },
        SET_LIST(state, data) {
            state.listOption = data
        },
    },

    actions: {
        //GET INDEX | ARCHIVE LIST
        getLists({
            commit
        }, data) {
            commit('loading/SET_PAGE_LOADING', true, {
                root: true
            })
            let url = ''
            if (data == 'ARCHIVE LIST') {
                url = this.$router.currentRoute.meta.route + '/archive/list'
            } else {
                url = this.$router.currentRoute.meta.route
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
                    let routeName = this.$router.currentRoute.name
                    let value = response.data.length != 0 ? response.data.results : []

                    if (value.length != 0) {
                        let middleName
                        let other

                        if (value[0].hasOwnProperty('employee')) {
                            for (var i = 0; i < value.length; i++) {
                                if (value[i].employee != null) {
                                    middleName = value[i].employee.middleName != null ? value[i].employee.middleName : ''
                                    value[i]['employee'] = {
                                        fullName: value[i].employee.lastName + ', ' + value[i].employee.firstName + ' ' + middleName,
                                        employeeNumber: value[i].employee.employeeNumber
                                    }
                                } else {
                                    value[i]['employee'] = null
                                }
                            }
                        }

                        if (value[0].hasOwnProperty('lastName')) {
                            for (var i = 0; i < value.length; i++) {
                                middleName = value[i].middleName != null ? value[i].middleName : ''
                                value[i]['fullName'] = value[i].lastName + ', ' + value[i].firstName + ' ' + middleName
                            }
                        }

                        for (var i = 0; i < value.length; i++) {
                            if (value[i].hasOwnProperty('createdAt')) {
                                value[i]['date'] = this.$dateFormat.mdy(value[i].createdAt)
                            }
                            value[i]['random'] = (i * value.length) + Math.random().toString(36).substr(2, 5)
                        }

                        if (routeName == 'Proof of Payment') {
                            for (var i = 0; i < value.length; i++) {
                                middleName = value[i].middleName != null ? value[i].middleName : ''
                                other = value[i].other != null ? ' | ' + value[i].other : ''
                                value[i]['fullName'] = value[i].lastName + ', ' + value[i].firstName + ' ' + middleName
                                value[i]['paymentType'] = value[i].paymentOption + other
                            }
                        }
                    }

                    let values
                    if (routeName == 'Section (College)' || routeName == 'Curriculum (College)') {
                        values = value.filter(values => values.type == 'COLLEGE')
                    } else if (routeName == 'Section (Basic Education)' || routeName == 'Curriculum (Basic Education)') {
                        values = value.filter(values => values.type == 'BASIC EDUCATION');
                    } else {
                        values = value
                    }

                    // console.log(values)
                    commit('FETCH_LIST', values.reverse())
                    commit('loading/SET_PAGE_LOADING', false, {
                        root: true
                    })
                })
                .catch(err => {
                    let message

                    if (err.response == undefined) {
                        message.push(err)

                        if (this.$auth.isEmployee() == false) {
                            commit('user/SET_LOGIN_ERROR',
                                'Authentication Error: You have been logged out of the System. Kindly Log-in again, if the error persists contact risseu@spcf.edu.ph', {
                                    root: true
                                })
                            this.$router.push({
                                name: 'Login'
                            })
                        }

                    } else {
                        if (err.response.status == 422) {
                            var message_val = err.response.data.results
                            message = Object.values(message_val)[0]
                        } else {
                            message = err.response.data.message
                        }
                    }

                    commit('notificationMessage/SET_ERROR_MESSAGE', 'Error: ' + message, {
                        root: true
                    })
                    commit('loading/SET_PAGE_LOADING', null, {
                        root: true
                    })
                })
        },

        //CREATE | UPDATE FUNCTION
        submitData({
            commit,
            dispatch
        }, data) {

            commit('loading/SET_PAGE_LOADING', true, {
                root: true
            })

            let code = ''

            if (data.branchCode != null && data.itemCode != null) {
                code = data.branchCode + '/' + data.itemCode
            } else {
                code = data.itemCode != null ? data.itemCode : data.branchCode
            }

            let url = ''
            let method = ''
            if (data.function == 'Create') {
                method = 'post'
            } else {
                method = 'put'
            }

            let routeName = this.$router.currentRoute.name
            let path = this.$router.currentRoute.meta.route

            switch (routeName.toUpperCase()) {
                case 'PROOF OF PAYMENT':
                    url = 'accounting/payments/status/update/' + code
                    break;
                case 'USER (EMPLOYEE)':
                    url = 'department/information-technology-services/account/user/register'
                    break;

                case 'USER (STUDENT)':
                    url = 'department/information-technology-services/account/student/register'
                    break;

                case 'CURRICULUM (COLLEGE)':
                    url = 'college/curriculums/code/update/' + code
                    break;

                default:
                    if (data.function == 'Create') {
                        url = path + '/create'
                    } else {
                        url = path + '/update/' + code
                    }
                    break;
            }

            var config = {
                method: method,
                url: url,
                // headers: {
                //     'Authorization': 'Bearer ' + this.$auth.token()
                // },
                data: data.values
            }

            this.$axios(config)
                .then(response => {
                    let message = [response.data.message]
                    commit('notificationMessage/SET_MESSAGE', message, {
                        root: true
                    })
                    commit('SET_LIST', 'OFFICIAL LIST')
                    dispatch('getLists', 'OFFICIAL LIST')

                    if (data.assign == true) {
                        var value = {
                            function: data.function,
                            response: response
                        }
                        dispatch('reroute', value)
                    }
                })
                .catch(err => {
                    dispatch('error', err)
                })
        },

        //ARCHIVE | RESTORE | PERMANENT DELETE FUNCTION
        changeData({
            commit,
            dispatch
        }, data) {

            commit('loading/SET_PAGE_LOADING', true, {
                root: true
            })
            let path = this.$router.currentRoute.meta.route

            let url = ''
            let method = ''
            let code = ''

            if (data.branchCode != null && data.itemCode != null) {
                code = data.branchCode + '/' + data.itemCode
            } else {
                code = data.itemCode != null ? data.itemCode : data.branchCode
            }

            if (data.function == 'Archive' || data.function == 'Delete') {
                method = 'delete'
            } else if (data.function == 'Restore') {
                method = 'patch'
            } else {
                method = 'get'
            }

            if (data.function == 'Archive') {
                url = path + '/archive/' + code
            } else if (data.function == 'Delete') {
                url = path + '/delete/' + code
            } else if (data.function == 'Restore') {
                url = path + '/restore/' + code
            } else {
                url = path + '/reset/' + code
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

                    let message = [response.data.message]
                    commit('notificationMessage/SET_MESSAGE', message, {
                        root: true
                    })

                    if (data.function != 'Restore' && data.function != 'Reset') {
                        commit('SET_LIST', 'ARCHIVE LIST')
                        dispatch('getLists', 'ARCHIVE LIST')
                    } else {
                        commit('SET_LIST', 'OFFICIAL LIST')
                        dispatch('getLists', 'OFFICIAL LIST')
                    }
                })
                .catch(err => {
                    dispatch('error', err)
                })
        },

        //SHOW
        showData({
            commit,
            dispatch
        }, data) {

            commit('loading/SET_PART_LOADING', true, {
                root: true
            })
            let path = this.$router.currentRoute.meta.route

            const config = {
                method: 'get',
                url: path + '/' + data,
                // headers: {
                //     'Authorization': 'Bearer ' + this.$auth.token()
                // }
            }
            this.$axios(config)
                .then(response => {
                    commit('FETCH_ITEM', response.data.results)
                    commit('loading/SET_PART_LOADING', false, {
                        root: true
                    })

                })
                .catch(err => {
                    commit('loading/SET_PART_LOADING', false, {
                        root: true
                    })
                    dispatch('error', err)
                })
        },
        // REROUTE
        reroute({}, data) {
            var name = ''
            switch (this.$router.currentRoute.name) {
                case 'Section (College)':
                    if (data.function == 'Create') {
                        name = 'Create Schedule (College)'
                    } else {
                        name = 'Edit Schedule (College)'
                    }

                    this.$router.push({
                        name: name,
                        params: {
                            id: data.response.data.results.code.toLowerCase(),
                            branch: data.response.data.results.branch.code,
                            section: data.response.data.results.code,
                        }
                    })
                    break;

                case 'Curriculum (College)':
                    this.$router.push({
                        name: 'Edit Curriculum',
                        params: {
                            id: data.response.data.results.code.toLowerCase(),
                            branch: data.response.data.results.branch.code,
                            code: data.response.data.results.code
                        }
                    })
                    break;

                default:
                    break;
            }
        },
        // ERROR
        error({
            commit
        }, err) {
            commit('loading/SET_PAGE_LOADING', false, {
                root: true
            })

            let message = []
            if (err.response == undefined) {
                message.push(err)
                if (this.$auth.isEmployee() == false) {
                    commit('user/SET_LOGIN_ERROR',
                        'Authentication Error: You have been logged out of the System. Kindly Log-in again, if the error persists contact risseu@spcf.edu.ph', {
                            root: true
                        })
                    this.$router.push({
                        name: 'Login'
                    })
                }
            } else {
                if (err.response.status == 422) {
                    var message_val
                    if (err.response.data.results.length == 0) {
                        message_val = {
                            message: err.response.data.message
                        }
                    } else {
                        message_val = err.response.data.results
                    }
                    message.push(Object.values(message_val))
                } else {
                    message.push(err.response.data.message)
                }
                message.push(err.response.status)
            }

            commit('notificationMessage/SET_OTHER_MESSAGE', message, {
                root: true
            })

        },

    }
}
