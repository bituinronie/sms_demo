<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" persistent width="700px">
            <v-card>
                <v-card-title class="primary white--text">
                    Select User
                </v-card-title>
                <v-card-text class="pa-10 text-center">
                    <v-row>
                        <v-col cols="12" md="4" class="mx-auto">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn color="primary" rounded width="160px" height="160px"
                                        @click="redirect('employee')" v-bind="attrs" v-on="on">
                                        <v-icon size="80px">
                                            mdi-account-tie
                                        </v-icon>
                                    </v-btn>
                                </template>
                                <span>Employee</span>
                            </v-tooltip>
                        </v-col>
                        <v-col cols="12" md="4" class="mx-auto">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn color="info" rounded width="160px" height="160px"
                                        @click="redirect('student')" v-bind="attrs" v-on="on">
                                        <v-icon size="80px">
                                            mdi-school
                                        </v-icon>
                                    </v-btn>
                                </template>
                                <span>Student</span>
                            </v-tooltip>
                        </v-col>
                        <v-col cols="12" md="4" class="mx-auto">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn color="error" rounded width="160px" height="160px"
                                        @click="redirect('dashboard')" v-bind="attrs" v-on="on">
                                        <v-icon size="80px">
                                            mdi-view-dashboard
                                        </v-icon>
                                    </v-btn>
                                </template>
                                <span>Dashboard</span>
                            </v-tooltip>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
    export default {
        data() {
            return {
                dialog: true,
                radioOption: '',
                disabledValue: true,
            }
        },
        methods: {
            redirect(value) {
                switch (value) {
                    case 'dashboard':
                        this.$router.push({
                            name: 'Dashboard',
                        });
                        break;
                    case 'employee':
                        this.$router.push({
                            name: 'User (Employee)',
                        });
                        break;
                    case 'student':
                        this.$router.push({
                            name: 'User (Student)',
                        });
                        break;
                    default:
                        break;
                }
            },
        }
    }

</script>
