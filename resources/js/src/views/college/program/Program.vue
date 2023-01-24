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
            :wCreate="wCreate"
            :buttonFunction="buttonFunction"
            :getterPageLoading="getterPageLoading"
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
                                    <v-autocomplete v-model="department" :items="departmentList.ALL" item-text="code"
                                        label="Department" persistent-hint return-object clearable>
                                    </v-autocomplete>
                                </v-col>    
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="code" type="text" label="Code" clearable>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="name" type="text" label="Name" clearable></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete v-model="duration" :items="programDurationList" item-text="text"
                                        label="Duration" persistent-hint return-object clearable>
                                    </v-autocomplete>
                                </v-col>   
                                <v-col cols="12" md="6">
                                    <v-autocomplete v-model="employee" :items="employeeList.ALL" item-text="fullName"
                                        label="Head" persistent-hint return-object clearable>
                                    </v-autocomplete>
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
                :departmentList="departmentList"
                :employeeList="employeeList"
                :programTypeList="programTypeList"
                :programDurationList="programDurationList" 

                :message="message" 
                :errorStatus="errorStatus" 
                :getterMessage="getterMessage" 
                :getterOtherMessage="getterOtherMessage" 
                :resetPageLoading="resetPageLoading"
                @closeDialog="onCloseDialog" 
            />
        </div>
    </div>
</template>
<script>
    import Form from "./Form";

    import message from "../../../mixins/message";
    import loading from "../../../mixins/loading";
    import mainMixin from "../../../mixins/mainMixin";

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
                code: null,
                name: null,
                type: null,
                duration: null,
                department: null,
                employee: null,
                indexList: [
                    'branch',
                    'employee',
                    'department'
                ]
            }
        },
        computed: {
            headers() {
                return [
                     {
                        text: 'Branch',
                        value: 'branch.name',
                        width: '15%',
                        filter: f => {
                            if (this.branch == null) {
                                return f + ''
                            } else {
                                return f === this.branch.name
                            }
                        },
                        class: this.user.accountBranchType != 'MAIN' ? 'hidden':'',
                        cellClass: this.user.accountBranchType != 'MAIN' ? 'hidden':''
                    },
                    {
                        text: 'Code',
                        value: 'code',
                        width: '10%',
                        filter: f => {
                            if (this.code != null) {
                                return (f + '').toUpperCase().includes(this['code'].toUpperCase())
                            } else {
                                return f
                            }
                        }
                    },
                    {
                        text: 'Name',
                        value: 'name',
                        width: this.user.accountBranchType == 'MAIN'?'25%':'30%',
                        filter: f => {
                            if (this.name != null) {
                                return (f + '').toUpperCase().includes(this['name'].toUpperCase())
                            } else {
                                return f
                            }
                        }
                    },
                    {
                        text: 'Duration',
                        value: 'duration',
                        width: '10%',
                        filter: f => {
                            if (this.duration == null) {
                                return f
                            } else {
                                return f === this.duration.value
                            }
                        }
                    },
                    {
                        text: 'Type',
                        value: 'type',
                        width: '10%',
                        filter: f => {
                            if (this.type == null) {
                                return f
                            } else {
                                return f === this.type
                            }
                        }
                    },
                    {
                        text: 'Department',
                        value: 'department.code',
                        width: '10%',
                        filter: f => {
                            if (this.department == null) {
                                return f
                            } else {
                                return f === this.department.code
                            }
                        }
                    },
                    {
                        text: 'Head',
                        value: 'employee.fullName',
                        width: this.user.accountBranchType == 'MAIN'?'10%':'20%',
                        filter: f => {
                            if (this.employee == null) {
                                return f + ''
                            } else {
                                return f === this.employee.fullName
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
    }

</script>
