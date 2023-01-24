<template>
    <div v-if="this.$auth.isEmployee()">
        <hr class="my-4">

        <div class="mt-5 float-right">
            <div class="d-inline" v-if="getterPartLoading == false">
                <v-btn color="info" @click="updateApplicantRedirect(applicantInformation.priorityNumber)">
                    <v-icon left>
                        mdi-account-edit
                    </v-icon>
                    Edit
                </v-btn>
            </div>
            <div class="d-inline">
                <v-btn color="primary" @click="showModal" :loading="getterPartLoading == false?false:true">
                    <v-icon left>
                        mdi-format-list-bulleted-square
                    </v-icon>
                    Options
                </v-btn>
            </div>
        </div>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title :class="formVisibility == 'show'? 'primary': 'error'">
                    <span class="headline white--text">{{formVisibility == 'show' ?'Update Status':'Archive'}}</span>
                </v-card-title>

                <v-divider></v-divider>

                <div class="mx-3">
                    <v-form ref="form" v-model="valid" lazy-validation :class="formVisibility">
                        <v-autocomplete v-model="status" :items="options" item-text="options" label="Status"
                            :rules="$rules.required('Status')" class="mx-3 mt-3" return-object
                            @change="statusSelect(status)"></v-autocomplete>
                        <v-text-field v-model="remarks" label="Remarks" :rules="$rules.required('Remarks')" class="mx-3"
                            :class="classValue" @input="upperCase">
                        </v-text-field>
                    </v-form>
                    <div v-if="formVisibility == 'hidden'" class="error--text my-4 mx-3">
                        Are you sure you want to archive {{getFullName}} ?
                    </div>
                </div>

                <v-divider></v-divider>

                <v-card-actions class="py-4">
                    <v-spacer></v-spacer>
                    <v-btn :color="formVisibility == 'hidden'?'warning':'error'" depressed @click="cancel()">
                        Cancel
                    </v-btn>
                    <v-btn color="primary" depressed @click="validate()" v-if="formVisibility == 'show'">
                        Submit
                    </v-btn>
                    <v-btn color="error" depressed @click="archive()" v-else>
                        Archive
                    </v-btn>
                </v-card-actions>

            </v-card>
        </v-dialog>

    </div>
</template>
<script>
    import {
        mapActions,
    } from 'vuex'
    export default {
        props: [
            'applicantInformation',
            'getterPartLoading',
            'resetPartLoading',
            'getFullName',
        ],
        data() {
            return {
                valid: true,
                options: ['ACCEPTED', 'DENIED', 'ARCHIVE'],
                dialog: false,
                remarks: '',
                status: '',
                classValue: 'hidden',
                formVisibility: 'show',
            }
        },
        methods: {
            ...mapActions('applicantInformation', [
                'updateStatus'
            ]),
            ...mapActions('applicantList', [
                'changeData',
            ]),

            updateApplicantRedirect(id) {
                this.$router.push({
                    name: 'Edit Applicant',
                    params: {
                        id: id
                    }
                });
            },
            upperCase() {
                this.remarks = this.remarks != null ? this.remarks.toUpperCase() : ''
            },
            showModal() {
                return this.dialog = true
            },
            cancel() {
                this.$refs.form.reset()
                this.classValue = 'hidden'
                this.dialog = false
                this.formVisibility = 'show'
            },

            // IMPORTANT
            statusSelect(status) {
                if (status == 'ACCEPTED') {
                    this.status = 'ACCEPTED'
                    this.remarks = 'YOU CAN NOW PAY FOR YOUR STUDENT FEES. MINIMUM AMOUNT IS ₱ 1,000.00'
                    this.classValue = 'hidden';
                } else if (status == 'DENIED') {
                    this.status = 'DENIED'
                    this.remarks = ''
                    this.$refs.form.resetValidation()
                    this.classValue = 'show';
                } else if (status == 'ARCHIVE') {
                    this.status = 'ARCHIVE'
                    this.remarks = 'N/A'
                    this.$refs.form.resetValidation()
                    this.classValue = 'hidden';
                } else {

                }
            },
            validate() {
                let item = {
                    applicantStatus: this.status,
                    remark: this.remarks
                }
                if (this.$refs.form.validate()) {
                    switch (this.status) {
                        case 'ARCHIVE':
                            this.dialog = true
                            this.formVisibility = 'hidden'
                            break;
                        case 'ACCEPTED':
                        case 'DENIED':
                            this.resetPartLoading();
                            this.updateStatus(item)
                            this.dialog = false
                            break;
                        default:
                    }
                } else {
                    this.$refs.form.validate()
                }
            },
            archive() {
                let data = {
                    id: this.applicantInformation.priorityNumber,
                    function: 'Archive'
                }
                this.changeData(data)

                this.$refs.form.reset()
                this.classValue = 'hidden'
                this.dialog = false
                this.formVisibility = 'show'
            },

        },
    }

</script>
<style scoped>
    .hidden {
        display: none;
    }

    .show {
        display: block;
    }

</style>
