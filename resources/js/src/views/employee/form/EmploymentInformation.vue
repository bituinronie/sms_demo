<template>
    <div class="pa-5">
        <v-form ref="form" lazy-validation enctype="multipart/form-data">
            <v-row>
                <v-col cols="12" md=3>
                    <v-autocomplete
                        :items="branches"
                        label="Branch"
                        item-text="name"
                        item-value="code"
                        v-model="employeeData.branch"
                        outlined
                        :rules="$rules.required('Branch')"
                        dense
                    >
                    </v-autocomplete>
                </v-col>
                <v-col cols="12" md="3">
                    <v-autocomplete
                        :items="employeeTypes"
                        label="Employee Type"
                        v-model="employeeData.type"
                        outlined
                        dense
                    >
                    </v-autocomplete>
                </v-col>
                <v-col cols="12" md="6">
                    <v-autocomplete
                        :items="departments"
                        item-text="name"
                        item-value="code"
                        label="Department"
                        v-model="employeeData.department"
                        outlined
                        dense
                        :rules="$rules.required('Department')"
                    >
                    </v-autocomplete>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="12">
                    <span class="font-weight-bold">FILES</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4">
                    <v-file-input
                        label="ID Picture (Front)"
                        accept="image/png, image/jpeg, image/jpg"
                        v-model="employeeData.imageIdFront"
                        :rules="$rules.file('ID (Front)', 'png/jpg/jpeg')"
                        outlined
                        dense
                        @change="onFileChange('imageIdFront')"
                    ></v-file-input>
                    <v-file-input
                        label="ID Picture (Back)"
                        accept="image/png, image/jpeg, image/jpg"
                        v-model="employeeData.imageIdBack"
                        :rules="$rules.file('ID (Back)', 'png/jpg/jpeg')"
                        outlined
                        dense
                        @change="onFileChange('imageIdBack')"
                    ></v-file-input>
                    <v-file-input
                        label="Signature"
                        accept="image/png, image/jpeg, image/jpg"
                        v-model="employeeData.imageSignature"
                        :rules="$rules.file('Signature', 'png/jpg/jpeg')"
                        outlined
                        dense
                        @change="onFileChange('imageSignature')"
                    ></v-file-input>
                </v-col>
                <v-col cols="12" md="8">
                    <v-row>
                        <v-col cols="6" md="4">
                            <v-img
                                :src="images.imageIdFront"
                                class="pa-5 mb-10"
                                :aspect-ratio="2/3"
                                max-height="200"
                            ></v-img>
                            <div class="text-center" style="font-size: 12px">ID Picture (Front)</div>
                        </v-col>
                        <v-col cols="6" md="4">
                            <v-img
                                :src="images.imageIdBack"
                                class="pa-5 mb-10"
                                :aspect-ratio="2/3"
                                max-height="200"
                            ></v-img>
                            <div class="text-center" style="font-size: 12px">ID Picture (Back)</div>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-img
                                :src="images.imageSignature"
                                class="pa-5 mb-10"
                                :aspect-ratio="2/3"
                                max-height="200"
                            ></v-img>
                            <div class="text-center" style="font-size: 12px">Signature</div>
                        </v-col>
                    </v-row>
                    
                </v-col>
            </v-row>
           
            <v-row class="mx-2 mt-5 justify-center">
                <v-btn color="primary" @click="$emit('previous')" class="mt-5" style="width: 150px">
                    <v-icon left>mdi-chevron-left</v-icon>
                     Previous
                </v-btn>
                <v-spacer class="hidden-xs"></v-spacer>
                <v-btn color="accent" @click="validate()" class="mt-5" :loading="submitLoading" style="width: 150px">
                    Submit
                    <v-icon right>mdi-chevron-right</v-icon>
                </v-btn>
            </v-row>
        </v-form>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
    export default {
        props: ['employeeData'],
        data() {
            return {
                images: {
                    imageIdFront: '../images/gray-placeholder.png',
                    imageIdBack: '../images/gray-placeholder.png',
                    imageSignature: '../images/gray-placeholder.png'
                }
            }
        },
        computed: {
            ...mapState('formItems', {
                employeeTypes: state => state.employeeTypes,
                departments: state => state.departments,
                branches: state => state.branches,
            }),
            ...mapState('employee', {
                submitLoading: state => state.submitLoading,
            })
        },
        methods: {
            ...mapActions('formItems', [
                'getData'
            ]),
            validate: function () {
                if (this.$refs.form.validate()) {
                    this.$emit('submitForm', this.employeeData)
                }
            },
            onFileChange: function (key) {
                if (this.employeeData[key]) {
                    this.images[key] = URL.createObjectURL(this.employeeData[key])
                }
            },
        },
    };
</script>
