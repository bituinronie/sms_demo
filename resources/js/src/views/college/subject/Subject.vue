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
                                    <v-autocomplete v-model="type" :items="subjectTypeList"
                                        item-text="subjectTypeList" label="Type" persistent-hint return-object
                                        clearable>
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
            <div class="mt-4">
                <v-data-table class="tstyle" :headers="headers" :items="getterPageLoading == false ? itemList:[]" :single-expand="singleExpand" :expanded.sync="expanded"
                    item-key="random" show-expand multi-sort :loading="getterPageLoading" :loading-text="$router.currentRoute.name + ' List is Being Downloaded...'"
                    :class="getterPageLoading == null ? 'error-table' : getterPageLoading == true ? 'loading-table':''" 
                    :no-data-text="getterErrorMessage != null ? getterErrorMessage:''">
                    <template v-slot:expanded-item="{ headers, item }">
                        <td :colspan="headers.length" height="100%">
                            <v-simple-table class="mt-2 text-xs" dense>
                                <template v-slot:default>
                                    <tbody>
                                        <tr>
                                            <td width="20%">Lecture Unit/s:</td>
                                            <td width="30%">{{ item.lectureUnit }}</td>
                                            <td width="20%">Lecture Hour/s:</td>
                                            <td width="30%">{{ item.lectureHour }}</td>
                                        </tr>
                                        <tr v-if="item.laboratory != null">
                                            <td width="20%">Laboratory:</td>
                                            <td colspan="3" width="80%">{{ item.laboratory.name }}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">Laboratory Unit/s:</td>
                                            <td width="30%">{{ item.laboratoryUnit }}</td>
                                            <td width="20%">Laboratory Hour/s:</td>
                                            <td width="30%">{{ item.laboratoryHour }}</td>
                                        </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                        </td>
                    </template>
                    <template v-slot:[`item.actions`]="{ item }">
                        <td v-if="list == 'OFFICIAL LIST'">
                            <div class="d-inline mx-1">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon dense color="primary" dark v-bind="attrs" v-on="on"
                                            @click="buttonFunction('Update', item)">
                                            mdi-pencil
                                        </v-icon>
                                    </template>
                                    <span>Update</span>
                                </v-tooltip>
                            </div>
                            <div class="d-inline mx-1">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon dense color="red" dark v-bind="attrs" v-on="on"
                                            @click="buttonFunction('Archive', item)">
                                            mdi-archive
                                        </v-icon>
                                    </template>
                                    <span>Archive</span>
                                </v-tooltip>
                            </div>
                        </td>
                        <td v-else>
                            <div class="d-inline mx-1">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon dense color="primary" dark v-bind="attrs" v-on="on"
                                            @click="buttonFunction('Restore', item)">
                                            mdi-restore
                                        </v-icon>
                                    </template>
                                    <span>Restore</span>
                                </v-tooltip>
                            </div>
                            <div class="d-inline mx-1">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon dense color="red" dark v-bind="attrs" v-on="on" @click="buttonFunction('Delete', item)">
                                            mdi-delete
                                        </v-icon>
                                    </template>
                                    <span>Delete</span>
                                </v-tooltip>
                            </div>
                        </td>
                    </template>
                </v-data-table>
            </div>
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
                :laboratoryList="laboratoryList" 
                :departmentList="departmentList" 
                :subjectTypeList="subjectTypeList"

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
                expanded: [],
                singleExpand: true,
                branch: null,
                code: null,
                name: null,
                type: null,
                department: null,
                indexList:[
                    'branch',
                    'department',
                    'laboratory'
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
                        width: this.user.accountBranchType == 'MAIN'?'35%':'45%',
                        filter: f => {
                            if (this.name != null) {
                                return (f + '').toUpperCase().includes(this['name'].toUpperCase())
                            } else {
                                return f
                            }
                        }
                    },
                    {
                        text: 'Type',
                        value: 'type',
                        width: this.user.accountBranchType == 'MAIN'?'15%':'20%',
                        filter: f => {
                            if (this.type != null) {
                                return f === this.type
                            } else {
                                return f
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
