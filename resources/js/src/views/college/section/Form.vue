<template>
    <v-dialog :value="dialog" width="700" persistent>
        <v-card>
            <v-card-title class="headline white--text" :class="dialogHeaderColor">
                {{dialogTitle}} {{this.$route.name}}
            </v-card-title>

            <v-card-text class="mt-4">
                <span class="my-5" :class="dialogBodyColor" v-if="dialogBody != '' && dialogDeleteClass =='hidden'">
                    {{dialogBody + itemsValue.code + '?'}}
                </span>

                <div :class="dialogDeleteClass">
                    <span class="error--text my-5" v-if="dialogBody != ''">
                        {{itemsValue.code + ' will be permanently deleted in:'}}
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
                        <v-autocomplete v-if="$router.currentRoute.name == 'Section (College)'" v-model="department"
                            :items="user.accountBranchType == 'MAIN' ? departmentList[branch != null ? branch.name:'ALL']:departmentList.ALL"
                            item-text="name" label="Department" :rules="$rules.required('Department')"
                            :loading="departmentList == 'LOADING' ? true: false"
                            :hint="departmentList=='LOADING'?'Department List is being downloaded.':''" persistent-hint
                            return-object>
                        </v-autocomplete>
                        <v-autocomplete v-model="itemsValue.yearLevel" :items="yearValues" :item-text="yearValues"
                            label="Year Level" :rules="$rules.required('Year Level')" return-object>
                        </v-autocomplete>
                        <v-autocomplete v-if="itemsValue.type == 'COLLEGE'" v-model="itemsValue.semester"
                            :items="semesterList" item-text="semesterList" label="Semester"
                            :rules="itemsValue.type == 'COLLEGE'?$rules.required('Semester'):[]" return-object>
                        </v-autocomplete>
                        <v-text-field type="number" v-model="itemsValue.classSize" label="Class Size"
                            :rules="[...$rules.required('Class Size'), ...$rules.wholeNumber('Class Size')]">
                        </v-text-field>
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
                <v-btn class="mr-2" :color="dialogHeaderColor == 'error'?'warning':'error'" depressed @click="cancel()">
                    Cancel
                </v-btn>
                <!-- <v-btn :color="dialogHeaderColor" depressed @click="validate()" v-if="dialogDeleteClass == 'hidden'"
                    :loading="departmentList =='LOADING'?true:false">
                    Submit
                </v-btn> -->
                <v-menu offset-y v-if="dialogDeleteClass == 'hidden'">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn :color="dialogHeaderColor" depressed v-bind="attrs" v-on="on"
                            :loading="departmentList =='LOADING'?true:false"
                            @click="dialogTitle != 'Create' && dialogTitle != 'Update' ? validate():''">
                            Submit
                        </v-btn>
                    </template>
                    <v-list class="pointer" v-if="dialogTitle == 'Create' || dialogTitle == 'Update'">
                        <v-list-item @click="validate()">
                            <v-list-item-title>Submit</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="validate('assign')">
                            <v-list-item-title>Submit & {{dialogTitle == 'Create' ? 'Assign Schedule' : 'Update Schedule'}}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
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
                semester: null,
                yearValues: this.allGradeYearLevelList,
                checkValues: [
                    'branch',
                    'department'
                ],
            }
        },
        mounted() {
            this.yearValues = []
            if (this.$router.currentRoute.name == 'Section (College)') {
                this.itemsValue.type = 'COLLEGE'
                this.yearValues = this.schoolLevelGradeYearList['COLLEGE']
            } else {
                this.itemsValue.type = 'BASIC EDUCATION'
                for (var i = 0; i < 14; i++) {
                    this.yearValues[i] = this.allGradeYearLevelList[i]
                }
            }
        },
    }

</script>
