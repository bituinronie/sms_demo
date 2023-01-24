import Vuex from 'vuex'
import Vue from 'vue'

import {
    values
} from 'lodash';

//load Vuex
Vue.use(Vuex);
export const applicantInformation = {
    namespaced: true,
    state: () => ({
        information: [],
        requirements: [],
        status: [],
        emailLoading: false,
        email: ''
    }),

    getters: {
        getEmailLoading: state => state.emailLoading,
        getEmail: state => state.email,
        getFullName: state => {
            let value = state.information
            let fullName
            if (value.middleName != null) {
                fullName = value.lastName + ', ' + value.firstName + ' ' + value.middleName
            } else {
                fullName = value.lastName + ', ' + value.firstName
            }
            return fullName
        },
        getStatusGetter: state => {
            return state.status
        },
        getVoucher: state => {
            let voucher = state.information.voucher
            let type

            if (voucher == null) {
                type = null
            } else {
                if (voucher.split('.').pop() == 'pdf') {
                    type = 'pdf';
                } else if (voucher.split('.').pop() == 'png' || voucher.split('.').pop() == 'jpg' || voucher.split('.').pop() == 'jpeg') {
                    type = 'image';
                } else {
                    type = 'none';
                }
            }

            values = {
                name: voucher,
                type: type
            };

            return values;
        },
        getAddress: state => {
            let value = state.information
            let current = value.currentAddressHouseNumber + ' ' +
                value.currentAddressStreetName + ', ' +
                value.currentAddressBarangay + ', ' +
                value.currentAddressCity + ', ' +
                value.currentAddressProvince + ' ' +
                value.currentAddressZipCode

            let permanent = value.permanentAddressHouseNumber + ' ' +
                value.permanentAddressStreetName + ', ' +
                value.permanentAddressBarangay + ', ' +
                value.permanentAddressCity + ', ' +
                value.permanentAddressProvince + ' ' +
                value.permanentAddressZipCode

            let address = {
                current: current,
                permanent: permanent
            }
            return address
        },
        getRequirement: state => {

            let value = state.information
            let requirements = [];

            function toSentenceCase(value) {
                const result = value.replace(/([A-Z])/g, " $1");
                return result.charAt(0).toUpperCase() + result.slice(1).toUpperCase()
            }

            function returnFileType(name) {
                if (value[name].split('.').pop() == 'pdf') {
                    return 'pdf'
                } else if (value[name].split('.').pop() == 'png' ||
                    value[name].split('.').pop() == 'jpg' || value[name].split('.').pop() == 'jpeg') {
                    return 'image'
                } else {
                    return 'none'
                }
            }

            let requirementNames = [
                'profileImage',
                'spcfCatResult',
                'certificateOfMoralCharacter',
                'nsoBirthCertificate',
                'form137',
                'policeClearance',
                'barangayClearance',
                'transferCredential',
                'specialStudyPermit',
                'alienCertificateRegistration',
                'passport',
                'visa',
                'medicalClearance',
                'transcriptOfRecord',
                'marriageCertificate'
            ]

            for (let key in value) {
                if (requirementNames.includes(key)) {
                    if (value[key] != null) {
                        requirements.push({
                            name: toSentenceCase(key),
                            img: value[key],
                            type: value[key].split('.').pop(),
                            fileType: returnFileType(key)
                        })
                    }
                }
            }

            return requirements;
        }
    },

    mutations: {
        FETCH_INFORMATION(state, data) {
            state.information = data
        },
        FETCH_STATUS(state, data) {
            state.status = data
        },
        SET_EMAIL(state, data) {
            state.email = data
        },
        SET_EMAIL_LOADING(state, data) {
            state.emailLoading = data
        },
    },

    actions: {
        setEmailLoading({
            commit
        }, data) {
            commit('SET_EMAIL_LOADING', data)
        },
        getInformation({
            commit
        }) {
            var id = this.$router.history.current.params.id

            let url
            if (this.$auth.isEmployee()) {
                url = 'admission/applicants/' + id
            } else if (this.$auth.isStudent()) {
                url = 'student/portal/accounts/'
            }

            const config = {
                url: url,
                method: 'get',
                // headers: {
                //     'Authorization': 'Bearer ' + this.$auth.token()
                // }
            }

            this.$axios(config)
                .then(response => {
                    let values = response.data.results

                    let statusInformation = {
                        applicantStatus: values.applicantStatus,
                        remark: values.remark
                    }

                    commit('FETCH_INFORMATION', values)
                    commit('FETCH_STATUS', statusInformation)
                    commit('SET_EMAIL', values.emailAddress)

                    commit('loading/SET_PAGE_LOADING', false, {
                        root: true
                    })
                    commit('loading/SET_PART_LOADING', false, {
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

                    commit('notificationMessage/SET_ERROR_MESSAGE', message, {
                        root: true
                    })
                    commit('loading/SET_PAGE_LOADING', null, {
                        root: true
                    })
                    console.error(err)
                })
        },

        //UPDATES
        updateStatus({
            commit
        }, data) {
            const config = {
                method: 'put',
                url: 'admission/applicants/status/update/' + this.$router.currentRoute.params.id,
                // headers: {
                //     'Authorization': 'Bearer ' + this.$auth.token()
                // },
                data: data
            }
            this.$axios(config)
                .then(response => {
                    let values = response.data.results

                    let value = {
                        applicantStatus: values.status,
                        remark: values.remark
                    }
                    commit('FETCH_STATUS', value)
                    commit('notificationMessage/SET_MESSAGE', [response.data.message], {
                        root: true
                    })
                    commit('loading/SET_PART_LOADING', false, {
                        root: true
                    })
                })
                .catch(err => {
                    let message = []
                    if (err.response.status == 422) {
                        var message_val = err.response.data.results
                        message.push(Object.values(message_val)[0])
                    } else {
                        message.push(err.response.data.message)
                    }
                    commit('loading/SET_PART_LOADING', false, {
                        root: true
                    })

                    commit('notificationMessage/SET_OTHER_MESSAGE', message, {
                        root: true
                    })
                })
        },

        email({
            commit
        }, data) {
            const config = {
                method: 'put',
                url: 'admission/applicants/email/update/' + this.$router.currentRoute.params.id,
                // headers: {
                //     'Authorization': 'Bearer ' + this.$auth.token()
                // },
                data: data.values
            }

            this.$axios(config)
                .then(response => {
                    commit('notificationMessage/SET_MESSAGE', [response.data.message], {
                        root: true
                    })
                    commit('SET_EMAIL', data.values.emailAddress)
                    commit('SET_EMAIL_LOADING', false)
                })
                .catch(err => {
                    let message = []
                    if (err.response.status == 422) {
                        var message_val = err.response.data.results
                        message.push(Object.values(message_val)[0])
                    } else {
                        message.push(err.response.data.message)
                    }
                    commit('SET_EMAIL_LOADING', false)
                    commit('notificationMessage/SET_OTHER_MESSAGE', message, {
                        root: true
                    })
                })
        }
    }
}
