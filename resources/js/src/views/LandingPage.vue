<template>
    <div style="margin-top: 100px">
        <v-row class="mb-10">
            <v-col cols="12" sm="12" md="8" offset-md="2">
                <v-row>
                     <v-col cols="2" sm="1" md="1" offset-md="2">
                        <div>
                            <v-img class="image" src="../images/logo.png"></v-img>
                        </div>
                    </v-col>
                    <v-col cols="10" sm="11" md="6">
                        <div class="font-weight-bold text-center" style="font-size: 20px;">
                            SYSTEMS PLUS COLLEGE FOUNDATION
                        </div>
                        <div class="text-center" style="font-size: 15px;">School Management System</div>
                    </v-col>
                </v-row>
                <v-row>
                     <v-col cols="12" sm="12" md="8" offset-md="2">
                        <v-divider></v-divider>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" sm="6" md="3" offset-md="3">
                <v-card class="mx-auto card" @click="changeUserType('student')">
                    <div class="card-icon">
                        <v-icon class="icon" color="white">mdi-school-outline</v-icon>
                    </div>
                    <v-card-text>
                        <div class="white--text text-center" style="font-size: 20px">
                            I am a
                            <br>
                            <span class="font-weight-bold">Student</span>
                        </div>
                    </v-card-text>
                </v-card>
                <div v-if="userType == 'student'" class="buttons pa-2">
                    <v-btn block  outlined color="primary" class="mb-2" @click="$router.push({ name: 'Student Login' })">Login</v-btn>
                    <v-btn block  outlined color="primary" @click="$router.push({ name: 'Create Applicant' })">Register</v-btn>
                </div>
            </v-col>
            <v-col cols="12" sm="6" md="3">
                <v-card class="mx-auto card"  @click="$router.push({ name: 'Login' })">
                    <div class="card-icon">
                        <v-icon class="icon" color="white">mdi-briefcase-outline</v-icon>
                    </div>
                    <v-card-text>
                        <div class="white--text text-center" style="font-size: 20px">
                            I am an
                            <br>
                            <span class="font-weight-bold">SPCF Employee</span>
                        </div>
                    </v-card-text>
                </v-card>
                <!-- <div v-if="userType == 'employee'" class="buttons pa-2">
                    <v-btn block outlined color="primary" class="mb-2" @click="$router.push({ name: 'Login' })">Login</v-btn>
                    <v-btn block outlined color="primary" @click="$router.push({ name: '' })">Register</v-btn>
                </div> -->
            </v-col>
        </v-row>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                userType: ''
            }   
        },
        methods: {
            changeUserType: function(type) {
                if (this.userType == type) {
                    this.userType = ''
                } else {
                    this.userType = type
                }
                
            }
        }
    };
</script>

<style scoped>
    .card {
        background-color: var(--v-primary-base) !important;
        border-radius: 20px !important;
        padding: 10px;
        margin: 20px;
    }
    .card-icon {
        padding: 10px;
    }
    .icon {
        font-size: 80px !important;
        width: 100% !important;
    }
    .image {
        height: 100%;
    }
    .buttons {
        transition: all 0.5s;
    }
</style>

