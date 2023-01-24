<template>
    <div class="mt-3">
        <v-card class="white--text info" rounded="2" elevation="0">
            <v-row>
                <v-col cols="12" md="12" align="center" justify="center" position="center center">
                    <v-img class=" mx-3 my-3" v-if="imageType == 'image' && profile == true"
                        :src="`${$path.fileBaseUrl()}/student/${applicantInformation.priorityNumber}/${applicantInformation.profileImage}`"
                        max-width="70%" @error="profileError">
                    </v-img>
                    <div class="my-4" v-else-if="imageType == 'none'">
                        <v-icon x-large color="warning darken-1">
                            mdi-alert
                        </v-icon><br>
                        Invalid File
                        <br>
                    </div>
                    <div class="my-4" v-else>
                        <v-icon x-large color="error darken-1">
                            mdi-alert-circle
                        </v-icon><br>
                        File not Found
                        <br>
                    </div>
                    <div class="mx-3">
                        <h5>{{getFullName}}</h5>
                        <h6>{{ applicantInformation.studentType + ' STUDENT' }}</h6>
                        <h5>{{applicantInformation.priorityNumber}}</h5>
                    </div>
                </v-col>
            </v-row>
        </v-card>
        <div class="text--primary mt-6 ml-2">
            <h5 v-if="applicantInformation.educationLevel == 'SENIOR HIGH SCHOOL'">
                <span>SENIOR HIGH SCHOOL : </span> <br>
                {{ applicantInformation.gradeYearLevel }} | {{ applicantInformation.strand != null ? applicantInformation.strand.name: '' }}
            </h5>

            <h5 v-else-if="applicantInformation.educationLevel == 'COLLEGE'">
                <span>COLLEGE : </span> <br>
                {{ applicantInformation.gradeYearLevel }} | {{ applicantInformation.program != null ? applicantInformation.program.name: '' }}
            </h5>

            <h5 v-else-if="applicantInformation.educationLevel == 'OTHERS'">
                <span>OTHERS</span>
                <span v-if="applicantInformation.educationLevel != ''">: <br>
                    {{ applicantInformation.gradeYearLevel }} |
                </span>
                {{ applicantInformation.otherProgram }}
            </h5>

            <h5 v-else-if="applicantInformation.educationLevel == 'GRADUATE SCHOOL'">
                <span>GRADUATE SCHOOL</span>
                <span v-if="applicantInformation.gradeYearLevel != ''">: <br>
                    {{ applicantInformation.gradeYearLevel }} |
                </span>
                {{ applicantInformation.program != null ? applicantInformation.program.name: '' }}
            </h5>

            <h5 v-else>
                {{ applicantInformation.educationLevel }} | {{ applicantInformation.gradeYearLevel }}
            </h5>

            <h5 v-if="applicantInformation.semester!= ''" class="font-weight-regular">
                {{ applicantInformation.semester }} | A.Y. {{ applicantInformation.schoolYear }}
            </h5>
            <h5 v-else>
                A.Y. {{ applicantInformation.schoolYear }}
            </h5>
            <br>
            <h5>
                <span class="font-weight-bold">METHOD OF TEACHING: </span>
                <span class="font-weight-regular">{{ applicantInformation.methodTeaching }}</span>
            </h5>
            <h5 v-if="applicantInformation.learnerReferenceNumber != null">
                <span class="font-weight-bold">LRN:</span>
                <span class="font-weight-regular">{{ applicantInformation.learnerReferenceNumber }}</span>
            </h5>
            <v-divider class="my-3"></v-divider>

            <div>
                <v-dialog v-model="dialog" width="1000"
                    v-if="applicantInformation.voucher != null && applicantInformation.educationLevel == 'SENIOR HIGH SCHOOL'">

                    <template v-slot:activator="{ on, attrs }">
                        <v-btn x-small color="red lighten-2" dark v-bind="attrs" v-on="on">
                            Voucher
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title class="headline primary white--text">
                            Voucher
                        </v-card-title>

                        <v-card-text class="text-center my-4">
                            <v-img v-if="getVoucher.type == 'image' && voucher == true"
                                :src="`${$path.fileBaseUrl()}/student/${applicantInformation.priorityNumber}/${getVoucher.name}`"
                                width="100%" @error="voucherError()"></v-img>
                            <iframe v-else-if="getVoucher.type == 'pdf'"
                                :src="`${$path.fileBaseUrl()}/student/${applicantInformation.priorityNumber}/${getVoucher.name}`"
                                style="width:100%; height:800px;" frameborder="0"></iframe>
                            <div v-else>
                                <v-icon x-large color="error darken-1">
                                    mdi-alert-circle
                                </v-icon><br>
                                File not Found
                                <br>
                            </div>
                        </v-card-text>
                        <hr>
                        <v-card-actions class="justify-end">
                            <v-btn text @click="closeDialog">Close</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
            <br
                v-show="applicantInformation.voucher != null && applicantInformation.educationLevel == 'SENIOR HIGH SCHOOL'">
            <h5>
                <span class="font-weight-bold">REGISTRATION DATE:</span><br>
                <span class="font-weight-regular">{{ $dateFormat.mdy_time(applicantInformation.createdAt) }}</span>
            </h5>
        </div>

        <v-divider class="my-3"></v-divider>

        <v-card-title class="font-weight-bold">
            Enrollment Status
        </v-card-title>

        <v-card-text v-if="getterPartLoading == false">
            <v-row>
                <v-col cols="1" md="1">
                    <span class="green--text font-weight-bold">|</span>
                </v-col>
                <v-col cols="10" md="10">
                    <div class="mb-2 green--text">
                        <span class="font-weight-bold">{{ getStatusGetter.applicantStatus }}</span>
                    </div>
                    <div class="mb-2 caption" v-if="getStatusGetter.remark != null">
                        <span>{{ $transformCase.toSentenceCase(getStatusGetter.remark) }}</span>
                    </div>
                </v-col>
            </v-row>
        </v-card-text>

        <div v-else>
            <center><v-progress-circular :size="80" color="primary" indeterminate></v-progress-circular></center>
        </div>
    </div>

</template>

<script>
    export default {

        props: [
            'applicantInformation',
            'getFullName',
            'getVoucher',
            'getStatusGetter',
            'getterPartLoading',
            'getterErrorMessage',
            'resetPartLoading',
            'getRequirement'
        ],
        data() {
            return {
                dialog: false,
                message: '',
                imageType: '',
                profile: true,
                voucher: true
            }
        },
        methods: {
            closeDialog() {
                this.dialog = false
            },
            profileError() {
                this.profile = false
            },
            voucherError() {
                this.voucher = false
            }
        },
        beforeDestroy() {
            this.resetPartLoading();
        },
        mounted() {
            if (this.getRequirement[0] != null) {
                if (this.getRequirement[0].name == 'PROFILE IMAGE') {
                    this.imageType = this.getRequirement[0].fileType
                } else {
                    this.imageType = null
                }
            } else {
                this.imageType = null
            }
        }
    };

</script>
