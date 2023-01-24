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
                        v-model="applicantData.lastName"
                        :rules="$rules.required('Last name')"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="First Name"
                        v-model="applicantData.firstName"
                        :rules="$rules.required('First name')"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Middle Name"
                        v-model="applicantData.middleName"
                        outlined
                        dense
                    ></v-text-field>
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
                                v-model="applicantData.birthDate"
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
                            v-model="applicantData.birthDate"
                            :max="new Date().toISOString().substr(0, 10)"
                            min="1950-01-01"
                        ></v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Birthplace"
                        outlined
                        v-model="applicantData.birthPlace"
                        :rules="$rules.required('Birth place')"
                        dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-autocomplete
                        :items="genders"
                        label="Gender"
                        v-model="applicantData.gender"
                        :rules="$rules.required('Gender')"
                        outlined
                        dense
                    ></v-autocomplete>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4">
                    <v-autocomplete
                        :items="civilStatuses"
                        label="Civil Status"
                        v-model="applicantData.civilStatus"
                        :rules="$rules.required('Civil status')"
                        outlined
                        dense
                    ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Nationality"
                        v-model="applicantData.nationality"
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
                        v-model="applicantData.religion"
                        :rules="$rules.required('Religion')"
                    ></v-text-field>
                </v-col>
            </v-row>

            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold">PERMANENT ADDRESS</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4">
                    <v-autocomplete
                        :items="provinces"
                        item-text="name"
                        item-value="prov_code"
                        label="Province"
                        v-model="temp.permanentAddressProvince"
                        :rules="$rules.required('Province')"
                        @change="(e) => getCities(e, 'permanent')"
                        outlined
                        dense
                    ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="4">
                    <v-autocomplete
                        :items="cities.permanent"
                        item-text="name"
                        item-value="mun_code"
                        v-model="temp.permanentAddressCity"
                        label="City"
                        :rules="$rules.required('City')"
                        outlined
                        dense
                        @change="(e) => getBarangays(e, 'permanent')"
                    ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="4">
                    <v-autocomplete
                        :items="barangays.permanent"
                        v-model="applicantData.permanentAddressBarangay"
                        :rules="$rules.required('Barangay')"
                        item-text="name"
                        item-value=""
                        label="Barangay"
                        outlined
                        dense
                        class="text-capitalize"
                    ></v-autocomplete>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="House No./Building No."
                        outlined
                        dense
                        v-model="applicantData.permanentAddressHouseNumber"
                        :rules="$rules.required('House No./Building No.')"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Street Name"
                        v-model="applicantData.permanentAddressStreetName"
                        :rules="$rules.required('Street Name')"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>

                <v-col cols="12" md="4">
                    <v-text-field
                        label="Zip Code"
                        v-model="applicantData.permanentAddressZipCode"
                        outlined
                        dense
                        type="number"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="5" class="d-flex align-end pb-0">
                    <span class="font-weight-bold">CURRENT ADDRESS</span>
                </v-col>
                <v-col cols="12" md="7"  class="d-flex justify-end pb-0">
                    <v-switch
                        v-model="switchAddress"
                        :label="toggleSwitchLabel"
                        color="accent"
                        hide-details="true"
                        inset
                        dense
                    ></v-switch>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="12">
                    <v-divider></v-divider>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="4">
                    <v-autocomplete
                        :items="provinces"
                        item-text="name"
                        item-value="prov_code"
                        :readonly="currentAddressReadOnly"
                        label="Province"
                        v-model="temp.currentAddressProvince"
                        :rules="$rules.required('Province')"
                        @change="(e) => getCities(e, 'current')"
                        outlined
                        dense
                    ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="4">
                    <v-autocomplete
                        :items="cities.current"
                        item-text="name"
                        item-value="mun_code"
                        :readonly="currentAddressReadOnly"
                        v-model="temp.currentAddressCity"
                        label="City"
                        :rules="$rules.required('City')"
                        outlined
                        dense
                        @change="(e) => getBarangays(e, 'current')"
                    ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="4">
                    <v-autocomplete
                        :items="barangays.current"
                        v-model="applicantData.currentAddressBarangay"
                        :rules="$rules.required('Barangay')"
                        :readonly="currentAddressReadOnly"
                        item-text="name"
                        item-value=""
                        label="Barangay"
                        outlined
                        dense
                    ></v-autocomplete>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="House No./Building No."
                        outlined
                        dense
                        v-model="applicantData.currentAddressHouseNumber"
                        :rules="$rules.required('House No./Building No.')"
                        :readonly="currentAddressReadOnly"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Street Name"
                        v-model="applicantData.currentAddressStreetName"
                        :rules="$rules.required('Street Name')"
                        :readonly="currentAddressReadOnly"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>

                <v-col cols="12" md="4">
                    <v-text-field
                        label="Zip Code"
                        v-model="applicantData.currentAddressZipCode"
                        :readonly="currentAddressReadOnly"
                        outlined
                        dense
                        type="number"
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
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Email Address"
                        :disabled="$route.name == 'Edit Applicant' ? true : false"
                        v-model="applicantData.emailAddress"
                        outlined
                        dense
                        :loading="emailLoading"
                        :rules="$route.name == 'Edit Applicant' ? [] : [...$rules.required('Email'), ...$rules.email()]"
                        ref="emailAddress"
                        :success="emailSuccess"
                        :success-messages="emailSuccessMessage"
                        :error="emailError"
                        :error-messages="emailErrorMessage"
                        @keyup="validateEmail"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Mobile No."
                        v-model="applicantData.mobileNumber"
                        :rules="[...$rules.required('Mobile no.'),...$rules.length('Mobile no.', 10)]"
                        outlined
                        dense
                        prefix="+63"
                        counter="10"
                        type="number"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Telephone No."
                        v-model="applicantData.telephoneNumber"
                        outlined
                        dense
                        type="number"
                    ></v-text-field>
                </v-col>
            </v-row>
             <v-row class="mx-2 mt-5 justify-center">
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
import phil from "phil-reg-prov-mun-brgy";
import { mapState, mapActions, mapGetters } from 'vuex'

export default {
    props: ['applicantData'],
    data: () => ({
        switchAddress: false,
        currentAddressReadOnly: false,
        emailLoading: false,
        emailSuccess: false,
        emailSuccessMessage: '',
        emailError: false,
        emailErrorMessage: '',
        temp: {},
        cities: {
            current: [],
            permanent: [],
        },
        barangays: {
            current: [],
            permanent: [],
        }
    }),
    computed: {
        ...mapState('formItems', {
            genders: state => state.genders,
            civilStatuses: state => state.civilStatus,
        }),
        // ...mapGetters('applicant',{
        //     applicantData: 'getApplicant'
        // }),
        provinces: function() {
            return phil.sort(phil.provinces, "A")
        },
        toggleSwitchLabel: function () {
            if (this.switchAddress) {
                this.currentAddressReadOnly = true
                this.temp.currentAddressProvince = this.temp.permanentAddressProvince
                this.getCities(this.temp.currentAddressProvince, 'current')
                this.temp.currentAddressCity = this.temp.permanentAddressCity
                this.getBarangays(this.temp.currentAddressCity, 'current')
                this.applicantData.currentAddressBarangay = this.applicantData.permanentAddressBarangay
                this.applicantData.currentAddressHouseNumber = this.applicantData.permanentAddressHouseNumber
                this.applicantData.currentAddressStreetName = this.applicantData.permanentAddressStreetName
                this.applicantData.currentAddressZipCode = this.applicantData.permanentAddressZipCode
                return "Current and Permanent Address are THE SAME"
            } else {
                this.currentAddressReadOnly = false
                return "Current and Permanent Address are NOT THE SAME"
            }
        },
    },
    methods: {
        validate: function () {
            const provinces = phil.sort(phil.provinces, 'A')

            if (this.$refs.form.validate() && this.$refs.emailAddress.success && !this.$refs.emailAddress.loading ) {
                
                this.applicantData.permanentAddressProvince = provinces.find(prov => prov.prov_code === this.temp.permanentAddressProvince).name
                this.applicantData.permanentAddressCity = this.cities.permanent
                    .find(city => city.mun_code === this.temp.permanentAddressCity)
                    .name

                this.applicantData.currentAddressProvince = provinces.find(prov => prov.prov_code === this.temp.currentAddressProvince).name
                this.applicantData.currentAddressCity = this.cities.current
                    .find(city => city.mun_code === this.temp.currentAddressCity)
                    .name

                this.$emit('continue', this.applicantData)
                
            }
        },
        getCities: function(code, type) {
            this.cities[type] = phil.sort(phil.getCityMunByProvince(code), "A");
            this.barangays[type] = [];
        },
        getBarangays: function(code, type) {
            this.barangays[type] = phil.sort(phil.getBarangayByMun(code), "A");
        },
        validateEmail: function (e) {
            if (this.$refs.emailAddress.valid){
                this.emailLoading = true;

                this.$axios.get('admission/applicants/online/email/validation', { 
                    params: { 
                        emailAddress: e.target.value
                    } 
                })
                .then(res => {
                    if (res.data.results) {
                        this.emailLoading = false
                        this.emailError = false
                        this.emailErrorMessage = ''
                        this.emailSuccess = true
                        this.emailSuccessMessage = res.data.results.emailAddress
                    }
                })
                .catch(err => {
                    this.emailLoading = false
                    this.emailSuccess = false 
                    this.emailSuccessMessage = ''
                    this.emailError = true
                    this.emailErrorMessage = err.response.data.results.emailAddress
                })
            } 
            else {
                this.emailSuccess = false
                this.emailSuccessMessage = ''
                this.emailErrorMessage = ''
            }
        }
    },
    mounted: function () {
        const provinces = phil.sort(phil.provinces, 'A')

        if (this.$route.name == 'Edit Applicant') {
            this.emailSuccess = true
            
            this.temp.permanentAddressProvince = provinces.find(prov => prov.name === this.applicantData.permanentAddressProvince).prov_code
            this.temp.currentAddressProvince = provinces.find(prov => prov.name === this.applicantData.currentAddressProvince).prov_code

            this.getCities(this.temp.permanentAddressProvince, 'permanent')
            this.getCities(this.temp.currentAddressProvince, 'current')

            this.temp.permanentAddressCity = this.cities.permanent
                .find(city => city.name.toUpperCase() === this.applicantData.permanentAddressCity).mun_code
            this.temp.currentAddressCity = this.cities.permanent
                .find(city => city.name.toUpperCase() === this.applicantData.currentAddressCity).mun_code

            this.getBarangays(this.temp.permanentAddressCity, 'permanent')
            this.getBarangays(this.temp.currentAddressCity, 'current')

            this.applicantData.permanentAddressBarangay = this.applicantData.permanentAddressBarangay.replace(/\w\S*/g, function(txt) { 
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
            this.applicantData.currentAddressBarangay = this.applicantData.currentAddressBarangay.replace(/\w\S*/g, function(txt) { 
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });

            this.applicantData.telephoneNumber = this.applicantData.telephoneNumber.replace(/-/g, '')
        }
    },
};
</script>

<style lang="scss">
    // Reversed input variant
.v-input--reverse .v-input__slot {
  flex-direction: row-reverse;
  justify-content: flex-end;
  .v-application--is-ltr & {
    .v-input--selection-controls__input {
      margin-right: 0;
      margin-left: 8px;
    }
  }
  .v-application--is-rtl & {
    .v-input--selection-controls__input {
      margin-left: 0;
      margin-right: 8px;
    }
  }
}
</style>
