import axios from 'axios'
import Vuex from 'vuex'
import Vue from 'vue'

import createPersistedState from 'vuex-persistedstate';
import Cookies from 'js-cookie';

//modules
import { formItems } from './modules/form_items'

import { applicant } from './modules/applicant'
import { applicantInformation } from './modules/admission/applicant_information'
import { applicantList } from './modules/admission/applicant_list'

// college
import { subject } from './modules/college/subject'
import { curriculum } from './modules/college/curriculum'

import { employee } from './modules/employee'

import { user } from './modules/user'

import { studentProofOfPayment } from './modules/student_portal/proof_of_payment'

//reusable crud w/ archive and restore
import { crudAr } from './modules/crud_ar'

//reusable lists ex. branchList
import { indexList } from './modules/index_list'

// UI state
import { ui } from './modules/ui'

//extras
import { loading } from './modules/loading'
import { notificationMessage } from './modules/notification_message'
import { path } from './modules/path'

// facility
import { facility } from './modules/facility'


//load Vuex
Vue.use(Vuex);


const store = new Vuex.Store({
    modules: {
        crudAr,
        indexList,
        formItems,

        user,
        employee,
        applicant,
        applicantList,
        applicantInformation,
        studentProofOfPayment,

        subject,
        curriculum,
        
        path,
        loading,
        notificationMessage,
        ui,

        facility,
    },
    plugins: [createPersistedState({
        paths: [
            'user.user',
            'ui.darkMode',
            'ui.drawer',
        ],
        storage: {
            getItem: key => Cookies.get(key),
            setItem: (key, value) => Cookies.set(key, value, { expires: 7, secure: true }),
            removeItem: key => Cookies.remove(key)
            }
        })
    ],
})

export default store