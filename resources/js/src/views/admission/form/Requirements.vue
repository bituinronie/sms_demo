<template>
    <div class="pa-5">
        <v-form ref="form" lazy-validation enctype="multipart/form-data">
            <v-row>
                <v-col cols="12" md="6" class="d-flex align-end pb-0">
                    <span class="font-weight-bold">REQUIREMENTS</span>
                </v-col>
                <v-col cols="12" md="6"  class="d-flex justify-end pb-0">
                   <span style="font-size: 12px">Upload files in PNG, JPG or PDF format only</span>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="12">
                    <v-divider></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="6" v-for="(requirement, key) in requirements" :key="key">
                    <v-file-input
                        :label="requirement"
                        accept="image/png, image/jpeg, application/pdf"
                        v-model="temp[key]"
                        :rules="$rules.file(requirement, 'png/jpg/jpeg/pdf')"
                        outlined
                        dense
                    ></v-file-input>
                </v-col>
            </v-row>
             <v-row class="justify-end mr-2 mt-10">
                 <v-btn color="primary" @click="$emit('previous')" class="mt-5" style="width: 150px">
                    <v-icon left>mdi-chevron-left</v-icon>
                     Previous
                </v-btn>
                <v-spacer class="hidden-xs"></v-spacer>
                <v-btn color="primary" @click="validate()" class="mt-5" style="width: 150px">
                    Next
                    <v-icon right>mdi-chevron-right</v-icon>
                </v-btn>
            </v-row>
        </v-form>
    </div>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex'
export default {
    props: ['applicantData'],
    data: () => ({
        temp: {}
    }),
    computed: {
        ...mapState('formItems', {
            requirements: state => state.requirements,
        }),
    },
    methods: {
        validate: function () {
            if (this.$refs.form.validate()) {
                if (this.$route.name == 'Edit Applicant') {
                    for (const [key, value] of Object.entries(this.requirements)) {
                        if (this.temp[key]) {
                            this.applicantData[key] = this.temp[key]
                        } else {
                            delete this.applicantData[key]
                        }
                    }
                }
                this.$emit('continue', this.applicantData)    
            }
        },
        toCamelCase: function(string){
            return string.replace(/\s+(.)/g, function (match, group) { 
                return group.toUpperCase()  
            })
        }
    },
};
</script>
