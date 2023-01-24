<template>
    <v-dialog :value="dialog" width="800" persistent>
        <v-card>
            <v-card-title class="headline white--text" :class="dialogHeaderColor">
                {{ dialogTitle + " Proof of Payment" }}
            </v-card-title>

            <v-card-text class="mt-4">
                <div>
                    <small class="error--text">**Note: For <span class="font-weight-bold">Online Payment</span>
                        Only.</small>
                    <br />
                    <v-form ref="form" :value="valid" lazy-validation>
                        <v-row>
                            <v-col cols="12" md="6" offset-md="3">
                                <v-img :src="`${placeHolder}/pdf.png`" class="mx-3 mt-3" :aspect-ratio="1"
                                    v-if="fileType == 'application'">
                                </v-img>
                                <v-img :src="fileUrl" class="mx-3 mt-3" :aspect-ratio="1" v-else>
                                </v-img>
                            </v-col>
                        </v-row>
                        <v-file-input label="Upload" :rules="[
                                ...$rules.required('File'),
                                ...$rules.file('File', 'png/jpeg/jpg/pdf'),
                                ...$rules.fileSize('5 MB', 5242880)
                            ]" accept="image/jpeg, image/jpg, image/png, application/pdf" class="mx-3" v-model="file"
                            @change="onFileChange"></v-file-input>
                        <v-text-field v-model="codeValue" label="Code" class="mx-3" readonly
                            v-if="dialogTitle == 'Update'">
                        </v-text-field>
                        <v-autocomplete v-model="paymentOptionValue" :items="paymentTypeList" item-text="paymentTypeList"
                            label="Payment" :rules="$rules.required('Payment')" class="mx-3" return-object>
                        </v-autocomplete>
                        <v-text-field v-model="specify" label="Specify"
                            :rules="paymentOptionValue ==='OTHER'?$rules.required('Specify'):[]" class="mx-3"
                            :class="paymentOptionValue == 'OTHER'? 'show':'hidden'" @keyup="specifyUpperCase()">
                        </v-text-field>

                        <v-text-field type="number" prefix="PHP" v-model="amount" label="Amount"
                            :rules="[...$rules.required('Amount'), ...$rules.greaterThan('Amount', 0)]" class="mx-3 mt3">
                        </v-text-field>
                    </v-form>
                </div>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions class="py-4">
                <v-spacer></v-spacer>
                <v-btn color="error" depressed @click="cancel()">
                    Cancel
                </v-btn>
                <v-btn color="primary" depressed @click="validate()">
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import {
        mapActions,
        mapState
    } from "vuex";

    export default {
        props: [
            'dialog',
            'dialogTitle',
            'items',
            'resetPageLoading',
            'getterOtherMessage'
        ],
        data() {
            return {
                search: '',
                valid: true,
                dialogHeaderColor: '',
                function: '',
                codeValue: '',
                paymentOptionValue: '',
                specify: '',
                amount: '',
                file: null,
                originalFile: '',
                fileType: '',
                fileUrl: '',
                defaultUrl: '',
                placeHolderUrl: '',
                placeHolder: '',
                itemsValue: {}
            };
        },
        computed: {
            ...mapState({
                paymentTypeList: state => state.indexList.paymentTypeList
            })
        },
        methods: {
            ...mapActions("studentProofOfPayment", ["submitData"]),
            specifyUpperCase() {
                this.specify = this.specify.toUpperCase()
            },
            cancel() {
                if (this.dialogTitle == "Create") {
                    this.$refs.form.reset()
                } else {
                    this.codeValue = this.itemsValue.paymentCode
                    this.paymentOptionValue = this.itemsValue.paymentOption
                    this.amount = this.itemsValue.amount
                    this.specify = this.itemsValue.other

                    this.file = new File(["foo"], this.itemsValue.paymentReceipt)
                    this.originalFile = this.itemsValue.paymentReceipt

                    if (this.itemsValue.paymentReceipt.split(".").pop() == "pdf") {
                        this.fileType = "application"
                    } else {
                        this.fileType = "image"
                    }
                    this.fileUrl = `${this.$path.fileBaseUrl()}/student/${
                    this.itemsValue.priorityNumber
                }/${this.itemsValue.paymentReceipt}`
                }
                this.$emit("closeDialog", false);
            },
            validate() {
                let value = {
                    paymentOption: this.paymentOptionValue,
                    other: this.specify,
                    amount: this.amount,
                    paymentReceipt: this.file
                };
                let data = {
                    values: value,
                    item: {
                        function: this.function,
                        file: this.originalFile,
                        code: this.codeValue
                    }
                };

                if (this.$refs.form.validate()) {
                    switch (this.function) {
                        case "Create":
                        case "Update":
                            this.$emit("closeDialog", false);
                            this.submitData(data);
                            break;
                        default:
                            break;
                    }
                    if (this.function == "Create") {
                        this.$refs.form.reset();
                    }
                } else {
                    this.$refs.form.validate();
                    this.$emit("closeDialog", true);
                }
            },
            onFileChange: function (e) {
                if (this.file != "" && this.file != null) {
                    this.fileUrl = URL.createObjectURL(this.file);
                    var str = this.file.type.substring(
                        0,
                        this.file.type.indexOf("/")
                    );
                    this.fileType = str;
                } else {
                    this.file = null;
                    this.fileUrl = this.defaultUrl;
                    this.fileType = null;
                }
            }
        },
        watch: {
            dialogTitle(newValue) {
                this.function = newValue;
                switch (newValue) {
                    case "Create":
                        this.dialogHeaderColor = "primary";

                        if (this.paymentOptionValue || this.amount || this.file) {
                            this.$refs.form.reset();
                        }
                        break;
                    case "Update":
                        this.dialogHeaderColor = "info";
                        break;
                    default:
                        break;
                }
            },
            items(newValue) {
                if (newValue != null && this.dialogTitle == "Update") {
                    this.itemsValue = newValue
                    this.codeValue = newValue.paymentCode
                    this.paymentOptionValue = newValue.paymentOption
                    this.amount = newValue.amount
                    this.specify = newValue.other

                    this.file = new File(["foo"], newValue.paymentReceipt)
                    this.originalFile = newValue.paymentReceipt

                    if (newValue.paymentReceipt.split(".").pop() == "pdf") {
                        this.fileType = "application"
                    } else {
                        this.fileType = "image"
                    }
                    this.fileUrl = `${this.$path.fileBaseUrl()}/student/${
                    newValue.priorityNumber
                }/${newValue.paymentReceipt}`

                }
            },
            getterOtherMessage() {
                if (this.dialogTitle != 'Create') {
                    this.codeValue = this.itemsValue.paymentCode
                    this.paymentOptionValue = this.itemsValue.paymentOption
                    this.amount = this.itemsValue.amount
                    this.specify = this.itemsValue.other
                    this.file = new File(["foo"], this.itemsValue.paymentReceipt)
                    this.originalFile = this.itemsValue.paymentReceipt

                    if (this.itemsValue.paymentReceipt.split(".").pop() == "pdf") {
                        this.fileType = "application"
                    } else {
                        this.fileType = "image"
                    }
                    this.fileUrl = `${this.$path.fileBaseUrl()}/student/${
                    this.itemsValue.priorityNumber
                }/${this.itemsValue.paymentReceipt}`
                }
            }
        },
        mounted() {
            if (this.$path.isLocal()) {
                this.placeHolder = "../../images";
                this.fileUrl = "../../images/upload.png";
                this.defaultUrl = "../../images/upload.png";
            } else {
                this.placeHolder = this.$path.placeHolderUrl();
                this.fileUrl = this.$path.placeHolderUrl() + "/upload.png";
                this.defaultUrl = this.$path.placeHolderUrl() + "/upload.png";
            }
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
