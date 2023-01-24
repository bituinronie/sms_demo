<template>
    <v-container>
        <template>
            <div v-if="!employeeLoading" class="py-5">
                <v-stepper v-model="step" alt-labels class="elevation-0 pt-5">
                    <v-stepper-header class="elevation-0">
                        <v-stepper-step :complete="step > 1" step="1">
                            Personal Information
                        </v-stepper-step>

                        <v-divider></v-divider>

                        <v-stepper-step :complete="step > 2" step="2">
                            Complete Address
                        </v-stepper-step>

                        <v-divider></v-divider>

                        <v-stepper-step :complete="step > 3" step="3">
                            Employment Information
                        </v-stepper-step>

                    </v-stepper-header>

                    <v-stepper-items class="pb-5">
                        <v-stepper-content step="1">
                            <PersonalInformation 
                                @continue="saveForm"  
                                :employeeData="employeeData"
                            />
                        </v-stepper-content>

                        <v-stepper-content step="2">
                            <CompleteAddress 
                                @continue="saveForm"  
                                @previous="step--" 
                                :employeeData="employeeData"
                                v-if="employeeData"
                            />
                        </v-stepper-content>


                        <v-stepper-content step="3">
                            <EmploymentInformation
                                @submitForm="submitForm"
                                @previous="step--"
                                :employeeData="employeeData"
                            />
                        </v-stepper-content>
                    </v-stepper-items>

                    <!-- <v-row class="justify-end mb-5 mx-10">
                        <v-btn text v-if="step > 1" @click="step--">
                            Previous
                        </v-btn>
                        <v-btn color="primary" @click="step++" v-if="step <= 5">
                            Continue
                        </v-btn>
                        <v-btn color="primary" v-else>
                            Submit
                        </v-btn>
                    </v-row> -->
                </v-stepper>
            </div>
            <div v-else>
                <Loading />
            </div>
        </template>
    </v-container>
</template>

<script>
import { mapState, mapActions } from 'vuex'

import PersonalInformation from "./PersonalInformation";
import CompleteAddress from "./CompleteAddress";
import EmploymentInformation from "./EmploymentInformation";

import Loading from "../../../components/Loading";

export default {
    components: {
        PersonalInformation,
        CompleteAddress,
        EmploymentInformation,
        Loading,
    },
    data: () => ({
        step: 1,
    }),
    computed: {
        ...mapState('employee', {
            employeeData: state => state.employeeData,
            employeeLoading: state => state.employeeLoading
        }),
    },
    methods: {
        ...mapActions('employee', [
            'saveEmployee',
            'submitEmployee',
            'updateEmployee',
            'getEmployee',
            'resetEmployee'
        ]),
        ...mapActions('formItems', [
            'getData'
        ]),
        saveForm: function (data) {
            this.saveEmployee(data)
            this.step++
        },
        submitForm: function (data) {

            this.saveEmployee(data)

            if (this.$route.name == 'Edit Employee') {
                this.updateEmployee(data)
            } else {
                this.submitEmployee(data)
            }
        }
    },
    watch: {
        $route (to, from) {
            this.step = 1
            if (to.name == 'Create Employee') {
                this.resetEmployee() 
            }
        }
    },
    mounted: function () {
        this.getData()
        if (this.$route.name == 'Edit Employee') {
            this.getEmployee(this.$route.params.id)          
        }
    },
};
</script>

<style>
.v-application--is-ltr .v-stepper__label {
    text-align: center !important;
    margin-top: 5px;
    font-size: 14px;
}
</style>
