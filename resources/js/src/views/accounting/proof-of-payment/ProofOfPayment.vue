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
                                <v-col cols="12" md="6" v-if="$auth.credentials().accountBranchType == 'MAIN'">
                                    <v-autocomplete v-model="branch" :items="branchList.ALL" item-text="name"
                                        label="Branch" persistent-hint return-object clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="code" type="text" label="Code" clearable>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="priorityNumber" type="number" label="ID Number"
                                        clearable>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="fullName" type="text" label="Name" clearable>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete v-model="type" :items="paymentTypeList"
                                        item-text="paymentTypeList" label="Payment Type" persistent-hint
                                        return-object clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="amount" type="number" label="Amount" clearable>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6" v-if="list != 'ARCHIVE LIST'">
                                    <v-autocomplete v-model="status" :items="paymentStatusList"
                                        item-text="paymentStatusList" label="Payment Status" return-object
                                        clearable></v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-menu v-model="dateMenu" :close-on-content-click="false" :nudge-right="40"
                                        transition="scale-transition" offset-y min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="dates" label="Select Range"
                                                prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"
                                                clearable>
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
                        <v-btn color="error" class="elevation-0 white--text my-2 px-2 float-right" @click="clearFilter">
                            ClearFilter
                        </v-btn>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>

            <div class="mt-4">
                <v-data-table  class="tstyle" :headers="headers" :items="getterPageLoading == false ? itemList:[]" :single-expand="singleExpand" :expanded.sync="expanded"
                    item-key="random" show-expand multi-sort :loading="getterPageLoading" :loading-text="$router.currentRoute.name + ' List is Being Downloaded...'"
                    :class="getterPageLoading == null ? 'error-table' : getterPageLoading == true ? 'loading-table':''" 
                    :no-data-text="getterErrorMessage != null ? getterErrorMessage:''">
                    <template v-slot:expanded-item="{ headers, item }">
                        <td :colspan="headers.length" height="100%">
                            <v-simple-table class="mt-2 text-xs" dense>
                                <template v-slot:default>
                                    <tbody>
                                        <tr>
                                            <td width="20%">EDUCATIONAL LEVEL:</td>
                                            <td width="80%">{{ item.educationLevel }}</td>
                                        </tr>
                                        <tr>
                                            <td>GRADE/YEAR LEVEL:</td>
                                            <td>{{ item.gradeYearLevel }}</td>
                                        </tr>
                                        <tr>
                                            <td>SEMESTER:</td>
                                            <td>{{ item.semester }}</td>
                                        </tr>
                                        <tr>
                                            <td>SCHOOL YEAR:</td>
                                            <td>{{ item.schoolYear }}</td>
                                        </tr>
                                        <tr class="info--text">
                                            <td>REMARKS:</td>
                                            <td>{{ item.remark }}</td>
                                        </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                            <hr class="my-4">
                            <center>
                                <v-img
                                    v-if="(item.paymentReceipt.split('.').pop() == 'png' || item.paymentReceipt.split('.').pop() == 'jpeg' || item.paymentReceipt.split('.').pop() == 'jpg') && dropdown == true"
                                    :src="`${$path.fileBaseUrl()}/student/${item.priorityNumber}/${item.paymentReceipt}`"
                                    :max-width="`${$vuetify.breakpoint.width * .8}`" @error="paymentError"></v-img>

                                <iframe v-else-if="item.paymentReceipt.split('.').pop() == 'pdf'"
                                    :src="`${$path.fileBaseUrl()}/student/${item.priorityNumber}/${item.paymentReceipt}`"
                                    :width="`${$vuetify.breakpoint.width * .8}`"
                                    :height="`${$vuetify.breakpoint.height * .8}`" frameborder="0"></iframe>

                                <div v-else class="error--text mb-4">
                                    File not Found
                                </div>
                            </center>
                        </td>
                    </template>
                    <template v-slot:[`item.actions`]="{ item }">
                        <td v-if="list == 'OFFICIAL LIST'">
                            <div class="d-inline mx-1">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon dense color="primary" dark v-bind="attrs" v-on="on"
                                            @click="buttonFunction('Update',item)">
                                            mdi-pencil
                                        </v-icon>
                                    </template>
                                    <span>Update Status</span>
                                </v-tooltip>
                            </div>
                            <div class="d-inline mx-1">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon dense color="red" dark v-bind="attrs" v-on="on"
                                            @click="buttonFunction('Archive',item)">
                                            mdi-archive
                                        </v-icon>
                                    </template>
                                    <span>Archive</span>
                                </v-tooltip>
                            </div>
                        </td>
                        <td v-else>
                            <v-btn depressed color="primary" small @click="buttonFunction('Restore',item)">
                                <v-icon left small>
                                    mdi-restore
                                </v-icon>
                                Restore
                            </v-btn>
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

                :paymentStatusList="paymentStatusList"

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
                dates: [],
                dateMenu: false,
                branch: null,
                type: null,
                status: null,
                code: null,
                priorityNumber: null,
                fullName: null,
                amount: null,
                dropdown: false,
                indexList: ['branch']
            }
        },
        methods: {
            paymentError() {
                this.dropdown = false
            }
        },
        computed: {
            headers() {
               return [
                    {
                        text: 'Branch',
                        value: 'branchName',
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
                        text: 'Payment Code',
                        value: 'paymentCode',
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
                        text: 'ID Number',
                        value: 'priorityNumber',
                        width: '10%',
                        filter: f => {
                            if (this.priorityNumber != null) {
                                return (f + '').includes(this['priorityNumber'])
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
                        text: 'Payment Type',
                        value: 'paymentType',
                        width: '10%',
                        filter: f => {
                            if (this.type == null) {
                                return f + ''
                            } else if(this.type == 'OTHER'){
                                return (f + '').includes(this['type'])
                            }
                            else {
                                return f === this.type
                            }
                        }
                    },
                    {
                        text: 'Amount',
                        value: 'amount',
                        width: '10%',
                        filter: f => {
                            if (this.amount != null) {
                                return (f + '').includes(this['amount'])
                            } else {
                                return f
                            }
                        }
                    },
                    {
                        text: "Status",
                        value: "paymentStatus",
                        align: 'left',
                        width: '10%',
                        filter: f => {
                            if (this.status == null) {
                                return f + ''
                            } else {
                                return f === this.status
                            }
                        },
                        class: this.list != 'OFFICIAL LIST' ? 'hidden':'',
                        cellClass: this.list != 'OFFICIAL LIST' ? 'hidden':''
                    }, 
                    {
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
                        text: "Actions",
                        value: "actions",
                        align: 'left',
                        width: '10%',
                    }
                ]
            }
        },
        watch: {
            expanded() {
                this.dropdown = true
            },
        },
        mounted(){
            this.wCreate = false
        }
    }

</script>
