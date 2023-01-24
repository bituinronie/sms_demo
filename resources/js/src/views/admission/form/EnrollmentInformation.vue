<template>
    <div class="pa-5">
        <v-form ref="form" lazy-validation enctype="multipart/form-data">
            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold">ENROLLMENT INFORMATION</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="6">
                    <v-autocomplete
                        :items="studentTypes"
                        :rules="$rules.required('Student type')"
                        v-model="applicantData.studentType"
                        label="Student Type"
                        outlined
                        dense
                        required
                    ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="6">
                    <v-autocomplete
                        :items="branches"
                        item-text="name"
                        item-value="code"
                        :rules="$rules.required('School branch')"
                        v-model="applicantData.branch"
                        label="School Branch"
                        @change="() => {
                                updateProgramList();
                                updateStrandList();
                                updateGraduateProgramList();
                            }"
                        outlined
                        dense
                        required
                    ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="6">
                    <v-autocomplete
                        :items="methods"
                        :rules="$rules.required('Method of teaching')"
                        v-model="applicantData.methodTeaching"
                        label="Method of Teaching"
                        outlined
                        dense
                        required
                    ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field
                        :rules="$rules.required('School Year')"
                        v-model="applicantData.schoolYear"
                        label="School Year"
                        outlined
                        :suffix="`to ${addYear(applicantData.schoolYear)}`"
                        dense
                        required
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col md="12">
                    <span class="font-weight-bold">STUDENT LEVEL</span>
                    <v-divider class="mt-2"></v-divider>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="4">
                    <v-radio-group v-model="applicantData.educationLevel" :rules="$rules.required('Student level')" required class="mt-0">
                        <v-radio
                            v-for="(level, i) in educationLevels"
                            :key="i"
                            :label="`${i}`"
                            :value="i"
                            class="pb-3"
                            required
                        ></v-radio>
                    </v-radio-group>
                </v-col>
                <v-col cols="12" md="8">
                    <div v-if="applicantData.educationLevel     ==  'PRE-SCHOOL'            || 
                                applicantData.educationLevel    ==  'ELEMENTARY'            ||
                                applicantData.educationLevel    ==  'JUNIOR HIGH SCHOOL'    ||
                                applicantData.educationLevel    ==  'SENIOR HIGH SCHOOL'">
                        <v-text-field
                            label="Learner Reference Number (LRN)"
                            :rules="[...$rules.required('LRN'), ...$rules.length('LRN', 12)]"
                            v-model="applicantData.learnerReferenceNumber"
                            counter="12"
                            type="number"
                            dense
                            outlined
                            required
                        ></v-text-field>
                         <v-autocomplete
                            :items="educationLevels[applicantData.educationLevel]"
                            item-text="numberUpperCase"
                            item-value="numberUpperCase"
                            :rules="$rules.required('Grade level')"
                            v-model="applicantData.gradeYearLevel"
                            label="Grade"
                            outlined
                            required
                            dense
                        ></v-autocomplete>
                        <div v-if="applicantData.educationLevel == 'SENIOR HIGH SCHOOL'">
                            <v-autocomplete
                                :items="strands"
                                item-text="name"
                                item-value="code"
                                :rules="$rules.required('Strand')"
                                v-model="applicantData.strand"
                                label="Strand"
                                outlined
                                required
                                dense
                            ></v-autocomplete>
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-autocomplete
                                        :items="semesters"
                                        :rules="$rules.required('Semester')"
                                        item-text="numberUpperCase"
                                        item-value="numberUpperCase"
                                        v-model="applicantData.semester"
                                        label="Semester"
                                        outlined
                                        required
                                        dense
                                    ></v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="6">
                                     <v-autocomplete
                                        :items="['PUBLIC SCHOOL', 'PRIVATE SCHOOL']"
                                        v-model="applicantData.previousSchoolType"
                                        label="Previous School Type"
                                        outlined
                                        required
                                        dense
                                    ></v-autocomplete>
                                </v-col>
                            </v-row>
                            <v-file-input
                                label="Voucher (.jpg, .png, .pdf)"
                                accept="image/png, image/jpeg, application/pdf"
                                v-model="applicantData.voucher"
                                :rules="$rules.file('Voucher', 'png/jpeg/jpg/pdf')"
                                outlined
                                dense
                            ></v-file-input>
                        </div>
                        
                    </div>
                    
                    <div v-else-if="applicantData.educationLevel    ==  'COLLEGE'             || 
                                    applicantData.educationLevel    ==  'GRADUATE SCHOOL'     ||
                                    applicantData.educationLevel    ==  'OTHERS'">
                        <v-autocomplete
                            :items="this.applicantData.educationLevel == 'COLLEGE' ? programs : graduatePrograms"
                            :rules="$rules.required('Program')"
                            item-text="name"
                            item-value="code"
                            v-model="applicantData.program"
                            label="Program"
                            required
                            outlined
                            dense
                        ></v-autocomplete>
                        <div v-if="applicantData.educationLevel == 'COLLEGE'">
                             <v-autocomplete
                                :items="educationLevels[applicantData.educationLevel]"
                                :rules="$rules.required('Year level')"
                                item-text="numberUpperCase"
                                item-value="numberUpperCase"
                                v-model="applicantData.gradeYearLevel"
                                label="Year"
                                outlined
                                required
                                dense
                            ></v-autocomplete>
                            <v-autocomplete
                                :items="semesters"
                                item-text="numberUpperCase"
                                item-value="numberUpperCase"
                                :rules="$rules.required('Semester')"
                                v-model="applicantData.semester"
                                label="Semester"
                                outlined
                                required
                                dense
                            ></v-autocomplete>
                        </div>
                    </div>
                </v-col>
            </v-row>
             <v-row class="justify-end mr-2 mt-10">
                <v-btn color="primary" @click="validate()" class="mt-5" style="width: 150px">
                    Next
                    <v-icon right>mdi-chevron-right</v-icon>
                </v-btn>
            </v-row>
        </v-form>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations, mapState } from 'vuex'

export default {
    props: ['applicantData'],
    data: () => ({
        // applicantData: {},
        programs: [],
        strands: [],
        graduatePrograms: []
    }),
    computed: {
         ...mapState('formItems', {
            educationLevels: state => state.educationLevels,
            studentTypes: state => state.studentTypes,
            branches: state => state.branches,
            methods: state => state.methods,
            semesters: state => state.semesters,
            // programs: state => state.programs,
            // strands: state => state.strands,
        }),
    },
    methods: {
        validate: function () {
            if (this.$refs.form.validate()) {
                this.$emit('saveEducationLevel', this.applicantData.educationLevel)
                this.$emit('continue', this.applicantData)
            }
        },
        ...mapActions('formItems', [
            'getData',
        ]),
        addYear: function (year) {
            year = parseInt(year)
            if (year > 0) {
                return year + 1;
            }
            return 0;
        },
        updateProgramList: function() {
            if (this.applicantData.branch) {
                this.$axios.get(`admission/applicants/online/${this.applicantData.branch}/undergraduate`)
                    .then(res => {
                        this.programs = res.data.results.program.results
                    })
                    .catch(err => console.error(err.response))
            } else {
                this.programs = {}
            }
        },
        updateStrandList: function() {
            if (this.applicantData.branch) {
                this.$axios.get(`admission/applicants/online/${this.applicantData.branch}`)
                    .then(res => {
                        this.strands = res.data.results.strand.results
                    })
                    .catch(err => console.error(err.response))
            } else {
                this.strands = {}
            }
        },
        updateGraduateProgramList: function() {
            if (this.applicantData.branch) {
                this.$axios.get(`admission/applicants/online/${this.applicantData.branch}/postgraduate`)
                    .then(res => {
                        this.graduatePrograms = res.data.results.program.results
                    })
                    .catch(err => console.error(err.response))
            } else {
                this.graduatePrograms = {}
            }
        },
    },
    mounted: function () {  
        this.getData()
        var today = new Date()
        var month = today.getMonth() + 1
        if (month >= 4) {
            this.applicantData.schoolYear = today.getFullYear()
        } else {
            this.applicantData.schoolYear = today.getFullYear() - 1
        }
        if (this.$route.name == 'Edit Applicant') {
            this.applicantData.schoolYear = (this.applicantData.schoolYear).toString().substring(0,4)
        }
    }
};
</script>
