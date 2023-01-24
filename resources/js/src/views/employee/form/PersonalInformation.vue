<template>
    <div class="pa-5">
        <v-form ref="form" lazy-validation enctype="multipart/form-data">
            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold">FULL NAME</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Last Name"
                        v-model="employeeData.lastName"
                        outlined
                        dense
                        :rules="$rules.required('Last name')"
                    >
                    </v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                        <v-text-field
                        label="First Name"
                        v-model="employeeData.firstName"
                        outlined
                        :rules="$rules.required('First name')"
                        dense
                    >
                    </v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                        <v-text-field
                        label="Middle Name"
                        v-model="employeeData.middleName"
                        outlined
                        dense
                    >
                    </v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold">BASIC INFORMATION</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4">
                    <v-menu
                        ref="menu"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                label="Birthdate"
                                prepend-inner-icon="mdi-calendar"
                                v-model="employeeData.birthDate"
                                :rules="$rules.required('Birth date')"
                                readonly
                                outlined
                                dense
                                v-bind="attrs"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            ref="picker"
                            v-model="employeeData.birthDate"
                            :max="new Date().toISOString().substr(0, 10)"
                            min="1950-01-01"
                        ></v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Birthplace"
                        outlined
                        v-model="employeeData.birthPlace"
                        :rules="$rules.required('Birth place')"
                        dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-autocomplete
                        :items="genders"
                        label="Gender"
                        v-model="employeeData.gender"
                        :rules="$rules.required('Gender')"
                        outlined
                        dense
                    ></v-autocomplete>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4">
                    <v-autocomplete
                        :items="civilStatus"
                        label="Civil Status"
                        v-model="employeeData.civilStatus"
                        :rules="$rules.required('Civil status')"
                        outlined
                        dense
                    ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Nationality"
                        v-model="employeeData.nationality"
                        :rules="$rules.required('Nationality')"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Religion"
                        outlined
                        dense
                        v-model="employeeData.religion"
                        :rules="$rules.required('Religion')"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold">CONTACT INFORMATION</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="6">
                    <v-text-field
                        label="Email Address"
                        v-model="employeeData.emailAddress"
                        outlined
                        dense
                        :rules="$route.name == 'Edit Applicant' ? [] : [...$rules.required('Email'), ...$rules.email()]"
                        ref="emailAddress"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field
                        label="Mobile No."
                        v-model="employeeData.mobileNumber"
                        :rules="[...$rules.required('Mobile no.'),...$rules.length('Mobile no.', 10)]"
                        outlined
                        dense
                        prefix="+63"
                        counter="10"
                        type="number"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="mx-2 mt-5 justify-center">
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
import { mapState } from 'vuex';
    export default {
        props: ['employeeData'],
        data() {
            return {
                
            }
        },
        computed: {
            ...mapState('formItems', {
                civilStatus: state => state.civilStatus,
                genders: state => state.genders,
            }),
        },
        methods: {
            validate: function () {
                if (this.$refs.form.validate()) {
                    this.$emit('continue', this.employeeData)
                }
            },
        }
    };
</script>
