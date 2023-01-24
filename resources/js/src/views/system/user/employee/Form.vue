<template>
    <v-dialog :value="dialog" width="700" persistent>
        <v-card>
            <v-card-title class="headline white--text" :class="dialogHeaderColor">
                {{dialogTitle}} {{dialogTitle == 'Reset' ? ' Password': ' User'}}
            </v-card-title>

            <v-card-text class="mt-4">
                <span class="my-5" :class="dialogBodyColor" v-if="dialogBody != '' && dialogDeleteClass =='hidden'">
                    {{dialogBody}} {{dialogTitle == 'Reset' ? ' the password of ' : ''}} {{employeeName + '?'}}
                </span>

                <div :class="inputVisibility">
                    <v-form ref="form" :value="valid" lazy-validation class="mx-3">

                        <small class="info--text">**Note: You can choose from the list of
                            <span class="font-weight-bold">Names or Employee Numbers.</span>
                        </small>

                        <v-autocomplete v-if="user.accountBranchType == 'MAIN'" v-model="branch" :items="branchList.ALL"
                            item-text="name" label="Branch"
                            hint="This is not required. This is for filtering of Employees only." persistent-hint
                            return-object @change="branchChange(), changeBranch()" clearable>
                        </v-autocomplete>
                        <v-autocomplete v-model="employeeInformation"
                            :items="user.accountBranchType == 'MAIN' ? employeeList[branch != null ? branch.name:'ALL']:employeeList.ALL"
                            item-text="fullName" label="Name" :rules="$rules.required('Name')"
                            :loading="employeeList =='LOADING'? true: false"
                            :hint="employeeList =='LOADING'? 'Employee List is being downloaded.': ''" persistent-hint
                            return-object @change="getInformation">
                        </v-autocomplete>
                        <v-autocomplete v-model="employeeInformation"
                            :items="user.accountBranchType == 'MAIN' ? employeeList[branch != null ? branch.name:'ALL']:employeeList.ALL"
                            item-text="employeeNumber" label="Employee Number"
                            :rules="$rules.required('Employee Number')" :loading="employeeList =='LOADING'? true: false"
                            :hint="employeeList =='LOADING'? 'Employee List is being downloaded.': ''" persistent-hint
                            return-object @change="getInformation">
                        </v-autocomplete>
                        <v-text-field v-model="itemsValue.password"
                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            :rules="[...$rules.required('Password'), ...$rules.min('Password', 8)]"
                            :type="showPassword ? 'text' : 'password'" name="input-10-1" label="Password"
                            hint="At least 8 characters" counter @click:append="showPassword = !showPassword">
                        </v-text-field>
                        <v-autocomplete v-model="itemsValue.role" :items="roleList" item-text="roleList" label="Role"
                            :rules="$rules.required('Role')" return-object>
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
                <v-btn v-if="dialogTitle == 'Create'" color="warning" depressed @click="clearFields()">
                    Clear
                </v-btn>
                <v-btn :color="dialogHeaderColor" depressed @click="validate()" v-if="dialogDeleteClass == 'hidden'"
                    :loading="employeeList == 'LOADING' ? true:false">
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import subMixin from "../../../../mixins/subMixin";
    export default {
        mixins: [
            subMixin
        ],
        data() {
            return {
                employeeName: null,
                employeeNumber: null,
                employeeInformation: null,
                branch: null,
                showPassword: false,
                checkValues: [
                    'branch',
                    'noBranch',
                ]
            }
        },

        methods: {
            getInformation() {
                this.employeeName = this.employeeInformation.fullName
                this.itemsValue.employeeNumber = this.employeeInformation.employeeNumber
            },
            clearFields() {
                this.clearError = true
                this.changeBranch('setAll')

                if (this.$refs.form != undefined) {
                    this.$refs.form.reset()
                }
            },
            branchChange() {
                this.employeeInformation = null
            }
        },
        watch: {
            items(newValue) {
                if (newValue != null && this.dialogTitle != 'Create') {
                    this.employeeName = newValue.fullName
                    this.employeeNumber = newValue.employeeNumber
                }
            },
        }
    }

</script>
