<template>
    <div>
        <div>
            <Alert :alert="alert" :typeValue="typeValue" :alertMessage="this.message" @updateAlert="onUpdateAlert" />
        </div>
        <div style="display: table; position: absolute; top: 0; left: 0; height: 100%; width: 100%">
            <v-row style="display: table-cell; vertical-align: middle">
                <v-col cols="12" md="6" offset-md="3">
                    <v-form ref="form" @submit.prevent="validate()">
                        <v-row>
                            <v-text-field 
                                outlined 
                                dense 
                                :error="changePasswordError ? true : false"
                                :error-messages="changePasswordError"
                                :append-icon="showPassword.currentPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                v-model="passwords.oldPassword" 
                                :rules="[...$rules.required('Current password')]"
                                :type="showPassword.currentPassword ? 'text' : 'password'" 
                                label="Current Password"
                                @click:append="showPassword.currentPassword = !showPassword.currentPassword">
                            </v-text-field>
                        </v-row>
                        <v-row>
                            <v-divider class="mb-6"></v-divider>
                        </v-row>
                        <v-row>
                            <v-text-field 
                                outlined 
                                dense 
                                :append-icon="showPassword.newPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                v-model="passwords.password" 
                                :rules="[...$rules.required('New password')]"
                                :type="showPassword.newPassword ? 'text' : 'password'"  
                                label="New Password"
                                @click:append="showPassword.newPassword = !showPassword.newPassword">
                            </v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field 
                                outlined 
                                dense 
                                :append-icon="showPassword.confirmNewPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                v-model="confirmPassword" 
                                :rules="[...$rules.required('Confirm new password'), ...$rules.equal('Passwords', passwords.password)]"
                                :type="showPassword.confirmNewPassword ? 'text' : 'password'" 
                                name="input-10-2" 
                                label="Confirm New Password"
                                @click:append="showPassword.confirmNewPassword = !showPassword.confirmNewPassword">
                            </v-text-field>
                        </v-row>
                        <v-row>
                            <v-spacer></v-spacer>
                            <v-btn type="submit" style="width: 150px"  color="primary" :loading="changePasswordLoading">
                                Submit
                            </v-btn>
                        </v-row>
                    </v-form>
                </v-col>
            </v-row>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';

import Alert from '../../components/Alert'

import message from "../../mixins/message";
import loading from "../../mixins/loading";

export default {
    components: { Alert },
    data() {
        return {
            passwords: {},
            showPassword: {
                currentPassword: false,
                newPassword: false, 
                confirmNewPassword: false,
            },
            confirmPassword: '',
            alert: false,
            typeValue: 'success',
            message: 'Password updated successfully!',
        }
    },
    mixins: [
        message,
        loading
    ],
    computed: {
        ...mapState('user', {
            changePasswordLoading: state => state.changePasswordLoading,
            changePasswordError: state => state.changePasswordError,
            changePasswordSuccess: state => state.changePasswordSuccess,
        })
    },
    methods: {
        ...mapActions('user', [
            'changePassword'
        ]),
        validate: function () {
            if (this.$refs.form.validate()) {
                this.changePassword(this.passwords)
            }
        }
    },
    watch: {
        changePasswordSuccess: function (bool) {
            if (bool) {
                this.alert = true
                this.$refs.form.reset();
            } else {
                this.alert = false
            }
        }
    }

};
</script>
