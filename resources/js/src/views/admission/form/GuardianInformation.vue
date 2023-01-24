<template>
    <div class="pa-5">
        <v-form ref="form" lazy-validation enctype="multipart/form-data">
            
            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold">FATHER</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="3" class="pt-3">
                    <v-text-field
                        label="Full Name"
                        outlined
                        dense
                        v-model="applicantData.fatherFullName"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field label="Address" 
                    outlined 
                    dense
                    v-model="applicantData.fatherAddress"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        label="Occupation"
                        outlined
                        dense
                        v-model="applicantData.fatherOccupation"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field label="Email" 
                    :rules="$rules.email()"
                    outlined 
                    v-model="applicantData.fatherEmail"
                    dense></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        label="Contact No."
                        :rules="$rules.length('Father\'s contact number', 10)"
                        outlined
                        dense
                        counter="10"
                        type="number"
                        v-model="applicantData.fatherContactNumber"
                        prefix="+63"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold">MOTHER</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="3" class="pt-3">
                    <v-text-field
                        label="Full Name"
                        outlined
                        dense
                        v-model="applicantData.motherFullName"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field label="Address" 
                    outlined 
                    dense
                    v-model="applicantData.motherAddress"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        label="Occupation"
                        outlined
                        dense
                        v-model="applicantData.motherOccupation"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field label="Email"
                    :rules="$rules.email()"
                    outlined 
                    dense
                    v-model="applicantData.motherEmail"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        label="Contact No."
                        :rules="$rules.length('Mother\'s contact number', 10)"
                        counter="10"
                        outlined
                        dense
                        type="number"
                        v-model="applicantData.motherContactNumber"
                        prefix="+63"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold">GUARDIAN</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4" class="pt-3">
                    <v-text-field
                        label="Full Name"
                        outlined
                        :rules="$rules.required('Guardian\'s full name')"
                        dense
                        v-model="applicantData.guardianFullName"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field label="Address" 
                    :rules="$rules.required('Guardian\'s address')"
                    v-model="applicantData.guardianAddress"
                    outlined 
                    dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Occupation"
                        outlined
                        :rules="$rules.required('Guardian\'s occupation')"
                        dense
                        v-model="applicantData.guardianOccupation"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field label="Email" 
                    :rules="[...$rules.required('Guardian\'s email'), ...$rules.email()]"
                    outlined 
                    dense
                    v-model="applicantData.guardianEmail"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Contact No."
                        :rules="[...$rules.required('Guardian\'s contact no.'), ...$rules.length('Guardian\'s contact no.', 10)]"
                        outlined
                        dense
                        counter="10"
                        prefix="+63"
                        type="number"
                        v-model="applicantData.guardianContactNumber"
                    ></v-text-field>
                </v-col>
                 <v-col cols="12" md="4">
                    <v-text-field
                        label="Relationship with Guardian"
                        :rules="$rules.required('Relationship with guardian' )"
                        outlined
                        dense
                        v-model="applicantData.guardianRelationship"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold"
                        >PARENT'S/GUARDIAN'S AVERAGE INCOME</span
                    >
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="12">
                    <v-radio-group v-model="applicantData.parentsOrGuardianAverageIncome" :rules="$rules.required('Average income')" class="mt-0" row>
                        <v-radio
                            v-for="income in averageIncome"
                            :key="income"
                            :label="`${income}`"
                            :value="income"
                            class="pb-3"
                        ></v-radio>
                        <v-text-field
                            v-if="applicantData.parentsOrGuardianAverageIncome === 'OTHER'"
                            label="Specify Income"
                            :rules="$rules.required('Specific average income')"
                            outlined
                            v-model="applicantData.otherAverageIncome"
                            dense
                            class="mt-2"
                        ></v-text-field>
                    </v-radio-group>
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
import { mapActions, mapState, mapGetters } from 'vuex'

export default {
    props: ['applicantData'],
    computed: {
        ...mapState('formItems', {
            averageIncome: state => state.averageIncome,
        }),
    },
    methods: {
        validate: function () {
            if (this.$refs.form.validate()) {
                this.$emit('continue', this.applicantData)    
            }
        }
    }
};
</script>
