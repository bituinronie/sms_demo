<template>
    <v-dialog :value="dialog" width="700" persistent>
        <v-card>
            <v-card-title class="headline white--text" :class="dialogHeaderColor">
                {{dialogTitle}} {{this.$route.name}}
            </v-card-title>

            <v-card-text class="mt-4">
                <span class="my-5" :class="dialogBodyColor" v-if="dialogBody != '' && dialogDeleteClass =='hidden'">
                    {{dialogBody + itemsValue.name + '?'}}
                </span>

                <div :class="dialogDeleteClass">
                    <span class="error--text my-5" v-if="dialogBody != ''">
                        {{itemsValue.name + ' will be permanently deleted in:'}}
                    </span>
                    <h1 class="text-center font-weight-bold mt-4 red--text">{{countDown}}</h1>
                </div>

                <div :class="inputVisibility">
                    <v-form ref="form" :value="valid" class="mx-3" lazy-validation>
                        <v-autocomplete v-model="branch" :items="branchList.ALL" item-text="name" label="Branch"
                            :rules="$rules.required('Branch')" :class="branchVisibility" @change="changeBranch()"
                            return-object>
                        </v-autocomplete>
                        <v-autocomplete v-model="department"
                            :items="user.accountBranchType == 'MAIN' ? departmentList[branch != null ? branch.name:'ALL']:departmentList.ALL"
                            item-text="name" label="Department" :rules="$rules.required('Department')"
                            :loading="departmentList == 'LOADING' ? true: false"
                            :hint="departmentList=='LOADING'?'Department List is being downloaded.':''" persistent-hint
                            return-object>
                        </v-autocomplete>
                        <v-text-field v-model="itemsValue.code" label="Code" :rules="$rules.required('Code')"
                            @input="changeToUpperCase('code')">
                        </v-text-field>
                        <v-text-field v-model="itemsValue.name" @input="changeToUpperCase('name')" label="Name"
                            :rules="$rules.required('Name')">
                        </v-text-field>
                        <v-autocomplete v-model="itemsValue.type" :items="programTypeList" item-text="programTypeList"
                            label="Type" :rules="$rules.required('Type')" return-object>
                        </v-autocomplete>
                        <v-autocomplete v-model="itemsValue.duration" :items="programDurationList" item-text="text"
                            label="Duration" :rules="$rules.required('Duration')" return-object
                            @change="durationChange">
                        </v-autocomplete>
                        <v-autocomplete v-model="employee"
                            :items="user.accountBranchType == 'MAIN' ? employeeList[branch != null ? branch.name:'ALL']:employeeList.ALL"
                            item-text="fullName" label="Program Head" :loading="employeeList == 'LOADING' ? true: false"
                            :hint="employeeList=='LOADING'?'Employee List is being downloaded.':''" persistent-hint
                            return-object clearable>
                        </v-autocomplete>
                    </v-form>

                    <div v-if="errorStatus == 422 && clearError == false" class="pa-2 white--text error rounded">
                        <span v-for="(value, index) in message" :key="index">
                            {{value}} <br>
                        </span>
                    </div>
                </div>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions class="py-4">
                <v-spacer></v-spacer>
                <v-btn :color="dialogHeaderColor == 'error'?'warning':'error'" depressed @click="cancel()">
                    Cancel
                </v-btn>
                <v-btn :color="dialogHeaderColor" depressed @click="validate()" v-if="dialogDeleteClass == 'hidden'"
                    :loading="departmentList =='LOADING'?true:false">
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import subMixin from "../../../mixins/subMixin";
    export default {
        mixins: [
            subMixin
        ],
        data() {
            return {
                branch: null,
                department: null,
                employee: null,
                checkValues: [
                    'branch',
                    'employee',
                    'department'
                ]
            }
        },
        methods: {
            durationChange() {
                this.itemsValue.duration = this.itemsValue.duration.value
            },
        },
    }

</script>
