<template>
    <div>
        <!-- <v-toolbar
          color="white"
          flat
        >
           <v-btn block text color="primary" @click="$router.push({ name: 'Student Portal' })">Student Portal</v-btn>


          <v-toolbar-title class="grey--text text--darken-4">
            Albums
          </v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn
            icon
            light
          >
            <v-icon color="grey darken-2">
              mdi-magnify
            </v-icon>
          </v-btn>
        </v-toolbar> -->
        <v-card class="mx-auto mt-5 px-md-5 rounded-lg elevation-0" max-width="450" style="height: 100%">

            <div class="d-flex justify-center">
                <v-img max-width="150" src="../images/logo.png"></v-img>
            </div>

            <v-card-title class="my-3 d-block">
                <div class="text-center">
                    <span class="font-weight-bold">Systems Plus College Foundation</span>
                    <br>
                    <span style="font-size: 12px">School Management System</span>
                </div>
            </v-card-title>
            <div class="text-center mb-5">
                <span class="font-weight-bold" style="font-size: 15px">
                    {{ $router.currentRoute.name == 'Student Login' ? 'Student' : 'Employee' }} Login
                </span>
            </div>
            <v-form ref="form" @submit.prevent="validate()">
                <v-card-text class="my-5">
                    <v-text-field
                        v-if="$router.currentRoute.name == 'Student Login'"
                        label="Student Number"
                        :rules="$rules.required('Student Number')"
                        v-model="credentials.studentNumber"
                        outlined
                        dense
                    ></v-text-field>
                    <v-text-field v-else label="Employee Number" :rules="$rules.required('Employee number')"
                        v-model="credentials.employeeNumber" outlined dense></v-text-field>
                    <v-text-field outlined dense :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        v-model="credentials.password" :rules="[...$rules.required('Password')]"
                        :type="showPassword ? 'text' : 'password'" name="input-10-2" label="Password"
                        hint="At least 8 characters" class="mt-2" @click:append="showPassword = !showPassword">
                    </v-text-field>
                    <!-- <div class="d-flex justify-end">
                        <v-btn text dense color="primary" class="ml-0 text-capitalize px-0">Forgot password?</v-btn>
                    </div> -->

                    <div class="error--text text-center">{{ loginError }}</div>

                </v-card-text>

                <v-card-actions class="d-block px-5">
                    <v-btn type="submit" color="primary" block @click="validate()" :loading="loginLoading">
                        Login
                    </v-btn>
                    <v-btn block outlined color="primary" class="ml-0 mt-3" @click="$router.push({ name: 'Landing Page' })">
                        Go to Landing Page
                    </v-btn>
                </v-card-actions>
            </v-form>


            <div class="px-5">

            </div>

        </v-card>
        <!-- <v-footer app color="white">
            <v-row>
                <v-col cols="12" md="2" offset-md="4">
                    <v-btn block text color="primary" class="text-capitalize" @click="$router.push({ name: 'Create Applicant' })">Applicant Registration</v-btn>
                </v-col>
                <v-col cols="12" md="2">
                    <v-btn block text color="primary" class="text-capitalize" @click="$router.push({ name: 'Student Portal' })">Student Portal</v-btn>
                </v-col>
            </v-row>

        </v-footer> -->
    </div>
</template>

<script>
    import {
        mapActions,
        mapGetters
    } from 'vuex'
    export default {
        data: () => ({
            showPassword: false,
            credentials: {}
        }),
        computed: {
            ...mapGetters('user', {
                loginLoading: 'getLoginLoading',
                loginError: 'getLoginError'
            }),
        },
        methods: {
            ...mapActions('user', [
                'login'
            ]),
            validate: function () {
                if (this.$refs.form.validate()) {
                    this.login(this.credentials)
                }
            }
        },
    }

</script>
