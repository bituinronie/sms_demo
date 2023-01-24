<template>
    <div>
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
                                <v-col cols="12" md="6">
                                    <v-autocomplete v-model="action" :items="actionList" item-text="actionList"
                                        label="Action" return-object clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="description" type="text" label="Description" clearable>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete v-model="mod" :items="moduleList" item-text="moduleList"
                                        label="Module" return-object clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-autocomplete v-model="employee" :items="employeeList.ALL" item-text="fullName"
                                        label="User" persistent-hint return-object clearable>
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
                        <v-btn color="error" class="elevation-0 white--text my-2 px-2 float-right" @click="clearFilter">
                            ClearFilter
                        </v-btn>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>

            <div class="mt-4">
                <v-data-table class="tstyle" :headers="headers" :items="getterPageLoading == false ? itemList:[]" multi-sort :options="options"
                    :single-expand="singleExpand" :expanded.sync="expanded" item-key="random" show-expand
                    :class="getterPageLoading == null ? 'error-table' : getterPageLoading == true ? 'loading-table':''" 
                    :loading="getterPageLoading" :loading-text="$router.currentRoute.name+' is Being Downloaded...'" 
                    :no-data-text="getterErrorMessage != null ? getterErrorMessage:''">
                    <template v-slot:expanded-item="{ headers, item }">
                        <td :colspan="headers.length" height="100%">
                            <div v-if="values!= null">
                                <br>
                                <span>{{item.action == 'UPDATE'?'DATA THAT HAVE BEEN UPDATED:':'VALUES:'}}</span>
                                <hr>
                                <span v-for=" (value, key) in values" :key="key">
                                    <span>{{ key.toUpperCase() + ': ' }}</span>
                                    <span class="font-weight-normal">{{ value }}</span>
                                    <br>
                                </span>
                            </div>
                            <div v-if="oldValues!= null">
                                <br>
                                <span>OLD VALUES:</span>
                                <hr>
                                <span v-for=" (value, key) in oldValues" :key="key">
                                    <span>{{ key.toUpperCase() + ': ' }}</span>
                                    <span class="font-weight-normal">{{ value }}</span>
                                    <br>
                                </span>
                            </div>
                            <div v-if="newValues!= null">
                                <br>
                                <span>NEW VALUES:</span>
                                <hr>
                                <span v-for="(value, key) in newValues" :key="key">
                                    <span>{{ key.toUpperCase() + ': ' }}</span>
                                    <span class="font-weight-normal">{{ value }}</span>
                                    <br>
                                </span>
                            </div>
                            <br>
                        </td>
                    </template>
                </v-data-table>
            </div>

        </v-card>
    </div>
</template>
<script>
    import message from "../../../mixins/message";
    import loading from "../../../mixins/loading";
    import mainMixin from "../../../mixins/mainMixin";

    export default {
        mixins: [
            loading,
            message,
            mainMixin
        ],
        data() {
            return {
                expanded: [],
                singleExpand: true,
                oldValues: {},
                newValues: {},
                values: {},
                action: null,
                description: null,
                mod: null,
                employee: null,
                dates: [],
                dateMenu: false,
                options: {
                    page: 1,
                    itemsPerPage: 30,
                    multiSort: true,
                },
                indexList: [
                    'branch',
                    'employee'
                ]
            }
        },
        computed: {
            headers() {
                let defaultHeader = [{
                        text: 'Action',
                        value: 'action',
                        width: '10%',
                        filter: f => {
                            if (this.action != null) {
                                return f === this.action
                            } else {
                                return f
                            }
                        }
                    },
                    {
                        text: 'Description',
                        value: 'message',
                        width: '30%',
                        filter: f => {
                            if (this.description != null) {
                                return (f + '').toUpperCase().includes(this['description'].toUpperCase())
                            } else {
                                return f
                            }
                        }
                    },
                    {
                        text: 'Module',
                        value: 'module',
                        width: '20%',
                        filter: f => {
                            if (this.mod != null) {
                                return f === this.mod
                            } else {
                                return f
                            }
                        }
                    },
                    {
                        text: 'User',
                        value: 'causeBy.FULL NAME',
                        width: '20%',
                        filter: f => {
                            if (this.employee != null) {
                                return f === this.employee.fullName
                            } else {
                                return f
                            }
                        }
                    },
                    {
                        text: 'Date',
                        value: 'date',
                        width: '20%',
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
                    }
                ]
                return defaultHeader
            }
        },
        watch: {
            expanded(newValue) {
                this.oldValues = {}
                this.newValues = {}
                this.values = {}

                function reusableFunction(itemsValue) {
                    for (let key in itemsValue) {
                        if (typeof itemsValue[key] == 'object') {
                            if (key == 'EMPLOYEE') {
                                itemsValue[key] = itemsValue[key]['EMPLOYEE NUMBER']
                            } else {
                                itemsValue[key] = itemsValue[key].NAME != undefined ? itemsValue[key].NAME : itemsValue[
                                        key]
                                    .CODE
                            }
                        }
                    }
                }

                if (newValue.length != 0) {

                    if (newValue[0].causeTo != null) {
                        this.values = newValue[0].causeTo
                        reusableFunction(this.values)
                    }
                    switch (newValue[0].action) {
                        case 'CREATE':
                            this.newValues = newValue[0].data.new
                            this.oldValues = null
                            this.values = null
                            break;
                        case 'UPDATE':
                            if (newValue[0].data == null || (newValue[0].data.old == '' && newValue[0].data.new ==
                                    '')) {
                                if (newValue[0].message.split(" ")[0] != 'RESET') {
                                    this.oldValues = null
                                    this.newValues[''] = 'NO CHANGES HAVE BEEN MADE'
                                } else {
                                    this.newValues = null
                                    this.oldValues = null
                                }
                            } else {
                                this.oldValues = newValue[0].data.old
                                this.newValues = newValue[0].data.new
                                reusableFunction(this.oldValues)
                                reusableFunction(this.newValues)
                            }
                            break;

                        case 'DELETE':
                        case 'ARCHIVE':
                        case 'RESTORE':
                        case 'RESET':
                            this.newValues = null
                            this.oldValues = null
                            break;

                        case 'LOGIN':
                            this.oldValues = null
                            this.newValues = null
                            this.values = null
                            break;
                        default:
                            break;
                    }
                } else {
                    this.oldValues = null
                    this.newValues = null
                    this.values = null
                }
            }
        }
    }

</script>
