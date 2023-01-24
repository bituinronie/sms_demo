<template>
    <div class="pa-5">
        <v-form ref="form" lazy-validation enctype="multipart/form-data">
            <v-row>
                <v-col cols="12" md="6" offset-md="3">
                    <v-img
                        :src="imageUrl"
                        class="pa-5 mb-10"
                        :aspect-ratio="1"
                    ></v-img>
                    <v-file-input
                        label="Your Image with White Background"
                        :rules="
                            $route.name == 'Edit Applicant'
                                ? []
                                : [
                                      ...$rules.required(
                                          'Your image with white background'
                                      ),
                                      ...$rules.file(
                                          'Your image with white background',
                                          'png/jpeg/jpg'
                                      )
                                  ]
                        "
                        accept="image/jpeg, image/png"
                        v-model="applicantImage"
                        outlined
                        dense
                        @change="onFileChange"
                    ></v-file-input>
                </v-col>
            </v-row>
            <div v-if="applicantError">
                <v-alert
                    v-for="(error, i) in applicantError"
                    :key="i"
                    type="error"
                    text
                >
                    {{ error }}
                </v-alert>
            </div>
            <v-row class="justify-end mx-2 mt-5">
                <v-btn
                    color="primary"
                    @click="$emit('previous')"
                    class="mt-5"
                    style="width: 150px"
                >
                    <v-icon left>mdi-chevron-left</v-icon>
                    Previous
                </v-btn>
                <v-spacer class="hidden-xs"></v-spacer>
                <v-btn
                    color="accent"
                    @click="validate()"
                    class="mt-5"
                    style="width: 150px"
                    :loading="submitLoading"
                >
                    Submit
                </v-btn>
            </v-row>
        </v-form>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    props: ["applicantData"],
    data: () => ({
        applicantImage: "",
        imageUrl: "../images/img-placeholder.png",
        temp: {}
    }),
    computed: {
        ...mapGetters("applicant", {
            submitLoading: "getSubmitLoading",
            applicantError: "getApplicantError"
        })
    },
    methods: {
        validate: function() {
            if (this.$refs.form.validate()) {
                this.applicantData.profileImage = this.applicantImage;
                if (
                    this.$route.name == "Edit Applicant" &&
                    !this.applicantImage
                ) {
                    delete this.applicantImage.profileImage;
                }
                this.$emit("submitForm", this.applicantData);
            }
        },
        onFileChange: function(e) {
            this.imageUrl = URL.createObjectURL(this.applicantImage);
        }
    },
    mounted: function() {
        if (this.$route.name == "Edit Applicant") {
            if (this.applicantData.profileImage) {
                if (this.$path.isLocal()) {
                    this.imageUrl = `/storage/student/${this.applicantData.priorityNumber}/requirement/${this.applicantData.profileImage}`
                } else {
                    this.imageUrl = `${this.$path.fileBaseUrl()}/student/${this.applicantData.priorityNumber}/requirement/${this.applicantData.profileImage}`;
                }
            }
        }
    }
};
</script>
