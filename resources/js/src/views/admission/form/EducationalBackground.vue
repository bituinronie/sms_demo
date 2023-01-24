<template>
    <div class="pa-5">
        <v-form ref="form" lazy-validation enctype="multipart/form-data">
            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold">ELEMENTARY</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4" class="pt-3">
                    <v-text-field label="Name" 
                    outlined 
                    dense
                    v-model="applicantData.elementaryName"
                    :rules="requiredInputs.elementaryRequired ? $rules.required('Elementary school name') : []"
                    :readonly="readOnlyInputs.elementaryReadOnly ? true : false"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field label="Address" 
                    outlined 
                    dense
                    v-model="applicantData.elementaryAddress"
                    :rules="requiredInputs.elementaryRequired ? $rules.required('Elementary school address') : []"
                    :readonly="readOnlyInputs.elementaryReadOnly ? true : false"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4" sm="6">
                    <v-text-field
                        label="School Year Completed"
                        v-model="applicantData.elementaryYearCompleted"
                        outlined
                        dense
                        :suffix="` to ${addYear(applicantData.elementaryYearCompleted)}`"
                        counter="4"
                        :rules="requiredInputs.elementaryRequired ? [...$rules.length('Year', 4), ...$rules.required('Elementary year completed')] : []"
                        :readonly="readOnlyInputs.elementaryReadOnly ? true : false"
                        
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold">JUNIOR HIGH SCHOOL</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4" class="pt-3">
                    <v-text-field label="Name" 
                    outlined 
                    dense
                    v-model="applicantData.juniorHighSchoolName"
                    :rules="requiredInputs.jhsRequired ? $rules.required('JHS school name') : []"
                    :readonly="readOnlyInputs.jhsReadOnly ? true : false"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field label="Address" 
                    outlined 
                    dense
                    v-model="applicantData.juniorHighSchoolAddress"
                    :rules="requiredInputs.jhsRequired ? $rules.required('JHS school address') : []"
                    :readonly="readOnlyInputs.jhsReadOnly ? true : false"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4" sm="6">
                    <v-text-field
                        label="School Year Completed"
                        v-model="applicantData.juniorHighSchoolYearCompleted"
                        outlined
                        dense
                        :suffix="` to ${addYear(applicantData.juniorHighSchoolYearCompleted)}`"
                        :rules="requiredInputs.jhsRequired ? [...$rules.length('Year', 4), ...$rules.required('JHS year completed')] : []"
                        :readonly="readOnlyInputs.jhsReadOnly ? true : false"
                        counter="4"
                        
                    ></v-text-field>
                </v-col>
            </v-row>
           <v-row>
                <v-col cols="12" md="5" class="d-flex align-end pb-0">
                    <span class="font-weight-bold">SENIOR HIGH SCHOOL</span>
                </v-col>
                <v-col cols="12" md="7"  class="d-flex justify-end pb-0">
                    <v-switch
                        v-model="switchSHS"
                        :label="toggleSwitchLabel"
                        color="accent"
                        hide-details="true"
                        inset
                        dense
                        :value="readOnlyInputs.shsReadOnly ? false : true"
                        :disabled="readOnlyInputs.shsReadOnly ? true : false"
                    ></v-switch>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="12">
                    <v-divider></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4" class="pt-3">
                    <v-text-field label="Name" 
                    outlined 
                    dense
                    v-model="applicantData.seniorHighSchoolName"
                    :rules="requiredInputs.shsRequired && switchSHS ? $rules.required('SHS school name') : []"
                    :readonly="readOnlyInputs.shsReadOnly ? true : false"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field label="Address" 
                    outlined 
                    dense
                    v-model="applicantData.seniorHighSchoolAddress"
                    :rules="requiredInputs.shsRequired && switchSHS ? $rules.required('SHS school address') : []"
                    :readonly="readOnlyInputs.shsReadOnly ? true : false"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4" sm="6">
                    <v-text-field
                        label="School Year Completed"
                        v-model="applicantData.seniorHighSchoolYearCompleted"
                        outlined
                        dense
                        :rules="requiredInputs.shsRequired && switchSHS ? $rules.required('SHS year completed') : []"
                        :readonly="readOnlyInputs.shsReadOnly ? true : false"
                        :suffix="` to ${addYear(applicantData.seniorHighSchoolYearCompleted)}`"
                        counter="4"
                        
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold">COLLEGE</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4" class="pt-3">
                    <v-text-field label="Name" 
                    outlined 
                    dense
                    v-model="applicantData.collegeName"
                    :rules="requiredInputs.collegeRequired ? $rules.required('College school name') : []"
                    :readonly="readOnlyInputs.collegeReadOnly ? true : false"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field label="Address" 
                    outlined 
                    dense
                    v-model="applicantData.collegeAddress"
                    :rules="requiredInputs.collegeRequired ? $rules.required('College school address') : []"
                    :readonly="readOnlyInputs.collegeReadOnly ? true : false"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4" sm="6">
                    <v-text-field
                        label="School Year Completed"
                        v-model="applicantData.collegeYearCompleted"
                        outlined
                        dense
                        :suffix="` to ${addYear(applicantData.collegeYearCompleted)}`"
                        :rules="requiredInputs.collegeRequired ? [...$rules.length('Year', 4), ...$rules.required(' school')] : []"
                    :readonly="readOnlyInputs.collegeReadOnly ? true : false"
                        counter="4"
                        
                    ></v-text-field>
                </v-col>
            </v-row>
             <v-row class="justify-end mr-2 mt-10">
                 <v-btn color="primary" @click="$emit('previous')" class="mt-5" style="width: 150px">
                    <v-icon left>mdi-chevron-left</v-icon>
                     Previous
                </v-btn>
                <v-spacer class="hidden-xs"></v-spacer>
                <v-btn color="primary" @click="validate()" class="mt-5" style="width: 150px">
                    Next
                    <v-icon right>mdi-chevron-right</v-icon>
                </v-btn>
            </v-row>
        </v-form>
    </div>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex'

export default {
    props: [ 'requiredInputs', 'readOnlyInputs', 'applicantData' ],
    data: () => ({
        switchSHS: true,
        elementaryRequired: false,
        jhsRequired: false,
        shsRequired: false,
        collegeRequired: false,
        previousSchool: false,
    }),
    computed: {     
        toggleSwitchLabel: function () {
            if (this.switchSHS) {
                if (!this.readOnlyInputs.shsReadOnly) {
                    return "I took Senior High School"
                } else { 
                    return "I did not take Senior High School"
                }
            } else {
                return "I did not take Senior High School";
            }
        },
    },
    methods: {
        addYear: function (year) {
            year = parseInt(year)
            if (year > 0) {
                return year + 1;
            }
            return 0;
        },
        validate: function () {
            if (this.$refs.form.validate()) {
                this.$emit('continue', this.applicantData)    
            }
        },
    },
    mounted: function () {
        if (this.$route.name == 'Edit Applicant') {
            if (this.applicantData.elementaryYearCompleted) {
                this.applicantData.elementaryYearCompleted = (this.applicantData.elementaryYearCompleted).toString().substring(0,4)
            }
            if (this.applicantData.juniorHighSchoolYearCompleted) {
                this.applicantData.juniorHighSchoolYearCompleted = (this.applicantData.juniorHighSchoolYearCompleted).toString().substring(0,4)
            }
            if (this.applicantData.seniorHighSchoolYearCompleted) {
                this.applicantData.seniorHighSchoolYearCompleted = (this.applicantData.seniorHighSchoolYearCompleted).toString().substring(0,4)
            }
            if (this.applicantData.collegeYearCompleted) {
                this.applicantData.collegeYearCompleted = (this.applicantData.collegeYearCompleted).toString().substring(0,4)
            }
        }
    }
};
</script>

