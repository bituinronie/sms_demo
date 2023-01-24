<template>
    <v-simple-table>
        <template v-slot:default>
            <tbody class="caption">
                <tr>
                    <td width="25%">Birthday:</td>
                    <td>{{ $dateFormat.mdy(applicantInformation.birthDate) }} </td>
                </tr>
                <tr>
                    <td>Birthplace:</td>
                    <td>{{ applicantInformation.birthPlace }}</td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td>{{ applicantInformation.gender }}</td>
                </tr>
                <tr>
                    <td>Civil Status:</td>
                    <td>{{ applicantInformation.civilStatus }}</td>
                </tr>
                <tr>
                    <td>Nationality:</td>
                    <td>{{ applicantInformation.nationality }}</td>
                </tr>
                <tr>
                    <td>Religion:</td>
                    <td>{{ applicantInformation.religion }}</td>
                </tr>
                <tr>
                    <td>Current Address:</td>
                    <td>{{ getAddress.current }}</td>
                </tr>
                <tr>
                    <td>Permanent Address:</td>
                    <td>{{ getAddress.permanent }}</td>
                </tr>
                <tr>
                    <td>Telephone Number:</td>
                    <td>{{ applicantInformation.telephoneNumber }}</td>
                </tr>
                <tr>
                    <td>Mobile Number:</td>
                    <td>{{ '+63'+applicantInformation.mobileNumber }}</td>
                </tr>
                <tr>
                    <td>Email Adress:</td>
                    <td>
                        <div v-if="inputVisibility == 'hidden'">
                            <span>
                                {{ getEmail }}
                            </span>
                            <v-btn small color="info" dark @click="showInput()"
                                v-if="$auth.isEmployee() && getterPartLoading == false">
                                <v-icon left>
                                    mdi-email-edit
                                </v-icon>
                                Update
                            </v-btn>
                        </div>
                        <div v-else>
                            <v-form ref="form" v-model="valid" lazy-validation>
                                <v-row>
                                    <v-col cols="12" md="6">
                                        <v-text-field v-model="emailValue" label="Email"
                                            :rules="[...$rules.required('Email'), ...$rules.email('Email')]">
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6" align-self="center">
                                        <div v-if="classValue == 'show'">
                                            <v-btn class="d-inline" small color="primary" dark @click="validate()">
                                                <v-icon left>
                                                    mdi-email-check
                                                </v-icon>
                                                Save
                                            </v-btn>

                                            <v-btn class="d-inline" small color="warning" dark @click="cancel()">
                                                <v-icon left>
                                                    mdi-cancel
                                                </v-icon>
                                                Cancel
                                            </v-btn>
                                        </div>

                                        <v-btn small color="warning" v-else>
                                            <v-progress-circular :size="15" :width="2" color="white" indeterminate>
                                            </v-progress-circular>
                                            &nbsp; Updating
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </div>
                    </td>
                </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>

<script>
    import {
        mapActions,
        mapGetters
    } from 'vuex'
    export default {
        props: [
            'applicantInformation',
            'getterPartLoading',
            'getAddress',
            'email',
            'emailValidation'
        ],
        data() {
            return {
                valid: true,
                inputVisibility: 'hidden',
                emailValue: '',
                classValue: 'show',
            }
        },
        computed: {
            ...mapGetters('applicantInformation', [
                'getEmailLoading', 'getEmail'
            ]),
        },
        methods: {
            ...mapActions('applicantInformation', [
                'setEmailLoading',
            ]),
            showInput() {
                this.inputVisibility = 'show'
            },
            cancel() {
                this.inputVisibility = 'hidden'
                this.classValue = 'show'
                this.emailValue = this.getEmail
            },
            validate() {
                let data = {
                    function: 'Update',
                    values: {
                        emailAddress: this.emailValue
                    }
                }
                if (this.$refs.form.validate()) {
                    this.classValue = 'hidden'
                    this.setEmailLoading(true)
                    this.email(data)
                } else {
                    this.$refs.form.validate()
                }
            }
        },
        watch: {
            getEmailLoading(newValue) {
                if (newValue == false) {
                    this.inputVisibility = 'hidden'
                    this.classValue = 'show'
                } else {
                    this.inputVisibility = 'show'
                    this.classValue = 'hidden'
                }
                this.emailValue = this.getEmail
            }
        },
        mounted() {
            this.emailValue = this.getEmail
        },
        beforeDestroy() {
            this.setEmailLoading(false)
        }
    };

</script>
<style scoped>
    .hidden {
        display: none;
    }

    .show {
        display: block;
    }

</style>
