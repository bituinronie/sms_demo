 import {
     mapActions,
 } from 'vuex'

 export default {
     props: [
         'getLists', //ACTION TO GET INDEX/ARCHIVE
         'itemShow',
         'list', //SELECTED LIST OPTION OFFICIAL/ARCHIVE
         'user', //CONTAIN USER CREDENTIALS

         'dialog',
         'dialogTitle',
         'items', //ROW DATA HANDLER

         //FOR PAGE LOADING AND ALERT MESSAGES
         'resetPageLoading',
         'getterPartLoading',
         'getterOtherMessage',
         'getterMessage',
         'errorStatus',
         'message',

         //FOR DROP DOWN FROM INDEXLIST
         'branchList',
         'paymentStatusList',
         'roleList',
         'employeeList',
         'studentList',
         'subjectTypeList',
         'schoolLevelList',
         'schoolLevelGradeYearList', //YEAR LEVEL UNDER SCHOOL LEVEL OBJ
         'allGradeYearLevelList', //ALL YEAR LEVEL
         'semesterList',
         'schoolLevelTypeList',
         'sectionList',
         'programList',
         'programTypeList',
         'programDurationList',
         'branchTypeList',
         'departmentList',
         'departmentTypeList',
         'roomTypeList',
         'buildingList',
         'laboratoryList',
         'trackList',
     ],
     data() {
         return {
             search: '',
             valid: true,

             itemsValue: {},
             function: '',
             originalItemCode: null,
             originalBranchCode: null,

             countDown: 5,
             cancelCountDown: true,

             dialogBody: '',
             dialogBodyColor: '',
             dialogHeaderColor: '',
             dialogDeleteClass: 'hidden',
             inputVisibility: 'hidden',
             branchVisibility: 'show',

             submitButtonLoading: true,
             clearError: true,
         }
     },

     methods: {
         //SUBMITDATA FOR CREATE && UPDATE | CHANGEDATA FOR ARCHIVE, RESTORE, PERMANENT DELETE
         ...mapActions('crudAr', [
             'submitData',
             'changeData'
         ]),

         //REUSABLE RESET OF BRANCH VALUE
         resetBranch() {
             if (this.user.accountBranchType != 'MAIN') {
                 this.branch = {
                     code: this.user.accountBranchCode,
                     name: this.user.accountBranchName
                 }
             } else {
                 this.branch = null
             }
         },

         //UPPERCASE FUNCTION
         changeToUpperCase(value) {
             switch (value) {
                 case 'code':
                     this.itemsValue.code = this.itemsValue.code != null ? this.itemsValue.code.toUpperCase() : null
                     break;
                 case 'name':
                     this.itemsValue.name = this.itemsValue.name != null ? this.itemsValue.name.toUpperCase() : null
                     break;
                 case 'remark':
                     this.itemsValue.remark = this.itemsValue.remark != null ? this.itemsValue.remark.toUpperCase() : null
                     break;
                 default:
                     break;
             }
         },

         //@CLICK OF CANCEL BUTTON
         cancel() {

             if (this.$refs.hasOwnProperty('form')) {
                 this.$refs.form.reset()
             }

             this.resetBranch()
             if (this.dialogTitle != 'Show') {
                 this.resetPageLoading()
                 this.getLists(this.list)
             }

             this.dialogDeleteClass = 'hidden';
             this.cancelCountDown = true;
             this.countDown = 5;

             this.$emit('closeDialog', false);
             this.$emit('errorChange', 0);
             this.clearError = true;
             this.submitButtonLoading = true
         },

         changeBranch(value) {
             for (let key of this.checkValues) {
                 if (key != 'noBranch' && key != 'noCode' && key != 'branch') {
                     if (value == 'fromOthers') {
                         this[key] = this.itemsValue[key]
                     } else {
                         this[key] = null
                     }
                 }
             }
         },

         //VALIDATION OF DATA BEFORE SUBMISSION
         validate(value) {
             if ((this.dialogTitle == 'Create' || this.dialogTitle == 'Update') ? this.$refs.form.validate() : true) {

                //GET CODE FROM OBJ
                 for (let key of this.checkValues) {
                     if (this[key] != null && this[key] != '' && this[key] != undefined &&
                         key != 'noBranch' && key != 'noCode') {
                         if (key == 'employee') {
                             this.itemsValue[key] = this[key].employeeNumber != undefined ? this[key].employeeNumber : null
                         } else {
                             this.itemsValue[key] = this[key].code != undefined ? this[key].code : this[key]
                         }
                     } else if (key == 'noBranch') {
                         this.originalBranchCode = null
                     } else if (key == 'noCode') {
                         this.originalItemCode = null
                     } else {
                         delete this.itemsValue[key]
                     }
                 }

                 //DELETE EMPTY OBJECT
                 for (let key in this.itemsValue) {
                     if (this.itemsValue[key] == null || this.itemsValue[key] == '') {
                         delete this.itemsValue[key]
                     }
                 }

                 if (this.originalBranchCode != null) {
                     this.originalBranchCode = this.originalBranchCode.hasOwnProperty('code') ? this.originalBranchCode.code : this.originalBranchCode
                 }

                 let data = {
                     values: this.itemsValue,
                     function: this.function,
                     branchCode: this.originalBranchCode,
                     itemCode: this.originalItemCode,
                     assign: value == 'assign' ? true:false
                 }

                 //   console.log(this.itemsValue)

                 //FUNCTIONS
                 switch (this.function) {
                     case 'Create':
                     case 'Update':
                         this.$emit('closeDialog', false);
                         this.submitData(data);
                         break;
                     case 'Archive':
                     case 'Restore':
                     case 'Reset':
                         this.$emit('closeDialog', false);
                         this.changeData(data);
                         break;
                     case 'Delete':
                         this.$emit('closeDialog', true);
                         this.dialogDeleteClass = 'show';
                         this.cancelCountDown = false;
                         this.countDownTimer(data);
                         break;
                     default:
                         break;
                 }
             } else {
                 this.$refs.form.validate();
                 this.$emit('closeDialog', true);
             }
         },

         //COUNTDOWN BEFORE PERMANENT DELETE
         countDownTimer(data) {

             if (this.cancelCountDown == false) {
                 if (this.countDown > 0) {
                     setTimeout(() => {
                         this.countDown -= 1
                         this.countDownTimer(data)
                     }, 1000)
                 }
             }

             if (this.countDown == 0) {
                 this.changeData(data)
                 this.$emit("closeDialog", false)
                 this.dialogDeleteClass = 'hidden'
                 this.dialogDelete = false
                 this.cancelCountDown = true
                 this.countDown = 5
             }
         },
     },
     watch: {

         //GETTING DATA @CLICK OF BUTTONS IN ROWS
         items(newValue) {
             if (newValue != null && newValue != undefined) {

                 this.itemsValue = newValue

                 for (let key of this.checkValues) {
                     if (key != 'noBranch' && key != 'noCode') {
                         this[key] = newValue[key]
                     }
                 }

                 if (newValue.hasOwnProperty('branch')) {
                     this.originalBranchCode = newValue.branch
                 } else {
                     this.originalBranchCode = null
                 }

                 if (newValue.hasOwnProperty('code')) {
                     this.originalItemCode = newValue.code
                 } else if (newValue.hasOwnProperty('paymentCode')) {
                     this.originalItemCode = newValue.paymentCode
                 } else if (newValue.hasOwnProperty('employeeNumber')) {
                     this.originalItemCode = newValue.employeeNumber
                 } else if ((newValue.hasOwnProperty('studentNumber') || newValue.hasOwnProperty('priorityNumber')) &&
                     this.$router.currentRoute.name != 'Proof of Payment') {
                     this.originalItemCode = newValue.studentNumber != undefined ? newValue.studentNumber : newValue.priorityNumber
                 } else {
                     this.originalItemCode = null
                 }

             }
         },

         //WATCHING WHAT FUNCTION IS GOING TO BE USED
         dialogTitle(newValue) {
             this.function = newValue

             if (this.user.accountBranchType == 'MAIN') {
                 this.branchVisibility = 'show'
             } else {
                 this.branchVisibility = 'hidden'
             }

             switch (newValue) {
                 case 'Create':

                     if (this.$router.currentRoute.name.toUpperCase() != 'BRANCH') {
                         if (this.user.accountBranchType != 'MAIN') {
                             this.branch = {
                                 code: this.user.accountBranchCode,
                                 name: this.user.accountBranchName
                             }
                         }
                     } else {
                         this.branch = null
                     }

                     this.dialogBody = ''
                     this.dialogBodyColor = ''
                     this.dialogHeaderColor = 'info'
                     this.inputVisibility = 'show'
                     break;

                 case 'Update':
                     this.dialogBody = ''
                     this.dialogBodyColor = ''
                     this.dialogHeaderColor = 'primary'
                     this.inputVisibility = 'show'
                     break

                 case 'Archive':
                     this.dialogBody = 'Are you sure you want to archive '
                     this.dialogBodyColor = 'error--text'
                     this.dialogHeaderColor = 'error'
                     this.inputVisibility = 'hidden'
                     break

                 case 'Restore':
                     this.dialogBody = 'Are you sure you want to restore '
                     this.dialogBodyColor = 'primary--text'
                     this.dialogHeaderColor = 'primary'
                     this.inputVisibility = 'hidden'
                     break

                 case 'Delete':
                     this.dialogBody = 'Are you sure you want to permanently delete '
                     this.dialogBodyColor = 'error--text'
                     this.dialogHeaderColor = 'error'
                     this.inputVisibility = 'hidden'
                     break

                 case 'Reset':
                     this.dialogBody = 'Are you sure you want to reset '
                     this.dialogBodyColor = 'primary--text'
                     this.dialogHeaderColor = 'primary'
                     this.inputVisibility = 'hidden'
                     break

                 case 'Show':
                     this.dialogBody = ''
                     this.dialogBodyColor = 'primary--text'
                     this.dialogHeaderColor = 'primary'
                     this.inputVisibility = 'show'
                     break

                 default:
                     break;
             }
         },

         //FOR SUCCESS MESSAGE
         getterMessage() {
             this.changeBranch('setAll')
             this.clearError = true

             if (this.$refs.hasOwnProperty('form')) {
                 this.$refs.form.reset()
             }
             if (this.user.accountBranchType != 'MAIN' && this.clearError == true) {
                 this.resetBranch()
             }
         },

         //FOR ERROR MESSAGE
         getterOtherMessage(value) {
             //RETURN VALUES TO FORM
             if (value != null) {
                 if (value[1] == 422) {
                     this.clearError = false
                     for (let key of this.checkValues) {
                         if (key != 'noBranch' && key != 'noCode') {
                             this.itemsValue[key] = this[key]
                         }
                     }
                 } else {
                     this.clearError = true
                     if (this.$refs.hasOwnProperty('form')) {
                         this.$refs.form.reset()
                     }
                     if (this.user.accountBranchType != 'MAIN') {
                         this.resetBranch()
                     }
                 }
             }
         },

         //DIALOG WATCHER | TO CHANGE BUTTONLOADING VAL AND LIST OF INDEX ITEMS VAL
         dialog(newValue) {
             if (newValue == true) {
                 if (this.dialogTitle == 'Update' || this.dialogTitle == 'Create') {
                     if (this.dialogTitle == 'Update') {
                         this.changeBranch('fromOthers')
                     }
                     setTimeout(() => {
                         this.submitButtonLoading = false
                     }, 500)
                 } else {
                     this.submitButtonLoading = false
                 }
             } else {
                 this.submitButtonLoading = true
                 if (this.user.accountBranchType != 'MAIN' && this.clearError == true) {
                     this.resetBranch()
                 }
             }
         },
     },
 }
