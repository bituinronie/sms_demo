<template>
    <v-container style="height: 100% !important">
        <div v-if="curriculumLoading && !this.curriculum.curriculumState">
            <Loading />
        </div>
        <div v-else>
            <!-- curriculum basic info dialog -->
            <v-dialog v-model="dialogBasicInfo" width="700">
                <template v-slot:default="dialogBasicInfo">
                    <v-card>
                        <v-form ref="basicInfoForm" lazy-validation @submit.prevent="validateBasicInfo()">
                        <v-toolbar color="primary" class="headline" dark
                            >Curriculum Basic Info</v-toolbar
                        >
                        <v-card-text class="mt-6">
                            </v-autocomplete>
                            <v-autocomplete
                                :items="branches"
                                v-model="curriculum.branch"
                                item-text="name"
                                item-value="code"
                                label="Branch"
                                :rules="$rules.required('Branch')"
                                outlined
                                dense
                            />
                            <v-autocomplete
                                :items="departments"
                                v-model="curriculum.department"
                                item-text="name"
                                item-value="code"
                                label="Department"
                                :rules="$rules.required('Department')"
                                outlined
                                dense
                            />
                            <v-autocomplete
                                :items="programs"
                                v-model="curriculum.program"
                                item-text="name"
                                item-value="code"
                                label="Program"
                                :rules="$rules.required('Program')"
                                outlined
                                dense
                            />
                            <v-text-field
                                label="Curriculum Code"
                                v-model="curriculum.code"
                                ref="curriculumCode"
                                :error="codeError"
                                :error-messages="codeErrorMessage"
                                :loading="codeLoading"
                                :rules="$rules.required('Curriculum code')"
                                outlined
                                dense
                                @keyup="validateCurriculumCode"
                            />
                        </v-card-text>
                        <v-card-actions class="justify-end">
                            <v-btn v-if="!isBasicInfoSubmitted" color="error" @click="closeDialog('dialogBasicInfo')"
                                >Exit</v-btn
                            >
                            <v-btn v-else color="error" @click="closeDialog('dialogBasicInfo')"
                                >Cancel</v-btn
                            >
                            <v-btn color="primary" type="submit" @click="validateBasicInfo()" :disabled="codeLoading || codeError"
                                >Submit</v-btn
                            >
                        </v-card-actions>
                        </v-form>
                    </v-card>
                </template>
            </v-dialog>

            <!-- subject form dialog -->
            <v-dialog v-model="dialogSubjectForm" max-width="700px" eager>
                <v-card>
                    <v-form ref="subjectForm" lazy-validation @submit.prevent="dialogAdd ? validateAddSubject() : validateUpdateSubject()">
                    <v-toolbar color="primary" class="headline" dark>
                        {{ dialogAdd ? 'Add Subject' : 'Edit Subject' }}
                    </v-toolbar>
                    <v-card-text class="mt-6">
                        <v-autocomplete
                            :items="dialogAdd ? availableSubjects : subjects"
                            item-text="name"
                            item-value="code"
                            label="Subject"
                            :error-messages="subjectErrorMessage"
                            :error="subjectError"
                            v-model="subjectData.code"
                            outlined
                            :disabled="!dialogAdd"
                            :rules="dialogAdd ? $rules.required('Subject') : []"
                            ref="subject"
                            @change=" e => {
                                subjectErrorMessage = '';
                                filterSubjects(e);
                            }"
                            dense
                        >
                            <template v-slot:item="data">
                                <v-list-item-content>
                                    <v-list-item-title
                                        >{{ data.item.name }}<br
                                    /></v-list-item-title>
                                    <v-list-item-subtitle
                                        style="font-size: 12px"
                                        >{{
                                            data.item.code
                                        }}</v-list-item-subtitle
                                    >
                                </v-list-item-content>
                            </template>
                        </v-autocomplete>
                        <v-autocomplete
                            :items="yearLevels"
                            item-text="numberUpperCase"
                            item-value="letterUpperCase"
                            label="Year Level"
                            v-model="subjectData.yearLevel"
                            outlined
                            dense
                            :rules="$rules.required('Year level')"
                        >
                        </v-autocomplete>
                        <v-autocomplete
                            :items="semesters"
                            item-text="numberUpperCase"
                            item-value="letterUpperCase"
                            label="Semester"
                            v-model="subjectData.semester"
                            outlined
                            dense
                            :rules="$rules.required('Semester')"
                        >
                        </v-autocomplete>
                        <v-text-field
                            label="Alias"
                            v-model="subjectData.alias"
                            outlined
                            dense
                        >
                        </v-text-field>
                        <v-autocomplete
                            :items="filteredSubjects"
                            item-text="name"
                            item-value="code"
                            label="Pre-requisite"
                            v-model="subjectData.prerequisite"
                            outlined
                            dense
                        >
                            <template v-slot:item="data">
                                <v-list-item-content>
                                    <v-list-item-title
                                        >{{ data.item.name
                                        }}<br
                                    /></v-list-item-title>
                                    <v-list-item-subtitle
                                        style="font-size: 12px"
                                        >{{
                                            data.item.code
                                        }}</v-list-item-subtitle
                                    >
                                </v-list-item-content>
                            </template>
                        </v-autocomplete>
                        <v-autocomplete
                            :items="filteredSubjects"
                            item-text="name"
                            item-value="code"
                            label="Co-requisite"
                            v-model="subjectData.corequisite"
                            outlined
                            dense
                        >
                            <template v-slot:item="data">
                                <v-list-item-content>
                                    <v-list-item-title
                                        >{{ data.item.name
                                        }}<br
                                    /></v-list-item-title>
                                    <v-list-item-subtitle
                                        style="font-size: 12px"
                                        >{{
                                            data.item.code
                                        }}</v-list-item-subtitle
                                    >
                                </v-list-item-content>
                            </template>
                        </v-autocomplete>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            @click="closeDialog('dialogSubjectForm')"
                        >
                            Cancel
                        </v-btn>
                        <v-btn
                            color="primary"
                            type="submit"
                        >
                            Submit
                        </v-btn>
                    </v-card-actions>
                    </v-form>
                </v-card>
            </v-dialog>

            <!-- remove subject dialog -->
            <v-dialog v-model="dialogDelete" max-width="700px">
                <v-card>
                    <v-toolbar color="primary" class="headline" dark>
                        Remove subject?
                    </v-toolbar>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            @click="closeDialog('dialogDelete')"
                        >
                            Cancel
                        </v-btn>
                        <v-btn
                            color="primary"
                            @click="deleteSubject()"
                        >
                            Remove
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <div v-if="isBasicInfoSubmitted">
            <v-row>
                <v-col md="10">
                    <span class="font-weight-bold">{{ curriculumCode.toUpperCase() }}</span>
                    <br />
                    <span style="font-size: 12px"
                        >{{ curriculumProgram.name }}</span
                    >
                </v-col>
                <v-col md="2">
                    <div class="d-flex justify-end">
                        <v-tooltip top v-if="!isEditCurriculum">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                color="info"
                                dark
                                v-bind="attrs"
                                v-on="on"
                                style="min-width: 0px !important"
                                @click="dialogBasicInfo = true;"
                                >
                                <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                            </template>
                            <span>Edit Basic info</span>
                        </v-tooltip>
                        <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                color="primary"
                                dark
                                v-bind="attrs"
                                v-on="on"
                                style="min-width: 0px !important"
                                class="ml-2"
                                @click="dialogSubjectForm = true; dialogAdd = true"
                                >
                                <v-icon>mdi-plus-thick</v-icon>
                                </v-btn>
                            </template>
                            <span>Add Subject</span>
                        </v-tooltip>
                    </div>
                </v-col>
            </v-row>
            <v-row><v-divider class="my-2"></v-divider></v-row>
                <div class="pt-5" v-for="(year, i) in yearLevels" :key="i">
                    <v-data-table
                        :hide-default-footer="true"
                        :headers="headers"
                        :items="curriculum.curriculumSubject.filter(val => val.yearLevel == year.letterUpperCase)"
                        item-key="name"
                        group-by="semester"
                        class="elevation-1"
                        dense
                    >
                        <template v-slot:top>
                        <v-toolbar flat dense>
                            <v-toolbar-title>{{ year.numberUpperCase }}</v-toolbar-title>
                        </v-toolbar>
                        </template>
                        <template v-slot:[`item.actions`]="{ item }">
                            <v-icon
                                small
                                class="mr-2"
                                @click="filterSubjects(item.code); dialogEdit = true; dialogSubjectForm = true; subjectData = {...item};"
                            >
                                mdi-pencil
                            </v-icon>
                            <v-icon
                                small
                                @click="dialogDelete = true; subjectData = {...item};"
                            >
                                mdi-delete
                            </v-icon>
                        </template>
                    </v-data-table>
                </div>
                <div class="d-flex mt-10">
                    <v-spacer></v-spacer>
                    <v-btn v-if="isEditCurriculum" color="primary" @click="updateCurriculum(updatedCurriculum)">Update</v-btn>
                    <v-btn v-else color="primary" @click="createCurriculum(curriculum)">Submit</v-btn>
                </div>
            </div>
        </div>
    </v-container>
</template>

<script>
import { mapActions, mapState } from "vuex";
import Loading from "../../../components/Loading";

export default {
    components: { Loading },
    props: {
        branch: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            headers: [
                { text: "Code", value: "code", width: "10%" },
                { text: "Name", value: "name", width: "30%" },
                { text: "Alias", value: "alias", width: "20%" },
                { text: "Pre-requisite", value: "prerequisite", width: "15%" },
                { text: "Co-requisite", value: "corequisite", width: "15%" },
                { text: "Lab Units", value: "laboratoryUnit", width: "10%" },
                { text: "Lecture Units", value: "lectureUnit", width: "10%" },
                { text: "Actions", value: "actions", width: "10%" }
            ],
            curriculum: {
                branch: '',
                department: '',
                code: '',
                program: '',
                type: 'COLLEGE',
                curriculumSubject: []    
            },  
            updatedCurriculum: {},

            curriculumProgram: {
                'name': 'PROGRAM'
            },
            curriculumCode: 'CURRICULUM CODE',
            isBasicInfoSubmitted: false,

            subject: null,
            yearLevel: '',
            semester: '',
            prerequisite: null,
            corequisite: null,
            alias: null,

            subjectData: {
                name: null,
                code: null,
                alias: null,
                prerequisite: null,
                corequisite: null,
                semester: null,
            },
            subjectError: false,
            subjectErrorMessage: null,

            dialogBasicInfo: false,
            dialogSubjectForm: false,
            dialogAdd: false,
            dialogEdit: false,
            dialogDelete: false,

            filteredSubjects: [],
            addedSubjects: [],

            yearLevels: [],

            codeLoading: false,
            codeError: false,
            codeErrorMessage: null,

            isEditCurriculum: false,
        };
    },
    computed: {
        ...mapState("formItems", {
            yearLevelsState: state => state.educationLevels.COLLEGE,
            semesters: state => state.semesters,
            programs: state => state.programs,
            branches: state => state.branches,
            departments: state => state.departments,
        }),
        ...mapState("subject", {
            subjects: state => state.subjects,
            availableSubjects: state => state.availableSubjects
        }),
        ...mapState("curriculum", {
            curriculumState: state => state.curriculum,
            curriculumLoading: state => state.curriculumLoading,
        }),
        
    },
    methods: {
        ...mapActions("subject", ["getSubjects", "removeSubject", "addSubject"]),
        ...mapActions('formItems', ['getDepartments', 'getPrograms', 'getBranches']),
        ...mapActions('curriculum', ['createCurriculum', 'getCurriculum', 'updateCurriculum']),
        validateCurriculumCode: function() {
            this.codeError = false
            this.codeErrorMessage = ''
            if (this.$refs.curriculumCode.valid) {
                this.codeLoading = true
                this.$axios.get('college/curriculums/code/validation', { 
                        params :  { 
                            code: this.curriculum.code, 
                            branch: this.curriculum.branch }
                        }
                    )
                    .then(res => {
                        this.codeLoading = false;
                        this.codeError = false;
                        this.codeErrorMessage = ''
                    })
                    .catch(err => {
                        this.codeLoading = false
                        if (err.response.data.results.code == 'Curriculum code is already in use') {
                            this.codeError = true;
                            this.codeErrorMessage = 'Curriculum code is already in use'
                        }
                    })
            }
            
        },
        validateBasicInfo: function() {
            if(this.$refs.basicInfoForm.validate()) {
                this.dialogBasicInfo = false;
                this.isBasicInfoSubmitted = true;
                this.curriculumCode = this.curriculum.code;
                this.curriculumProgram = this.programs.filter(val => val.code == this.curriculum.program)[0]
                this.yearLevels = this.yearLevelsState.slice(0, this.curriculumProgram.duration)
            }
        },
        validateAddSubject: function() {
            if (this.$refs.subjectForm.validate()) {
                let data = {...this.subjectData}
                let subject = this.subjects.filter(val => val.code == data.code)[0]
                data = {
                    ...data,
                    name: subject.name,
                    laboratoryUnit: subject.laboratoryUnit,
                    lectureUnit: subject.lectureUnit
                }
                
                if (this.isSubjectUnique(data.code)) {
                    if (this.isEditCurriculum) {
                        this.updatedCurriculum.curriculumSubject.deleted = this.updatedCurriculum.curriculumSubject.deleted.filter(val => val.code != data.code)
                        let originalSubjectData = this.curriculumState.curriculumSubject.filter(val => val.code == data.code)[0]
                        if (originalSubjectData) {
                            if (originalSubjectData.alias != data.alias || 
                                originalSubjectData.prerequisite != data.prerequisite || 
                                originalSubjectData.corequisite != data.corequisite || 
                                originalSubjectData.yearLevel != data.yearLevel ||
                                originalSubjectData.semester != data.semester) {
                                    let index = this.updatedCurriculum.curriculumSubject.updated.findIndex(val => val.code == data.code)
                                    if (index != -1) {
                                        this.updatedCurriculum.curriculumSubject.updated[index] = data
                                    } else {
                                        this.updatedCurriculum.curriculumSubject.updated.push(data)
                                    }
                                }
                        } else {
                            this.updatedCurriculum.curriculumSubject.added.push(data)
                        }
                    }
                    this.curriculum.curriculumSubject.push(data);
                    this.removeSubject(data.code);
                    this.$refs.subjectForm.reset()
                    this.closeDialog('dialogSubjectForm')
                } else {
                    this.subjectErrorMessage =
                        "Subject is already in the curriculum";
                    this.subjectError = true;
                }
                
            }
            
        },
        validateUpdateSubject: function() {
            if (this.$refs.subjectForm.validate()) {
                if (this.subjectData && this.subjectData.code) {
                    
                    let data = {...this.subjectData}
                    let subject = this.subjects.filter(val => val.code == data.code)[0]
                    data.name = subject.name,
                    data.laboratoryUnit = subject.laboratoryUnit,
                    data.lectureUnit = subject.lectureUnit
                    
                    if (this.isEditCurriculum) {
                        let originalSubjectData = this.curriculumState.curriculumSubject.filter(val => val.code == data.code)[0]
                        if (originalSubjectData) {
                            if (originalSubjectData.alias !== data.alias ||  
                                originalSubjectData.corequisite !== data.corequisite || 
                                originalSubjectData.yearLevel !== data.yearLevel ||
                                originalSubjectData.semester !== data.semester) {
                                    let updateIndex = this.updatedCurriculum.curriculumSubject.updated.findIndex(val => val.code == data.code)
                                    if (updateIndex != -1) {
                                        this.updatedCurriculum.curriculumSubject.updated[updateIndex] = data
                                    } else {
                                        this.updatedCurriculum.curriculumSubject.updated.push(data)
                                    }
                                }
                        } else {
                            this.updatedCurriculum.curriculumSubject.added = this.updatedCurriculum.curriculumSubject.added.filter(val => val.code != data.code)
                            this.updatedCurriculum.curriculumSubject.added.push(data)
                        }
                    }

                    let index = this.curriculum.curriculumSubject.findIndex(val => val.code == data.code)
                    this.curriculum.curriculumSubject[index] = data
                    this.$refs.subjectForm.reset()
                    this.closeDialog('dialogSubjectForm')
                }
            }
        },
        deleteSubject: function() {
            if (this.subjectData && this.subjectData.code) {
                this.addSubject(this.subjectData.code)
                let data = this.subjectData
                if (this.isEditCurriculum) {
                    let originalSubjectData = this.curriculumState.curriculumSubject.filter(val => val.code == data.code)[0]
                    if (originalSubjectData) {
                        this.updatedCurriculum.curriculumSubject.deleted.push(this.curriculumState.curriculumSubject
                            .filter(val => val.code == data.code)[0])
                    }
                    this.updatedCurriculum.curriculumSubject.added = this.updatedCurriculum.curriculumSubject.added
                        .filter(val => val.code != data.code)
                }
                this.curriculum.curriculumSubject = this.curriculum.curriculumSubject.filter(val => val.code != data.code)
                this.dialogDelete = false
                this.resetSubjectData();
                this.$refs.subjectForm.reset()
            }
        },
        isSubjectUnique: function(subjectCode) {
            if (this.curriculum.curriculumSubject.find(val => val.code == subjectCode)) {
                return false;
            } else {
                return true;
            }
        },
        filterSubjects: function(code) {
            if (code) {
                this.filteredSubjects = this.subjects.filter(
                    subject => subject.code != code
                );
            } else {
                this.filteredSubjects = this.subjects;
            }
        },
        resetSubjectData: function() {
            this.subjectData = {
                name: '',
                code: '',
                alias: '',
                prerequisite: '',
                corequisite: '',
                semester: '',
                yearLevel: ''
            };
        },
        closeDialog: function(dialog) {
            this[dialog] = false
            if (dialog == 'dialogSubjectForm') {
                this.dialogAdd = false
                this.dialogEdit = false
            }
        },
    },
    async mounted() {
        this.getSubjects();
        this.getBranches();
        this.getDepartments();
        this.getPrograms();

        if (this.$route.name == 'Edit Curriculum') {
            this.isEditCurriculum = true
            this.isBasicInfoSubmitted = true

            await this.getCurriculum(this.branch)

            let curriculum = JSON.parse(JSON.stringify(this.curriculumState));
            this.curriculum = JSON.parse(JSON.stringify(curriculum));
            this.curriculumCode = curriculum.code
            this.curriculumProgram = curriculum.program
            this.yearLevels = this.yearLevelsState.slice(0, curriculum.program.duration)

            this.updatedCurriculum = JSON.parse(JSON.stringify(curriculum));
            
            this.updatedCurriculum.curriculumSubject = {
                added: [],
                updated: [],
                deleted: []
            }

            this.curriculum.curriculumSubject.map(val => {
                this.removeSubject(val.code)
            })
        } else {
            this.dialogBasicInfo = true
            this.isEditCurriculum = false
        }
        
    },
    created: function() {
        if (!this.branch && this.$route.name == 'Edit Curriculum') {
            this.$router.go(-1)
        }
    },
    watch: {
        dialogBasicInfo: function (bool) {
            if (!bool && !this.isBasicInfoSubmitted) {
                this.$router.push({name: 'Curriculum'})
            }
        },
    }
};
</script>
