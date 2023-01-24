<template>
    <v-container>
        <!-- <div
            style="background-color: #3f51b5"
            class="white--text align-end"
            height="80px"
        >
            <v-card-title>Applicant Registration</v-card-title>
        </div> -->
        <template>
            <v-app-bar v-if="!$auth.isEmployee() && !$auth.isStudent()" color="white" light dense flat app @click="$router.push({ name: 'Landing Page' })">
                <v-icon>mdi-chevron-left</v-icon>
                <v-toolbar-title style="font-size: 15px"> Go back to Landing Page</v-toolbar-title>
            </v-app-bar>
            <div v-if="!registrationLoading" class="py-5">
                <v-stepper v-model="step" alt-labels class="elevation-0 pt-5">
                    <v-stepper-header class="elevation-0">
                        <v-stepper-step :complete="step > 1" step="1">
                            Enrollment Information
                        </v-stepper-step>

                        <v-divider></v-divider>

                        <v-stepper-step :complete="step > 2" step="2">
                            Personal Information
                        </v-stepper-step>

                        <v-divider></v-divider>

                        <v-stepper-step :complete="step > 3" step="3">
                            Guardian Information
                        </v-stepper-step>

                        <v-divider class="hidden-sm-and-down"></v-divider>

                        <v-stepper-step :complete="step > 4" step="4">
                            Educational Background
                        </v-stepper-step>

                        <v-divider></v-divider>

                        <v-stepper-step :complete="step > 5" step="5">
                            Upload Requirements
                        </v-stepper-step>

                        <v-divider></v-divider>

                        <v-stepper-step step="6">
                            Upload Your Image
                        </v-stepper-step>
                    </v-stepper-header>

                    <v-stepper-items class="pb-5">
                        <v-stepper-content step="1">
                            <EnrollmentInformation 
                                @continue="saveForm" 
                                @saveEducationLevel="saveEducationLevel" 
                                :applicantData="applicantData"
                            />
                        </v-stepper-content>

                        <v-stepper-content step="2">
                            <PersonalInformation 
                                @continue="saveForm"  
                                @previous="step--" 
                                :applicantData="applicantData"
                                v-if="applicantData"
                            />
                        </v-stepper-content>

                        <v-stepper-content step="3">
                            <GuardianInformation 
                                @continue="saveForm" 
                                @previous="step--"  
                                :applicantData="applicantData"
                            />
                        </v-stepper-content>

                        <v-stepper-content step="4">
                            <EducationalBackground
                                @continue="saveForm" 
                                @previous="step--"
                                :requiredInputs="requiredInputs"
                                :readOnlyInputs="readOnlyInputs"
                                :applicantData="applicantData"
                            />
                        </v-stepper-content>

                        <v-stepper-content step="5">
                            <Requirements 
                                @continue="saveForm"  
                                @previous="step--" 
                                :applicantData="applicantData"
                            />
                        </v-stepper-content>

                        <v-stepper-content step="6">
                            <ApplicantImage
                                @submitForm="submitForm"
                                @previous="step--"
                                :applicantData="applicantData"
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
import { mapGetters, mapActions } from 'vuex'

import EnrollmentInformation from "./EnrollmentInformation";
import PersonalInformation from "./PersonalInformation";
import GuardianInformation from "./GuardianInformation";
import EducationalBackground from "./EducationalBackground";
import Requirements from "./Requirements";
import ApplicantImage from "./ApplicantImage";

import Loading from "../../../components/Loading";

export default {
    components: {
        EnrollmentInformation,
        PersonalInformation,
        GuardianInformation,
        EducationalBackground,
        Requirements,
        ApplicantImage,
        Loading
    },
    data: () => ({
        step: 1,
        requiredInputs: {
            elementaryRequired: false,
            jhsRequired: false,
            shsRequired: false,
            collegeRequired: false
        },
        readOnlyInputs: {
            elementaryReadOnly: false,
            jhsReadOnly: false,
            shsReadOnly: false,
            collegeReadOnly: false,
        },
    }),
    computed: {
        ...mapGetters('applicant', {
            applicantData: 'getApplicant',
            registrationLoading: 'getRegistrationLoading'
        }),
    },
    methods: {
        ...mapActions('applicant', [
            'saveApplicant',
            'submitApplicant',
            'updateApplicant',
            'getApplicant',
            'resetApplicant'
        ]),
        addYear: function (year) {
            year = parseInt(year)
            if (year > 0) {
                return year + 1;
            }
            return 0;
        },
        saveEducationLevel: function (str) {
            this.educationLevel = str
            this.setRequiredAndReadOnly()
        },
        setRequiredAndReadOnly: function () {
            if (this.applicantData.educationLevel == 'OTHERS' || this.applicantData.educationLevel == 'GRADUATE SCHOOL') {

                this.requiredInputs.elementaryRequired = true
                this.requiredInputs.jhsRequired = true
                this.requiredInputs.shsRequired = true
                this.requiredInputs.collegeRequired = true

                this.readOnlyInputs.jhsReadOnly = false
                this.readOnlyInputs.shsReadOnly = false
                this.readOnlyInputs.collegeReadOnly = false
                this.readOnlyInputs.elementaryReadOnly = false

            } else if (this.applicantData.educationLevel == 'COLLEGE') {

                this.requiredInputs.elementaryRequired = true
                this.requiredInputs.jhsRequired = true
                this.requiredInputs.shsRequired = true
                this.requiredInputs.collegeRequired = false

                this.readOnlyInputs.jhsReadOnly = false
                this.readOnlyInputs.shsReadOnly = false
                this.readOnlyInputs.collegeReadOnly = false
                this.readOnlyInputs.elementaryReadOnly = false

            } else if (this.applicantData.educationLevel == 'SENIOR HIGH SCHOOL') {

                this.requiredInputs.elementaryRequired = true
                this.requiredInputs.jhsRequired = true
                this.requiredInputs.shsRequired = false
                this.requiredInputs.collegeRequired = false
                
                this.readOnlyInputs.elementaryReadOnly = false
                this.readOnlyInputs.jhsReadOnly = false
                this.readOnlyInputs.shsReadOnly = false
                this.readOnlyInputs.collegeReadOnly = true

            } else if (this.applicantData.educationLevel == 'JUNIOR HIGH SCHOOL') {

                this.requiredInputs.elementaryRequired = true
                this.requiredInputs.jhsRequired = false
                this.requiredInputs.shsRequired = false
                this.requiredInputs.collegeRequired = false

                this.readOnlyInputs.elementaryReadOnly = false
                this.readOnlyInputs.jhsReadOnly = false
                this.readOnlyInputs.shsReadOnly = true
                this.readOnlyInputs.collegeReadOnly = true

            } else if (this.applicantData.educationLevel == 'ELEMENTARY') {
                
                this.requiredInputs.elementaryRequired = false
                this.requiredInputs.jhsRequired = false
                this.requiredInputs.shsRequired = false
                this.requiredInputs.collegeRequired = false

                this.readOnlyInputs.elementaryReadOnly = false
                this.readOnlyInputs.jhsReadOnly = true
                this.readOnlyInputs.shsReadOnly = true
                this.readOnlyInputs.collegeReadOnly = true

            } else if (this.applicantData.educationLevel == 'PRE-SCHOOL') {

                this.requiredInputs.elementaryRequired = false
                this.requiredInputs.jhsRequired = false
                this.requiredInputs.shsRequired = false
                this.requiredInputs.collegeRequired = false

                this.readOnlyInputs.elementaryReadOnly = true
                this.readOnlyInputs.jhsReadOnly = true
                this.readOnlyInputs.shsReadOnly = true
                this.readOnlyInputs.collegeReadOnly = true
            }
        },
        saveForm: function (data) {
            this.saveApplicant(data)
            this.step++
        },
        submitForm: function (data) {
            
            data.schoolYear = data.schoolYear + '-' + this.addYear(data.schoolYear)

            if (data.elementaryYearCompleted) {
                data.elementaryYearCompleted = 
                data.elementaryYearCompleted + '-' + this.addYear(data.elementaryYearCompleted)
            }
            if (data.juniorHighSchoolYearCompleted) {
                data.juniorHighSchoolYearCompleted = 
                data.juniorHighSchoolYearCompleted + '-' + this.addYear(data.juniorHighSchoolYearCompleted)
            }
            if (data.seniorHighSchoolYearCompleted) {
                data.seniorHighSchoolYearCompleted = 
                data.seniorHighSchoolYearCompleted + '-' + this.addYear(data.seniorHighSchoolYearCompleted)
            }
            if (data.collegeYearCompleted) {
                data.collegeYearCompleted = 
                data.collegeYearCompleted + '-' + this.addYear(data.collegeYearCompleted)
            }

            this.saveApplicant(data)

            if (this.$route.name == 'Edit Applicant') {
                this.updateApplicant(data)
            } else {
                this.submitApplicant(data)
            }
        }
    },
    watch: {
        $route (to, from) {
            this.step = 1
            if (to.name == 'Create Applicant') {
                this.resetApplicant() 
            }
        }
    },
    mounted: function () {
        if (this.$route.name == 'Edit Applicant') {
            this.getApplicant(this.$route.params.id)
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
