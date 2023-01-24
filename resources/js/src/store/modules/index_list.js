import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex);
export const indexList = {
    namespaced: true,
    state: () => ({
        //DYNAMIC LIST
        branchList: [],
        departmentList: [],
        employeeList: [],
        studentList: [],
        studentUserList: [],
        buildingList: [],
        laboratoryList: [],
        programList: [],
        subjectList: [],
        strandList: [],
        sectionList: [],

        //STATIC LIST
        listOption: ['OFFICIAL LIST', 'ARCHIVE LIST'],

        //SYTEM
        branchTypeList: ['MAIN', 'SUB'],
        actionList: [
            'LOGIN',
            'CREATE',
            'UPDATE',
            'DELETE',
            'ARCHIVE',
            'RESTORE',
            // 'RESET'
        ],
        moduleList: [
            'ACCOUNTING',
            'ADMISSION',
            'BASIC EDUCATION',
            'COLLEGE',
            'DEPARTMENT',
            'FACILITY',
            'FOREIGN',
            'HUMAN RESOURCES',
            'INFORMATION TECHNOLOGY SERVICE',
            'REGISTRAR',
            'SCHOLARSHIP',
            'STUDENT',
            'SYSTEM',
            'USER',
        ],

        //ACCOUNTING
        paymentTypeList: [
            'ENTRANCE FEE',
            'PRELIM',
            'MIDTERM',
            'PRE-FINAL',
            'FINAL',
            'FULL PAYMENT',
            'OTHER'
        ],
        paymentStatusList: [
            'ACCEPTED',
            'PENDING',
            'DENIED'
        ],

        //DEPARTMENT
        departmentTypeList: ['ACADEMIC', 'NON-ACADEMIC'],

        //APPLICANT|STUDENT
        schoolLevelTypeList: ['COLLEGE', 'BASIC EDUCATION'],
        schoolLevelList: [
            'PRE-SCHOOL',
            'ELEMENTARY',
            'JUNIOR HIGH SCHOOL',
            'SENIOR HIGH SCHOOL',
            'COLLEGE',
            'GRADUATE SCHOOL'
        ],
        schoolLevelGradeYearList: {
            'PRE-SCHOOL': [
                'KINDERGARDEN ONE',
                'KINDERGARDEN TWO',
            ],
            'ELEMENTARY': [
                'GRADE ONE',
                'GRADE TWO',
                'GRADE THREE',
                'GRADE FOUR',
                'GRADE FIVE',
                'GRADE SIX'
            ],
            'JUNIOR HIGH SCHOOL': [
                'GRADE SEVEN',
                'GRADE EIGHT',
                'GRADE NINE',
                'GRADE TEN'
            ],
            'SENIOR HIGH SCHOOL': [
                'GRADE ELEVEN',
                'GRADE TWELVE'
            ],
            'COLLEGE': [
                'FIRST YEAR',
                'SECOND YEAR',
                'THIRD YEAR',
                'FOURTH YEAR',
                'FIFTH YEAR'
            ],
            'GRADUATE SCHOOL': [],
        },
        allGradeYearLevelList: [
            'KINDERGARDEN ONE',
            'KINDERGARDEN TWO',
            'GRADE ONE',
            'GRADE TWO',
            'GRADE THREE',
            'GRADE FOUR',
            'GRADE FIVE',
            'GRADE SIX',
            'GRADE SEVEN',
            'GRADE EIGHT',
            'GRADE NINE',
            'GRADE TEN',
            'GRADE ELEVEN',
            'GRADE TWELVE',
            'FIRST YEAR',
            'SECOND YEAR',
            'THIRD YEAR',
            'FOURTH YEAR',
            'FIFTH YEAR'
        ],
        semesterList: [
            'FIRST SEMESTER',
            'SECOND SEMESTER',
            'SUMMER'
        ],

        //COLLEGE|BASIC-ED
        programTypeList: ['UNDERGRADUATE', 'POSTGRADUATE'],
        programDurationList: [{
                text: '2 YEARS',
                value: 2
            },
            {
                text: '4 YEARS',
                value: 4
            },
            {
                text: '5 YEARS',
                value: 5
            },
        ],
        subjectTypeList: [
            'PROFESSIONAL EDUCATION',
            'GENERAL EDUCATION',
            'NSTP'
        ],
        trackList: [
            'ACADEMIC',
            'ARTS AND DESIGN',
            'TECHNICAL VOCATIONAL LIVELIHOOD',
            'SPORTS'
        ],

        //FACILITY
        roomTypeList: ['LECTURE', 'LABORATORY'],

        //HRS|ITS
        employeeUserType: [
            'DEAN',
            // 'PROGRAM HEAD',
            'TEACHING',
            'NON-TEACHING'
        ],
        roleList: [
            'ADMIN',
            'ACCOUNTING',
            'ADMISSION',
            'AUDITOR',
            'BASIC EDUCATION',
            'CASHIER',
            'DEAN',
            'FACULTY',
            'FOREIGN',
            'HUMAN RESOURCE',
            'INFORMATION TECHNOLOGY SERVICE',
            'PROGRAM HEAD',
            'REGISTRAR',
            'SECRETARY',
            'SCHOLARSHIP'
        ],
    }),

    mutations: {
        FETCH_BRANCH_LIST(state, data) {
            state.branchList = data
        },
        FETCH_DEPARTMENT_LIST(state, data) {
            state.departmentList = data
        },
        FETCH_EMPLOYEE_LIST(state, data) {
            state.employeeList = data
        },
        FETCH_STUDENT_LIST(state, data) {
            state.studentList = data
        },
        FETCH_STUDENT_USER(state, data) {
            state.studentUserList = data
        },
        FETCH_BUILDING_LIST(state, data) {
            state.buildingList = data
        },
        FETCH_LABORATORY_LIST(state, data) {
            state.laboratoryList = data
        },
        FETCH_PROGRAM_LIST(state, data) {
            state.programList = data
        },
        FETCH_SUBJECT_LIST(state, data) {
            state.subjectList = data
        },
        FETCH_STRAND_LIST(state, data) {
            state.strandList = data
        },
        FETCH_SECTION_LIST(state, data) {
            state.sectionList = data
        },
    },

    actions: {

        getIndexLists({
            commit
        }, data) {

            let url = ''
            let mutation = 'FETCH_' + data.toUpperCase() + '_LIST'

            switch (data) {
                case 'branch':
                    url = 'system/branches'
                    break;
                case 'department':
                    url = 'department/departments'
                    break;
                case 'section':
                    url = '/college/sections'
                    break;
                case 'program':
                    url = 'college/programs'
                    break;
                case 'subject':
                    url = 'college/subjects'
                    break;
                case 'strand':
                    url = 'basiceducation/strands'
                    break;
                case 'employee':
                    url = 'human-resource/employees'
                    break;
                case 'student':
                    url = 'admission/applicants'
                    break;
                case 'building':
                    url = 'facility/buildings'
                    break;
                case 'laboratory':
                    url = 'facility/laboratories'
                    break;

                default:
                    break;
            }
            const config = {
                method: 'get',
                url: url,
                headers: {
                    'Authorization': 'Bearer ' + this.$auth.token()
                }
            }

            commit(mutation, {
                ALL: ['LOADING']
            })

            this.$axios(config)
                .then(response => {

                    let value = response.data.results
                    let valueInBranch = {
                        ALL: []
                    }

                    if (value.length != 0) {
                        if (value[0].hasOwnProperty('lastName')) {
                            for (var i = 0; i < value.length; i++) {
                                value[i]['fullName'] = value[i].lastName + ', ' + value[i].firstName + (value[i].middleName != null ? ' ' + value[i].middleName : '')
                            }
                        }
                        if (data == 'department') {
                            if (this.$router.currentRoute.name != 'User (Employee)' || this.$router.currentRoute.name != 'Employee') {
                                if (this.$router.currentRoute.meta.name == 'Subject') {
                                    value = value.filter(values => values.type == 'ACADEMIC')
                                } else {
                                    value = value.filter(values => values.type == 'ACADEMIC' && values.code != 'ND')
                                }
                            }
                        } else if (data == 'section') {
                            if (this.$router.currentRoute.name == 'Schedule (College)') {
                                value = value.filter(values => values.type == 'COLLEGE')
                            } else {
                                value = value.filter(values => values.type == 'BASIC EDUCATION')
                            }
                        }
                    }

                    if (data != 'branch' && this.$auth.credentials().accountBranchType == 'MAIN') {
                        // CREATE OBJECTS OF BRANCHES WITHIN valueInBranch
                        for (var i = 0; i < this.state.indexList.branchList.ALL.length; i++) {
                            valueInBranch[this.state.indexList.branchList.ALL[i].name] = []
                        }

                        for (var i = 0; i < value.length; i++) {

                            valueInBranch['ALL'].push(value[i])

                            for (let key in valueInBranch) {
                                if (value[i].branch.hasOwnProperty('name')) {
                                    if (key == value[i].branch.name) {
                                        valueInBranch[key].push(value[i])
                                    }
                                } else {
                                    if (key == value[i].branch) {
                                        valueInBranch[key].push(value[i])
                                    }
                                }
                            }
                        }

                    } else {
                        valueInBranch['ALL'] = value
                    }

                    // console.log(valueInBranch)
                    commit(mutation, valueInBranch)
                })
                .catch(err => {
                    commit(mutation, {
                        ALL: [err]
                    })
                })
        },

    }
}
