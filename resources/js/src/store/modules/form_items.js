import axios from 'axios'
import Vuex from 'vuex'
import Vue from 'vue'

//load Vuex
Vue.use(Vuex);

export const formItems = {
    namespaced: true,
    state: () => ({

        // student/applicant
        semesters: [
            { "numberUpperCase" : "1ST SEMESTER", "letterCamelCase" : "firstSemester", "letterUpperCase": "FIRST SEMESTER" },
            { "numberUpperCase" : "2ND SEMESTER", "letterCamelCase" : "secondSemester", "letterUpperCase": "SECOND SEMESTER" },
            { "numberUpperCase" : "SUMMER", "letterCamelCase" : "summer" },
        ],
        genders: ["MALE", "FEMALE"],
        civilStatus: ["SINGLE", "MARRIED", "SEPARATED", "WIDOWED"],
        studentTypes: ["NEW", "OLD", "TRANSFEREE", "SECOND COURSER"],
        methods: ["ONLINE", "MODULAR", "MODULAR AND ONLINE"],
        educationLevels: {
            "PRE-SCHOOL": [
                { "numberUpperCase" : "NURSERY", "letterCamelCase" : "nursery", "letterUpperCase" : "NURSERY" },
                { "numberUpperCase" : "PREPARATORY", "letterCamelCase" : "preparatory", "letterUpperCase" : "PREPARATORY" },
                { "numberUpperCase" : "KINDERGARTEN", "letterCamelCase" : "kindergarten", "letterUpperCase" : "KINDERGARTEN" },
            ],
            "ELEMENTARY": [
                { "numberUpperCase" : "GRADE 1", "letterCamelCase" : "gradeOne", "letterUpperCase" : "GRADE ONE" },
                { "numberUpperCase" : "GRADE 2", "letterCamelCase" : "gradeTwo", "letterUpperCase" : "GRADE TWO" },
                { "numberUpperCase" : "GRADE 3", "letterCamelCase" : "gradeThree", "letterUpperCase" : "GRADE THREE" },
                { "numberUpperCase" : "GRADE 4", "letterCamelCase" : "gradeFour", "letterUpperCase" : "GRADE FOUR" },
                { "numberUpperCase" : "GRADE 5", "letterCamelCase" : "gradeFive", "letterUpperCase" : "GRADE FIVE" },
                { "numberUpperCase" : "GRADE 6", "letterCamelCase" : "gradeSix", "letterUpperCase" : "GRADE SIX" },
            ],
            "JUNIOR HIGH SCHOOL": [
                { "numberUpperCase" : "GRADE 7", "letterCamelCase" : "gradeSeven", "letterUpperCase" : "GRADE SEVEN" },
                { "numberUpperCase" : "GRADE 8", "letterCamelCase" : "gradeEight", "letterUpperCase" : "GRADE EIGHT" },
                { "numberUpperCase" : "GRADE 9", "letterCamelCase" : "gradeNine", "letterUpperCase" : "GRADE NINE" },
                { "numberUpperCase" : "GRADE 10", "letterCamelCase" : "gradeTen", "letterUpperCase" : "GRADE TEN" },
            ],
            "SENIOR HIGH SCHOOL": [
                { "numberUpperCase" : "GRADE 11", "letterCamelCase" : "gradeEleven", "letterUpperCase" : "GRADE ELEVEN" },
                { "numberUpperCase" : "GRADE 12", "letterCamelCase" : "gradeTwelve", "letterUpperCase" : "GRADE TWELVE" },
            ],
            "COLLEGE": [
                { "numberUpperCase" : "1ST YEAR", "letterCamelCase" : "firstYear", "letterUpperCase" : "FIRST YEAR" },
                { "numberUpperCase" : "2ND YEAR", "letterCamelCase" : "secondYear", "letterUpperCase" : "SECOND YEAR" },
                { "numberUpperCase" : "3RD YEAR", "letterCamelCase" : "thirdYear", "letterUpperCase" : "THIRD YEAR" },
                { "numberUpperCase" : "4TH YEAR", "letterCamelCase" : "fourthYear", "letterUpperCase" : "FOURTH YEAR" },
                { "numberUpperCase" : "5TH YEAR", "letterCamelCase" : "fifthYear", "letterUpperCase" : " YEAR" },
            ],
            "GRADUATE SCHOOL": [],
        },     
        averageIncome: [
            "10,000 AND BELOW",
            "MORE THAN 10,000 TO 20,000",
            "MORE THAN 20,000 TO 30,000",
            "MORE THAN 30,000 TO 40,000",
            "MORE THAN 50,000",
            "OTHER"
        ],
        requirements: {
            "spcfCatResult": "SPCFCAT Result", 
            "certificateOfMoralCharacter": "Certificate of Moral Character", 
            "nsoBirthCertificate": "Photocopy of PSA Birth Certificate",
            "form137": "Card/Form 137",
            "transcriptOfRecord": "Transcript of Records",
            "policeClearance": "Police Clearance",
            "barangayClearance": "Barangay Clearance",
            "marriageCertificate": "Marriage Certificate",
            "transferCredential": "Transfer Credentials",  
            "specialStudyPermit": "Special Study Permit",
            "alienCertificateRegistration": "Alien Certificate of Registration",
            "passport": "Passport",
            "visa": "Visa",
            "medicalClearance": "Medical Certificate",
        },
        branches: [],

        // employee
        employeeTypes: ['TEACHING', 'NON-TEACHING', 'DEAN'],
        departments: [],

        programs: [],

        // 
        days: [
            { 'name': 'MONDAY', 'shortcut': 'MON' },
            { 'name': 'TUESDAY', 'shortcut': 'TUES' },
            { 'name': 'WEDNESDAY', 'shortcut': 'WED' },
            { 'name': 'THURSDAY', 'shortcut': 'THURS' },
            { 'name': 'FRIDAY', 'shortcut': 'FRI' },
            { 'name': 'SATURDAY', 'shortcut': 'SAT' },
            { 'name': 'SUNDAY', 'shortcut': 'SUN' },

        ]

        
    }),

    mutations: {
        SET_PROGRAMS: (state, data) => state.programs = data,
        SET_STRANDS: (state, data) => state.strands = data,
        SET_BRANCHES: (state, data) => state.branches = data,
        SET_DEPARTMENTS: (state, data) => state.departments = data
    },

    actions: {
        getData ({commit}) {
            this.$axios.get('admission/applicants/online')
            .then(res => {
                commit('SET_BRANCHES', res.data.results.branch.results)
            })
            .catch(err => console.error(err))

            if (this.$auth.token()) {
                const config = {
                    headers: {
                        'Authorization' : 'Bearer ' + this.$auth.token()
                    }
                }
                this.$axios.get('department/departments', config)
                    .then(res => {
                        commit('SET_DEPARTMENTS', res.data.results)
                    })
                    .catch(err => console.error(err.response))
            }
        },
        getPrograms({commit}) {
            const config = {
                headers: {
                        'Authorization': 'Bearer ' + this.$auth.token()
                    }
            }
            this.$axios.get('college/programs', config)
            .then(res => {
                commit('SET_PROGRAMS', res.data.results)
            })
            .catch(err => console.error(err))
        },
        getBranches({commit}) {
            const config = {
                headers: {
                        'Authorization': 'Bearer ' + this.$auth.token()
                    }
            }
            this.$axios.get('system/branches', config)
            .then(res => {
                commit('SET_BRANCHES', res.data.results)
            })
            .catch(err => console.error(err))
        },
        getDepartments({commit}) {
            const config = {
                headers: {
                        'Authorization': 'Bearer ' + this.$auth.token()
                    }
            }
            this.$axios.get('department/departments', config)
            .then(res => {
                commit('SET_DEPARTMENTS', res.data.results)
            })
            .catch(err => console.error(err))
        }
    }
}


