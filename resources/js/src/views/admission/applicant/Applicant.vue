<template>
    <v-container>
        <div v-if="getterPageLoading == false && getterPartLoading == false">
            <Alert :alert="alert" :typeValue="typeValue" :alertMessage="this.message" @updateAlert="onUpdateAlert" />
        </div>
        <div v-if="getterPageLoading == false">
            <v-row>
                <v-col md="3">
                    <BasicInformation 
                        :applicantInformation="applicantInformation" 
                        :getFullName="getFullName"
                        :getVoucher="getVoucher" 
                        :getStatusGetter="getStatusGetter"
                        :getRequirement="getRequirement" 
                        :getterPartLoading="getterPartLoading" :getterErrorMessage="getterErrorMessage"
                        :resetPartLoading="resetPartLoading" />
                </v-col>
                <v-col md="9">
                    <Body 
                        :applicantInformation="applicantInformation" 
                        :getAddress="getAddress"
                        :getRequirement="getRequirement" 
                        :getterPartLoading="getterPartLoading"
                        :resetPageLoading="resetPageLoading" 
                        :resetPartLoading="resetPartLoading" 
                        :email="email"
                        :emailValidation="emailValidation" 
                        :resetMessage="resetMessage" />
                    
                    <Option 
                        :applicantInformation="applicantInformation"
                        :getFullName="getFullName" 
                        :getterPartLoading="getterPartLoading" 
                        :email="email"
                        :resetPartLoading="resetPartLoading" />
                </v-col>
            </v-row>
        </div>
        <div v-else-if="getterPageLoading == true">
            <Loading />
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
    import "../../../styles/tables/simple_table.css";
    import Body from "./Body";
    import BasicInformation from "./BasicInformation";
    import Option from "./Option";

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
            Body,
            Option,
        },
        mixins: [
            message,
            loading
        ],
        computed: {
            ...mapState({
                applicantInformation: state => state.applicantInformation.information,
            }),
            ...mapGetters('applicantInformation', [
                'getFullName',
                'getVoucher',
                'getAddress',
                'getRequirement',
                'getStatusGetter',
            ]),
        },
        data() {
            return {
                alert: false,
                message: '',
                typeValue: 'success'
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
            ...mapActions('applicantInformation', [
                'getInformation', 'email', 'emailValidation',
            ]),
        },

        mounted() {
            this.getInformation();
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
        },
    }

</script>
