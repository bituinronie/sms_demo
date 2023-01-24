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
                        <v-text-field v-model="itemsValue.code" label="Code" :rules="$rules.required('Code')"
                            @input="changeToUpperCase('code')">
                        </v-text-field>
                        <v-text-field v-model="itemsValue.name" @input="changeToUpperCase('name')" label="Name"
                            :rules="$rules.required('Name')">
                        </v-text-field>
                        <v-autocomplete v-model="itemsValue.type" :items="subjectTypeList" item-text="subjectTypeList"
                            label="Type" :rules="$rules.required('Type')" return-object @change="itemsValue.type == 'NSTP' ? department = 'NSTP DEPARTMENT':''">
                        </v-autocomplete>
                        <v-autocomplete v-model="department"
                            :items="user.accountBranchType == 'MAIN' ? departmentList[branch != null ? branch.name:'ALL']:departmentList.ALL"
                            item-text="name" label="Department" :rules="$rules.required('Department')"
                            :loading="departmentList == 'LOADING' ? true: false"
                            :hint="departmentList=='LOADING'?'Department List is being downloaded.':''" persistent-hint
                            return-object>
                        </v-autocomplete>

                        <div>
                            <span>Lecture:</span>
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="itemsValue.lectureUnit" type="number" label="Unit/s"
                                        :rules="$rules.required('Lecture Unit/s')">
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="itemsValue.lectureHour" type="number" label="Hour/s"
                                        :rules="$rules.required('Lecture Hour/s')">
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-autocomplete v-model="laboratory"
                                :items="user.accountBranchType == 'MAIN' ? laboratoryList[branch != null ? branch.name:'ALL']:laboratoryList.ALL"
                                item-text="name" label="Laboratory" :loading="laboratoryList == 'LOADING' ? true: false"
                                :hint="laboratoryList=='LOADING'?'Laboratory List is being downloaded.':''"
                                persistent-hint return-object clearable>
                            </v-autocomplete>
                            <v-row class="mt-0 pt-0" v-if="laboratory != null">
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="itemsValue.laboratoryUnit"
                                        :rules="laboratory != null ? [...$rules.required('Laboratory Unit'), ...$rules.greaterThan('Laboratory Unit', 0)]:[]"
                                        type="number" label="Unit/s">
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="itemsValue.laboratoryHour"
                                        :rules="laboratory != null ? [...$rules.required('Laboratory Hour'), ...$rules.greaterThan('Laboratory Hour', 0)]:[]"
                                        type="number" label="Hour/s">
                                    </v-text-field>
                                </v-col>
                            </v-row>
                        </div>

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
                laboratory: null,
                department: null,
                branch: null,
                checkValues: [
                    'branch',
                    'department',
                    'laboratory'
                ]
            }
        },
        watch: {
            laboratory(newValue) {
                if (newValue == null) {
                    this.itemsValue.laboratoryUnit = 0
                    this.itemsValue.laboratoryHour = 0
                }
            },
        },
    }

</script>
