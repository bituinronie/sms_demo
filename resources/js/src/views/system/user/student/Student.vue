<template>
    <div>
        <div v-if="getterPageLoading == false">
            <Alert v-if="errorStatus == 1" :alert="alert" :typeValue="typeValue" :alertMessage="this.message"
                @updateAlert="onUpdateAlert" @errorChange="onErrorChange" />
        </div>
            
        <DefaultHeader 
            :list="list"
            :listChange="listChange"
            :listOption="listOption"
            :buttonFunction="buttonFunction"
            :wCreate="wCreate"
            @changeListValue="listChange"
        />

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
                                        label="Branch" persistent-hint return-object clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="studentNumber" type="text" label="Student Number" clearable>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="fullName" type="text" label="Full Name" clearable></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete v-model="gradeYearLevel" :items="allGradeYearLevelList"
                                        item-text="allGradeYearLevelList" label="Grade/Year Level" persistent-hint return-object
                                        clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete v-model="educationalLevel" :items="schoolLevelList"
                                        item-text="schoolLevelList" label="Educational Level" persistent-hint
                                        return-object clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <v-autocomplete v-model="programOrStrand" :items="strandList.ALL" item-text="code"
                                                label="Strand" persistent-hint return-object clearable>
                                            </v-autocomplete>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-autocomplete v-model="programOrStrand" :items="programList.ALL" item-text="code"
                                                label="Program" persistent-hint return-object clearable>
                                            </v-autocomplete>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-form>
                        <v-btn color="error" class="elevation-0 white--text my-2 px-2 float-right" @click="clearFilter">
                            ClearFilter
                        </v-btn>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>

             <DefaultTable 
                :list="list" 
                :headers="headers" 
                :itemList="itemList" 
                :buttonFunction="buttonFunction"
                :getterPageLoading="getterPageLoading"
                :getterErrorMessage="getterErrorMessage"

                :redirect="redirect"
                :wRedirect="wRedirect"
                :dataTableButtons="dataTableButtons"
                @btnClickValue="changeBtnClickValue"
            />

        </v-card>
       
        <div>
            <Form 
                :user="user"
                :list="list"
                :items="items"
                :getLists="getLists"

                :dialog="dialog" 
                :dialogTitle="dialogTitle" 

                :branchList="branchList"
                :studentList="studentList"

                :errorStatus="errorStatus" 
                :message="message" 
                :resetPageLoading="resetPageLoading"
                :getterMessage="getterMessage" 
                :getterOtherMessage="getterOtherMessage" 
                @closeDialog="onCloseDialog" 
            />
        </div>
    </div>
</template>
<script>
    import Form from "./Form";

    import message from "../../../../mixins/message";
    import loading from "../../../../mixins/loading";
    import mainMixin from "../../../../mixins/mainMixin";

    export default {
        components: {
            Form
        },
        mixins: [
            message,
            loading,
            mainMixin
        ],
        data() {
            return {
                branch: null,
                studentNumber: null,
                fullName: null,
                gradeYearLevel: null,
                educationalLevel: null,
                programOrStrand: null,
                indexList:[
                    'branch',
                    'student',
                    'strand',
                    'program'
                ]
            }
        },
        computed: {
            headers() {
                return [
                     {
                        text: 'Branch',
                        value: 'branch',
                        width: '15%',
                        filter: f => {
                            if (this.branch == null) {
                                return f + ''
                            } else {
                                return f === this.branch
                            }
                        },
                        class: this.user.accountBranchType != 'MAIN' ? 'hidden':'',
                        cellClass: this.user.accountBranchType != 'MAIN' ? 'hidden':''
                    },
                    {
                        text: 'Student Number',
                        value: 'studentNumber',
                        width: '10%',
                        filter: f => {
                            if (this.studentNumber != null) {
                                return (f + '').includes(this['studentNumber'])
                            } else {
                                return f
                            }
                        }
                    },
                    {
                        text: 'Name',
                        value: 'fullName',
                        width: '25%',
                        filter: f => {
                            if (this.fullName != null) {
                                return (f + '').toUpperCase().includes(this['fullName'].toUpperCase())
                            } else {
                                return f
                            }
                        }
                    },
                    {
                        text: 'Grade/Year',
                        value: 'gradeYearLevel',
                        width: '10%',
                        filter: f => {
                            if (this.gradeYearLevel == null) {
                                return f
                            } else {
                                return (f + '').includes(this['gradeYearLevel'])
                            }
                        }
                    },
                    {
                        text: 'Educational Level',
                        value: 'educationLevel',
                        width: '15%',
                        filter: f => {
                            if (this.educationalLevel == null) {
                                return f
                            } else {
                                return (f + '').includes(this['educationalLevel'])
                            }
                        }
                    },
                    {
                        text: 'Program/Strand',
                        value: 'programOrStrand',
                        width: '10%',
                        filter: f => {
                            if (this.programOrStrand == null) {
                                return f + ''
                            } else {
                                return f === this.programOrStrand.code
                            }
                        }
                    },
                    {
                        text: 'Actions',
                        value: 'actions',
                        width: '15%',
                        sortable: false,
                    }
                ]
            }
        },
         mounted(){
              this.dataTableButtons = {
                index: [
                    'reset',
                    'archive',
                ],
                list: [
                    'button',
                    'restore',
                ]
            }
        }
    }

</script>
