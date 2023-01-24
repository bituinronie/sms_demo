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
                        <center v-if="getterPartLoading == true && dialogTitle != 'Create'">
                            <v-progress-circular :size="70" :width="3" color="primary" indeterminate>
                            </v-progress-circular>
                        </center>
                        <div v-else-if="getterPartLoading == false && dialogTitle == 'Show'">
                            <span v-for="(value, key) in perRowValue" :key="key">
                                <span class="font-weight-bold">{{ key.toUpperCase() + ': ' }}</span>
                                <span class="font-weight-normal">{{ value }}</span>
                                <br>
                            </span>
                            <br>
                            <hr class="my-2">
                            <center>
                                <span class="font-weight-bold">SCHEDULE/S</span>
                            </center>
                            <hr class="my-2">
                            <br>
                            <v-row>
                                <v-col cols="12" md="6" v-for="(value, index) in itemShow.subjectSchedule" :key="index">
                                    <span class="font-weight-bold">
                                        {{'SCHEDULE ' + (index+1)}}
                                    </span>
                                    <br>
                                    <span v-for="(value, key) in itemShow.subjectSchedule[index]" :key="key">
                                        <span class="font-weight-bold">{{ key.toUpperCase() + ': ' }}</span>
                                        <span class="font-weight-normal">{{ value }}</span>
                                        <br>
                                    </span>
                                </v-col>
                            </v-row>
                        </div>
                        <div v-else>
                            <v-autocomplete v-model="branch" :items="branchList.ALL" item-text="name"
                                label="Branch" :rules="$rules.required('Branch')" :class="branchVisibility"
                                @change="changeBranch()" return-object>
                            </v-autocomplete>
                            <v-autocomplete v-model="section"
                                :items="user.accountBranchType == 'MAIN' ? sectionList[branch != null ? branch.name:'ALL']:sectionList.ALL"
                                item-text="code" label="Section" :rules="$rules.required('Section')"
                                :loading="sectionList == 'LOADING' ? true: false"
                                :hint="sectionList=='LOADING'?'Section List is being downloaded.':''" persistent-hint
                                return-object>
                            </v-autocomplete>
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
                    {{dialogTitle == 'Show'? 'Close' :'Cancel'}}
                </v-btn>
                <v-btn :color="dialogHeaderColor" depressed @click="dialogTitle != 'Create'?validate():schedule()"
                    v-if="dialogDeleteClass == 'hidden' && dialogTitle != 'Show'" :loading="submitButtonLoading">
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
                perRowValue: {},
                branch: null,
                section: null,
                checkValues: [
                    'branch',
                    'section'
                ]
            }
        },
        methods: {
            schedule() {
                if (this.$refs.form.validate()) {
                    var name = this.$router.currentRoute.name == 'Schedule (College)' ? 'Create Schedule (College)' :
                        'Create Schedule (Basic Education)'
                    this.$router.push({
                        name: name,
                        params: {
                            id: this.section.code.toLowerCase(),
                            branch: this.branch.code,
                            section: this.section.code
                        }
                    })
                }
            }
        },
        watch: {
            itemShow(newValue) {
                if (newValue != null) {
                    this.perRowValue = {
                        branch: newValue.branch.name,
                        code: newValue.code,
                        section: newValue.section.code,
                        subject: newValue.subject.name,
                        proffesor: newValue.employee != null ? newValue.employee.lastName + ', ' + newValue.employee
                            .firstName + ' ' + newValue.employee.middleName : '',
                    }
                }
            }
        }
    }

</script>
