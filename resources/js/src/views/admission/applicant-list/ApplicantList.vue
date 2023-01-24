<template>
    <div>
        <div v-if="getterPageLoading == false">
            <Alert :alert="alert" :typeValue="typeValue" :alertMessage="this.message" @updateAlert="onUpdateAlert" />
        </div>

        <v-row>
            <v-col cols="12" md="3">
                <v-btn color="info" class="elevation-0 white--text mt-2 px-2" @click="redirectCreate">
                    Create Applicant
                </v-btn>
            </v-col>
            <v-col cols="12" md="5">
            </v-col>
            <v-col cols="12" md="4">
                <v-select v-if="$route.name.toUpperCase() != 'DASHBOARD'" v-model="list" :items="listOption"
                    item-text="listOption" label="Option" @change="listChange(list)" return-object
                    :disabled="getterPageLoading">
                </v-select>
            </v-col>
        </v-row>
        <v-card class="mt-5 elevation-0">

            <v-expansion-panels flat v-model="panel" class="filter-panel">
                <v-expansion-panel>
                    <v-expansion-panel-header outlined color="blue">
                        <span class="white--text">
                            <v-icon color="white">mdi-filter</v-icon>
                            Filter
                        </span>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-form ref="filterForm">
                            <v-row class="my-2" dense>
                                <v-col cols="12" md="6" v-if="user.accountBranchType == 'MAIN'">
                                    <v-autocomplete v-model="branch" :items="branchList.ALL" item-text="name"
                                        label="Branch" return-object clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="priorityNumber" type="number" label="ID Number" clearable>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="fullName" type="text" label="Full Name" clearable>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete v-model="gradeYearLevel" :items="gradeYearList"
                                        item-text="gradeYearList" label="Grade/Year Level" return-object clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete v-model="educLevel" :items="educList" item-text="educList"
                                        label="Educational Level" return-object clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <v-autocomplete v-model="programOrStrand" :items="strandList.ALL"
                                                item-text="code" label="Strand" persistent-hint return-object clearable>
                                            </v-autocomplete>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-autocomplete v-model="programOrStrand" :items="programList.ALL"
                                                item-text="code" label="Program" persistent-hint return-object
                                                clearable>
                                            </v-autocomplete>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete v-model="semester" :items="semesterList" item-text="semesterList"
                                        label="Semester" return-object clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete v-model="schoolYear" :items="schoolYearList"
                                        item-text="schoolYearList" label="School Year" return-object clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6" v-if="list != 'ARCHIVE LIST'">
                                    <v-autocomplete v-model="applicantStatus" :items="statusList" item-text="statusList"
                                        label="Status" return-object clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-menu v-model="dateMenu" :close-on-content-click="false" :nudge-right="40"
                                        transition="scale-transition" offset-y min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="dates" label="Select Range"
                                                prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" clearable>
                                            </v-text-field>
                                        </template>
                                        <v-date-picker v-model="dates" range>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="error" @click="dateMenu = false, dates = null">
                                                Cancel
                                            </v-btn>
                                            <v-btn text color="primary" @click="dateMenu = false">
                                                OK
                                            </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>
                            </v-row>
                        </v-form>
                        <v-btn color="error" class="elevation-0 white--text mt-2 px-2" @click="clearFilter">
                            ClearFilter
                        </v-btn>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>

            <v-data-table :headers="headers" :items="getterPageLoading == false ? applicantList:[]"
                class="pointer elevation-0 mt-5 tstyle" multi-sort @click:row="redirect" :loading="getterPageLoading"
                loading-text="Applicant List is Being Downloaded..."
                :class="getterPageLoading == null ? 'error-table' : getterPageLoading == true ? 'loading-table':''" 
                :no-data-text="getterErrorMessage != null ? getterErrorMessage:''">
                <template v-slot:[`item.actions`]="{ item }" v-if="list == 'ARCHIVE LIST'">
                    <td>
                        <div class="d-inline mx-1">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon dense color="primary" dark v-bind="attrs" v-on="on"
                                        @click="restoreDialog(item)">
                                        mdi-restore
                                    </v-icon>
                                </template>
                                <span>Restore</span>
                            </v-tooltip>
                        </div>
                        <div class="d-inline mx-1">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon dense color="red" dark v-bind="attrs" v-on="on" @click="deleteDialog(item)">
                                        mdi-delete
                                    </v-icon>
                                </template>
                                <span>Delete</span>
                            </v-tooltip>
                        </div>
                    </td>
                </template>
            </v-data-table>
        </v-card>

        <div>
            <Form 
                :dialog="dialog" 
                :dialogTitle="dialogTitle" 
                :items="items" 
                :resetPageLoading="resetPageLoading"
                @closeDialog="onCloseDialog" 
            />
        </div>
    </div>
</template>
<script>
    import {
        mapActions,
        mapState,
        mapGetters,
        mapMutations
    } from 'vuex'

    import Form from "./Form";

    import message from "../../../mixins/message";
    import loading from "../../../mixins/loading";

    export default {
        components: {
            Form
        },
        mixins: [
            message,
            loading
        ],
        data() {
            return {
                panel: 1,
                dates: [],
                dateMenu: false,
                branch: null,
                priorityNumber: null,
                fullName: null,
                gradeYearLevel: null,
                educLevel: null,
                programOrStrand: null,
                semester: null,
                schoolYear: null,
                applicantStatus: null,
                dialog: false,
                dialogTitle: null,
                alert: false,
                typeValue: 'success',
                message: '',
                listOption: ['OFFICIAL LIST', 'ARCHIVE LIST'],
                list: '',
                items: {},
                user: {}
            }
        },
        computed: {
            ...mapState({
                applicantList: state => state.applicantList.list,
                statusList: state => state.applicantList.status,
                schoolYearList: state => state.applicantList.schoolYear,
                educList: state => state.indexList.schoolLevelList,
                gradeYearList: state => state.indexList.allGradeYearLevelList,
                semesterList: state => state.indexList.semesterList,

                branchList: state => state.indexList.branchList,
                programList: state => state.indexList.programList,
                strandList: state => state.indexList.strandList,
            }),
            ...mapGetters('applicantList', [
                'getterListOption'
            ]),
            headers() {
                return [{
                        text: 'Branch',
                        value: 'branch',
                        width: '15%',
                        filter: f => {
                            if (this.branch == null) {
                                return f + ''
                            } else {
                                return f === this.branch.name
                            }
                        },
                        class: this.user.accountBranchType != 'MAIN' ? 'hidden' : '',
                        cellClass: this.user.accountBranchType != 'MAIN' ? 'hidden' : ''
                    },
                    {
                        text: 'ID Number',
                        value: 'priorityNumber',
                        width: '10%',
                        filter: f => {
                            if (this.priorityNumber == null || this
                                .priorityNumber == 0) {
                                return f
                            } else {
                                return (f + '').includes(this['priorityNumber'])
                            }
                        }
                    },
                    {
                        text: "Full Name",
                        value: "fullName",
                        align: 'left',
                        width: '20%',
                        filter: f => {
                            if (this.fullName == null) {
                                return f
                            } else {
                                return (f + '').toUpperCase().includes(this['fullName'].toUpperCase())
                            }
                        }
                    },
                    {
                        text: 'Grade/Year',
                        value: 'gradeYearLevel',
                        filter: f => {
                            if (this.gradeYearLevel == null) {
                                return f
                            } else {
                                return f === this.gradeYearLevel
                            }
                        }
                    },
                    {
                        text: 'Educational Level',
                        value: 'educationLevel',
                        width: '10%',
                        filter: f => {
                            if (this.educLevel == null) {
                                return f
                            } else {
                                return f === this.educLevel
                            }
                        }
                    },

                    {
                        text: 'Program/Strand',
                        value: 'programOrStrand',
                        width: '15%',
                        filter: f => {
                            if (this.programOrStrand == null) {
                                return f + ''
                            } else {
                                return f === this.programOrStrand.code
                            }
                        }
                    },
                    {
                        text: 'Semester',
                        value: 'semester',
                        filter: f => {
                            if (this.semester == null) {
                                return f
                            } else {
                                return f === this.semester
                            }
                        }
                    },
                    {
                        text: 'School Year',
                        value: 'schoolYear',
                        filter: f => {
                            if (this.schoolYear == null) {
                                return f
                            } else {
                                return f === this.schoolYear
                            }
                        }
                    },
                    {
                        text: 'Status',
                        value: 'applicantStatus',
                        filter: f => {
                            if (this.applicantStatus == null) {
                                return f
                            } else {
                                return f === this.applicantStatus
                            }
                        },
                        class: this.list != 'OFFICIAL LIST' ? 'hidden' : '',
                        cellClass: this.list != 'OFFICIAL LIST' ? 'hidden' : ''
                    }, {
                        text: "Date",
                        value: "date",
                        align: 'left',
                        width: '15%',
                        filter: f => {
                            if (this.dates == null) {
                                return f
                            } else {
                                if (this.dates.length == 0) {
                                    return f
                                } else if (this.dates.length == 1) {
                                    return f === this.$dateFormat.mdy(this.dates[0])
                                } else {
                                    if (this.dates[0] < this.dates[1]) {
                                        return f >= this.$dateFormat.mdy(this.dates[0]) && f <= this
                                            .$dateFormat.mdy(this.dates[1])
                                    } else if (this.dates[0] > this.dates[1]) {
                                        return f >= this.$dateFormat.mdy(this.dates[1]) && f <= this
                                            .$dateFormat.mdy(this.dates[0])
                                    } else {
                                        return f === this.$dateFormat.mdy(this.dates[0])
                                    }
                                }
                            }
                        }
                    },
                    {
                        text: 'Actions',
                        value: 'actions',
                        width: '7%',
                        class: this.list == 'OFFICIAL LIST' ? 'hidden' : '',
                        cellClass: this.list == 'OFFICIAL LIST' ? 'hidden' : ''
                    }
                ]
            }

        },
        methods: {
            ...mapActions('applicantList', [
                'getLists', 'report'
            ]),
            ...mapActions('indexList', [
                'getIndexLists'
            ]),
            ...mapMutations('applicantList', ['SET_LIST']),
            redirect(row) {
                var priorityNumber = row.priorityNumber;
                if (this.list == 'OFFICIAL LIST') {
                    this.$router.push({
                        name: 'View Applicant',
                        params: {
                            id: priorityNumber
                        }
                    });
                }
            },
            redirectCreate() {
                this.$router.push({
                    name: 'Create Applicant',
                });
            },
            restoreDialog(item) {
                this.items = item
                this.dialog = true
                this.dialogTitle = 'Restore'
            },
            deleteDialog(item) {
                this.items = item
                this.dialog = true
                this.dialogTitle = 'Delete'
            },
            onCloseDialog(newValue) {
                this.dialog = newValue
            },
            listChange(value) {
                this.resetPageLoading();
                this.SET_LIST(value);
                this.getLists(value)
            },
            clearFilter() {
                this.$refs.filterForm.reset()
                this.panel = 1
            },
        },
        watch: {
            getterMessage: function (newMessage) {
                if (newMessage != null) {
                    this.alert = true
                    this.typeValue = 'success'
                    this.message = newMessage[0]
                }
            },
            getterOtherMessage: function (newMessage) {
                if (newMessage != null) {
                    this.alert = true
                    this.typeValue = 'error'
                    this.message = newMessage[0]
                }
            },
            getterListOption(newValue) {
                if (newValue != null) {
                    this.list = newValue
                }
            },
        },
        mounted() {
            this.list = this.getterListOption
            this.getLists(this.list)
            this.getIndexLists('branch')
            this.getIndexLists('program')
            this.getIndexLists('strand')

            this.user = this.$auth.credentials()
            if (this.getterSecondRedirect != null) {
                this.alert = true
                this.typeValue = 'success'
                this.message = this.getterSecondRedirect
            }
        },
        beforeDestroy() {
            this.resetPageLoading();
            this.resetOtherMessage();
            this.resetErrorMessage();
            this.resetSecondRedirect();
            this.resetMessage();
            this.SET_LIST('OFFICIAL LIST');
        },
    }

</script>
