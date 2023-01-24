import {
    mapState,
    mapGetters,
    mapActions,
    mapMutations
} from 'vuex'
import "../styles/general/basic.css";

export default {
    data() {
        return {
            search: '', //DATA TABLE SEARCH
            panel: 1, //FILTER PANEL CLOSE/OPEN
            dialog: false,
            dialogTitle: '', //WHAT FUNCTION WILL BE USED
            alert: false,
            typeValue: 'success', //FOR ALERT TYPE
            message: '', //ALERT MESSAGE
            list: 'OFFICIAL LIST', //LISTOPTION VALUE CONTAINER
            items: {}, //@ROW DATA CONTAINER
            errorStatus: 0,
            user: {}, //HANDLES USER CREDENTIALS

            btnClick: false, //check if button or row is clicked
            wCreate: true, //HEADER VALUES
            wRedirect: false,
            dataTableButtons: {
                index: [
                    'update',
                    'archive',
                ],
                list: [
                    'restore',
                    'delete'
                ]
            }
        }
    },
    computed: {
        ...mapState({
            //INDEX/ARCHIVE LIST HANDLER
            itemList: state => state.crudAr.list,
            itemShow: state => state.crudAr.item,

            //CHANGES LIST EITHER ['OFFICIAL LIST, ARCHIVE LIST]
            listOption: state => state.indexList.listOption,

            //SYSTEM
            branchList: state => state.indexList.branchList,
            branchTypeList: state => state.indexList.branchTypeList,
            moduleList: state => state.indexList.moduleList,
            actionList: state => state.indexList.actionList,

            //ACCOUNTING
            paymentTypeList: state => state.indexList.paymentTypeList,
            paymentStatusList: state => state.indexList.paymentStatusList,

            //DEPARTMENT
            departmentList: state => state.indexList.departmentList,
            departmentTypeList: state => state.indexList.departmentTypeList,

            //COLLEGE|BASIC-ED
            sectionList: state => state.indexList.sectionList,
            programList: state => state.indexList.programList,
            subjectList: state => state.indexList.subjectList,
            programTypeList: state => state.indexList.programTypeList,
            programDurationList: state => state.indexList.programDurationList,
            subjectTypeList: state => state.indexList.subjectTypeList,
            strandList: state => state.indexList.strandList,
            trackList: state => state.indexList.trackList,

            //FACILITY
            buildingList: state => state.indexList.buildingList,
            laboratoryList: state => state.indexList.laboratoryList,
            roomTypeList: state => state.indexList.roomTypeList,

            //HRS|ITS
            studentList: state => state.indexList.studentList,
            employeeList: state => state.indexList.employeeList,
            employeeUserType: state => state.indexList.employeeUserType,
            roleList: state => state.indexList.roleList,
            // studentUserList: state => state.indexList.studentUserList,

            //APPLICANT|STUDENT
            schoolLevelTypeList: state => state.indexList.schoolLevelTypeList,
            schoolLevelList: state => state.indexList.schoolLevelList,
            allGradeYearLevelList: state => state.indexList.allGradeYearLevelList,
            schoolLevelGradeYearList: state => state.indexList.schoolLevelGradeYearList,
            semesterList: state => state.indexList.semesterList,

        }),
        ...mapGetters('crudAr', [
            'getterListOption',
        ]),
    },

    methods: {
        ...mapActions('crudAr', [
            'getLists',
            'showData'
        ]),
        ...mapActions('indexList', [
            'getIndexLists'
        ]),
        ...mapMutations('crudAr', ['SET_LIST']),

        //CHECK FUNCTION TO BE USED
        buttonFunction(value, item) {
            this.dialogTitle = value
            this.dialog = true
            this.items = (value == 'Create' ? null : item)
        },

        onCloseDialog(newValue) {
            this.dialog = newValue
        },
        onErrorChange(newValue) {
            this.errorStatus = newValue
        },
        changeBtnClickValue(value) {
            this.btnClick = value
        },

        listChange(value) {
            this.list = value
            this.resetPageLoading()
            this.SET_LIST(value)
            this.getLists(value)
        },
        clearFilter() {
            this.$refs.filterForm.reset()
            this.panel = 1
        },
        redirect(row) {
            if (this.wRedirect == true) {

                var id = row.code != undefined ? row.code.toLowerCase():''

                if (this.list == 'OFFICIAL LIST' && this.btnClick == false) {
                    switch (this.$router.currentRoute.name) {
                        case 'Employee':
                            this.$router.push({
                                name: 'View Employee',
                                params: {
                                    id: row.employeeNumber
                                }
                            });
                            break;

                        case 'Curriculum (College)':
                            this.$router.push({
                                name: 'Edit Curriculum',
                                params: {
                                    id: id,
                                    branch: row.branch.code,
                                    code: row.code
                                }
                            });
                            break;

                        case 'Section (College)':
                            this.$router.push({
                                name: 'Edit Schedule (College)',
                                params: {
                                    id: id,
                                    branch: row.branch.code,
                                    section: row.code
                                }
                            });
                            break;

                        default:
                            break;
                    }
                }
            } else if (this.wRedirect == 'show') {
                if (this.btnClick == false && this.list != 'ARCHIVE LIST') {
                    let code = row.branch.code + '/' + row.code
                    this.showData(code)
                    this.dialogTitle = 'Show'
                    this.dialog = true
                }
            }

        },
    },
    watch: {
        //SUCCESS MESSAGE
        getterMessage: function (newMessage) {
            if (newMessage != null) {
                this.alert = true
                this.typeValue = 'success'
                this.message = newMessage[0]
                this.errorStatus = 1
            }
        },
        //ERROR MESSAGE
        getterOtherMessage: function (newMessage) {
            if (newMessage != null) {

                if (newMessage[1] == 422
                    && this.dialogTitle != 'Archive'
                    && this.dialogTitle != 'Delete'
                    && this.dialogTitle != 'Show') {
                    this.dialog = true
                    this.errorStatus = 422
                } else {
                    this.dialog = false
                    this.errorStatus = 1
                    this.resetPageLoading()
                    this.getLists(this.list)
                }

                this.alert = true
                this.typeValue = 'error'

                if (typeof newMessage[0] != 'object') {
                    if (this.errorStatus != 1) {
                        this.message = {
                            error: newMessage[0]
                        }
                    } else {
                        this.message = newMessage[0]
                    }
                } else {
                    this.message = newMessage[0]
                }
            }
        },
        //WATCH LISTOPTION TO DISPLAY EITHER INDEX/ARCHIVE LIST
        getterListOption(newValue) {
            if (newValue != null) {
                this.list = newValue
            }
        },
        dialog(newValue) {
            if (newValue == false) {
                this.btnClick = false
            }
        }
    },
    mounted() {
        this.user = this.$auth.credentials()
        this.getLists(this.list)
        for (let key of this.indexList) {
            this.getIndexLists(key)
        }
    },
    beforeDestroy() {
        this.resetPageLoading();
        this.resetOtherMessage();
        this.resetErrorMessage();
        this.resetMessage();
        this.SET_LIST('OFFICIAL LIST');
    },
};
