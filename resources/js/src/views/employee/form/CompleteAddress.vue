<template>
    <div class="pa-5">
        <v-form ref="form" lazy-validation enctype="multipart/form-data">
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
                        v-model="employeeData.permanentAddressBarangay"
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
                        v-model="employeeData.permanentAddressHouseNumber"
                        :rules="$rules.required('House No./Building No.')"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Street Name"
                        v-model="employeeData.permanentAddressStreetName"
                        :rules="$rules.required('Street Name')"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>

                <v-col cols="12" md="4">
                    <v-text-field
                        label="Zip Code"
                        v-model="employeeData.permanentAddressZipCode"
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
                        outlined
                        dense
                        @change="(e) => getCities(e, 'current')"
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
                        @change="(e) => getBarangays(e, 'current')"
                        outlined
                        dense
                    ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="4">
                    <v-autocomplete
                        :items="barangays.current"  
                        v-model="employeeData.currentAddressBarangay"
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
                        v-model="employeeData.currentAddressHouseNumber"
                        :rules="$rules.required('House No./Building No.')"
                        :readonly="currentAddressReadOnly"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        label="Street Name"
                        v-model="employeeData.currentAddressStreetName"
                        :rules="$rules.required('Street Name')"
                        :readonly="currentAddressReadOnly"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>

                <v-col cols="12" md="4">
                    <v-text-field
                        label="Zip Code"
                        v-model="employeeData.currentAddressZipCode"
                        :readonly="currentAddressReadOnly"
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
import { mapState } from 'vuex';
import phil from "phil-reg-prov-mun-brgy";

export default {
    props: ['employeeData'],
    data: () => ({
        switchAddress: false,
        currentAddressReadOnly: false,
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
                this.employeeData.currentAddressBarangay = this.employeeData.permanentAddressBarangay
                this.employeeData.currentAddressHouseNumber = this.employeeData.permanentAddressHouseNumber
                this.employeeData.currentAddressStreetName = this.employeeData.permanentAddressStreetName
                this.employeeData.currentAddressZipCode = this.employeeData.permanentAddressZipCode
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

            if (this.$refs.form.validate()) {
                
                this.employeeData.permanentAddressProvince = provinces.find(prov => prov.prov_code === this.temp.permanentAddressProvince).name
                this.employeeData.permanentAddressCity = this.cities.permanent
                    .find(city => city.mun_code === this.temp.permanentAddressCity)
                    .name

                this.employeeData.currentAddressProvince = provinces.find(prov => prov.prov_code === this.temp.currentAddressProvince).name
                this.employeeData.currentAddressCity = this.cities.current
                    .find(city => city.mun_code === this.temp.currentAddressCity)
                    .name

                this.$emit('continue', this.employeeData)
                
            }
        },
        getCities: function(code, type) {
            this.cities[type] = phil.sort(phil.getCityMunByProvince(code), "A");
            this.barangays[type] = [];
        },
        getBarangays: function(code, type) {
            this.barangays[type] = phil.sort(phil.getBarangayByMun(code), "A");
        },
    },
    mounted: function () {
        const provinces = phil.sort(phil.provinces, 'A')

        if (this.$route.name == 'Edit Employee') {
            this.temp.permanentAddressProvince = provinces.find(prov => prov.name === this.employeeData.permanentAddressProvince).prov_code
            this.temp.currentAddressProvince = provinces.find(prov => prov.name === this.employeeData.currentAddressProvince).prov_code

            this.getCities(this.temp.permanentAddressProvince, 'permanent')
            this.getCities(this.temp.currentAddressProvince, 'current')

            this.temp.permanentAddressCity = this.cities.permanent
                .find(city => city.name.toUpperCase() === this.employeeData.permanentAddressCity).mun_code
            this.temp.currentAddressCity = this.cities.permanent
                .find(city => city.name.toUpperCase() === this.employeeData.currentAddressCity).mun_code

            this.getBarangays(this.temp.permanentAddressCity, 'permanent')
            this.getBarangays(this.temp.currentAddressCity, 'current')

            this.employeeData.permanentAddressBarangay = this.employeeData.permanentAddressBarangay.replace(/\w\S*/g, function(txt) { 
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
            this.employeeData.currentAddressBarangay = this.employeeData.currentAddressBarangay.replace(/\w\S*/g, function(txt) { 
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
        }
    }
}
</script>
