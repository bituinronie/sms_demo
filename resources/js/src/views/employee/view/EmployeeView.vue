<template>
    <v-container>
        <div v-if="getterPageLoading">
            <Alert :alert="alert" :typeValue="typeValue" :alertMessage="this.message" @updateAlert="onUpdateAlert" />
        </div>
        <div v-if="employeeLoading">
            <Loading />
        </div>
        <div v-else-if="!employeeLoading">
            <v-row>
                <v-col md="3">
                    <BasicInformation :employeeData="employeeData"  />
                </v-col>
                <v-col md="9">
                    <div class="text-center justify-center py-6 black">
                        <span class="font-weight-bold white--text">
                            EMPLOYEE INFORMATION
                        </span>
                    </div>
                    <v-tabs v-model="tabs" centered grow>
                        <v-tab v-for="item in items" :key="item" active-class="active primary--text">
                            {{ item }}
                        </v-tab>
                    </v-tabs>
                    <v-divider class="black"></v-divider>
                    <v-tabs-items v-model="tabs" class="custom-font">
                        <v-tab-item>
                            <div>
                                <PersonalInformation :employeeData="employeeData" />
                            </div>
                        </v-tab-item>
                        <v-tab-item>
                            <div>
                                <Files :employeeData="employeeData" />
                            </div>
                        </v-tab-item>
                    </v-tabs-items>
                        <div>
                            <v-divider class="my-4"></v-divider>

                            <div class="mt-5 float-right">
                                <div class="d-inline">
                                    <v-btn color="info" 
                                        @click="$router.push({ name: 'Edit Employee', params: { id: $router.currentRoute.params.id } })"
                                    >
                                        <v-icon left>
                                            mdi-account-edit
                                        </v-icon>
                                        Edit
                                    </v-btn>
                                </div>
                            </div>
                        </div>
                </v-col>
            </v-row>
        </div>
        <div v-else>
            <v-row style="height: 200px"></v-row>
            <v-row class="mt-16">
                <v-col cols="12" md="6" offset-md="3" class="text-center error--text">
                    <h1>Something Went Wrong</h1>
                    {{getterErrorMessage}}
                </v-col>
            </v-row>
        </div>
    </v-container>
</template>

<script>
    // import "../../../styles/tables/simple_table.css";
    import BasicInformation from "./BasicInformation";
    // import Option from "./Option";

    import PersonalInformation from "./PersonalInformation";
    import Files from "./Files";

    import Alert from "../../../components/Alert";
    import Loading from "../../../components/Loading";

    import message from "../../../mixins/message";
    import loading from "../../../mixins/loading";

    import {
        mapActions,
        mapGetters,
        mapState
    } from 'vuex'

    export default {
        components: {
            BasicInformation,
            Alert,
            Loading,
            PersonalInformation,
            Files,
        },
        mixins: [
            message,
            loading
        ],
        computed: {
            ...mapState('employee', {
                employeeData: state => state.employeeData,
                employeeLoading: state => state.employeeLoading,
            }),
        },
        data() {
            return {
                alert: false,
                message: '',
                typeValue: 'success',
                tabs: null,
                items: [
                    'PERSONAL INFORMATION', 'FILES'
                ],
            }
        },
        watch: {
            getterMessage: function (newMessage) {
                if (newMessage != null) {
                    this.alert = true
                    this.typeValue = 'success'
                    this.message = newMessage[0]
                }
            },
            getterOtherMessage: function (newMessage) {
                if (newMessage != null) {
                    this.alert = true
                    this.typeValue = 'error'
                    this.message = newMessage[0]
                }
            },
        },
        methods: {
            ...mapActions('employee', [
                'getEmployee', 'resetEmployee'
            ]),
        },

        mounted() {
            this.getEmployee();
            if (this.getterRedirectMessage != null) {
                this.alert = true
                this.message = this.getterRedirectMessage
            }
        },
        beforeDestroy() {
            this.resetMessage();
            this.resetOtherMessage();
            this.resetErrorMessage();
            this.resetRedirectMessage();
            this.resetPageLoading();
            this.resetEmployee();
        }
    }

</script>
