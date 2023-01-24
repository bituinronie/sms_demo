<template>
    <div>
        <div v-if="getterPageLoading == false">
            <Alert :alert="alert" :typeValue="typeValue" :alertMessage="this.message" @updateAlert="onUpdateAlert" />
        </div>
            <v-row class="mb-5">
                <v-col cols="12" md="4">
                    <v-btn color="blue" class="elevation-0 white--text mt-2 px-2" @click="createDialog" :disabled="getterPageLoading">Create Proof of
                        Payment
                    </v-btn>
                </v-col>
                <v-col cols="12" md="8">
                    <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details>
                    </v-text-field>
                </v-col>
            </v-row>
        <v-card class="mt-5 elevation-0">

            <v-data-table class="tstyle" :headers="headers" :items="getterPageLoading == false ? studentProofOfPaymentList:[]" :search="search"
                :single-expand="singleExpand" :expanded.sync="expanded" item-key="random" show-expand :loading="getterPageLoading" loading-text="Proof of Payment/s is being Downloaded..."
                :class="getterPageLoading == null ? 'error-table' : getterPageLoading == true ? 'loading-table':''" 
                :no-data-text="getterErrorMessage != null ? getterErrorMessage:''">
                <template v-slot:expanded-item="{ headers, item }">
                    <td :colspan="headers.length" height="100%">
                        <center>
                            <v-img
                                v-if="(item.paymentReceipt.split('.').pop() == 'png' || item.paymentReceipt.split('.').pop() == 'jpeg' || item.paymentReceipt.split('.').pop() == 'jpg') && payment == true"
                                :src="`${$path.fileBaseUrl()}/student/${item.priorityNumber}/${item.paymentReceipt}`"
                                :max-width="`${$vuetify.breakpoint.width * .8}`" @error="paymentError"></v-img>
                            <iframe v-else-if="item.paymentReceipt.split('.').pop() == 'pdf'"
                                :src="`${$path.fileBaseUrl()}/student/${item.priorityNumber}/${item.paymentReceipt}`"
                                :width="`${$vuetify.breakpoint.width * .8}`"
                                :height="`${$vuetify.breakpoint.height * .8}`" frameborder="0"></iframe>
                            <div v-else class="error--text my-4">
                                File not Found
                            </div>
                        </center>
                    </td>
                </template>
                <template v-slot:[`item.paymentOption`]="{ item }" class="font-weight-normal">
                    <span v-if="item.paymentOption != 'OTHERS'">
                        {{item.paymentOption}}
                    </span>
                    <span v-else>
                        {{item.paymentOption + ' | ' + item.others}}
                    </span>
                </template>
                <template v-slot:[`item.actions`]="{ item }">
                    <td>
                        <v-btn depressed color="primary" small @click="updateDialog(item)"
                            v-if="item.paymentStatus != 'ACCEPTED'">
                            <v-icon left small>
                                mdi-pencil
                            </v-icon>
                            Update
                        </v-btn>
                    </td>
                </template>
            </v-data-table>
        </v-card>
     
        <div>
            <Form 
                :dialog="dialog" 
                :dialogTitle="dialogTitle" 
                :items="items" 
                :resetPageLoading="resetPageLoading"
                :getterOtherMessage="getterOtherMessage" 
                @closeDialog="onCloseDialog" 
            />
        </div>
    </div>
</template>
<script>
    import {
        mapActions,
        mapState,
    } from 'vuex'

    import Form from "./Form";

    import message from "../../../mixins/message";
    import loading from "../../../mixins/loading";

    export default {
        components: {
            Form
        },
        mixins: [
            message,
            loading
        ],
        data() {
            return {
                expanded: [],
                singleExpand: true,
                search: '',
                dialog: false,
                dialogTitle: '',
                alert: false,
                typeValue: 'success',
                message: '',
                items: {},
                payment: true
            }
        },
        computed: {
            ...mapState({
                studentProofOfPaymentList: state => state.studentProofOfPayment.list,
            }),
            headers() {
                return [{
                        text: "Payment Code",
                        value: "paymentCode",
                        align: 'left',
                        width: '10%',
                    },
                    {
                        text: "Payment",
                        value: "paymentType",
                        align: 'left',
                        width: '30%',
                    },
                    {
                        text: "Amount",
                        value: "amount",
                        align: 'left',
                        width: '10%',
                    },
                    {
                        text: "Status",
                        value: "paymentStatus",
                        align: 'left',
                        width: '10%',
                    },
                    {
                        text: "Remarks",
                        value: "remark",
                        align: 'left',
                        width: '30%',
                    },
                    {
                        text: "Actions",
                        value: "actions",
                        align: 'left',
                        width: '10%',
                    },
                ]
            }
        },
        methods: {
            ...mapActions('studentProofOfPayment', ['getLists']),
            createDialog() {
                this.items = null
                this.dialog = true
                this.dialogTitle = 'Create'
            },
            updateDialog(item) {
                this.items = item
                this.dialog = true
                this.dialogTitle = 'Update'
            },
            onCloseDialog(newValue) {
                this.dialog = newValue
            },
            paymentError() {
                this.payment = false
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
            expanded() {
                this.payment = true
            }
        },
        mounted() {
            this.getLists()
        },
        beforeDestroy() {
            this.resetPageLoading();
            this.resetOtherMessage();
            this.resetErrorMessage();
            this.resetMessage();
        },
    }

</script>
