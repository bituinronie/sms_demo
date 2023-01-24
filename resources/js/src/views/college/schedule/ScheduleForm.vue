<template>
    <v-container style="height: 100% !important">

        <!-- subject form dialog -->
        <v-dialog v-model="dialogSubjectForm" max-width="700px" eager>
            <v-card>
                <v-form ref="subjectForm" lazy-validation @submit.prevent="addSubject ? validateAddSubject() : validateUpdateSubject()">
                <v-toolbar color="primary" class="headline" dark>
                    {{ addSubject ? 'Add Subject' : 'Edit Subject' }}
                </v-toolbar>
                <v-card-text class="mt-6">
                    <v-autocomplete
                        :items="addSubject ? availableSubjects : subjects"
                        item-text="name"
                        item-value="code"
                        label="Subject"
                        :error-messages="subjectErrorMessage"
                        :error="subjectError"
                        v-model="subjectData.code"
                        outlined
                        :disabled="!addSubject"
                        :rules="addSubject ? $rules.required('Subject') : []"
                        ref="subject"
                        @change=" e => {
                            subjectErrorMessage = '';
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
                        :items="employees"
                        :item-text="item => item.middleName ? item.firstName + ' ' + item.middleName + ' ' + item.lastName : item.firstName + ' ' + item.lastName"
                        item-value="employeeNumber"
                        label="Instructor"
                        v-model="subjectData.employee"
                        outlined
                        dense
                    >
                        <template v-slot:item="data">
                            <v-list-item-content>
                                <v-list-item-title
                                    >{{ fullName(data.item) }}<br
                                /></v-list-item-title>
                                <v-list-item-subtitle
                                    style="font-size: 12px"
                                    >{{
                                        data.item.employeeNumber
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

        <!-- schedule form dialog -->
        <v-dialog v-model="dialogScheduleForm" max-width="700px" eager>
            <v-card>
                <v-form ref="scheduleForm" lazy-validation @submit.prevent="addSchedule ? validateAddSchedule() : validateUpdateSchedule()">
                <v-toolbar color="primary" class="headline" dark>
                    {{ addSchedule ? 'Add Schedule' : 'Edit Schedule' }}
                </v-toolbar>
                <v-card-text class="mt-6">
                    <v-layout row wrap class="mb-5">
                        <v-checkbox
                            :disabled="editSchedule"
                            v-for="(day, i) in days" :key="i"
                            v-model="selectedDays"
                            :label="day.shortcut"
                            :value="day.name"
                            class="mx-3"
                        ></v-checkbox>
                    </v-layout>
                    <v-row>
                        <v-col cols="6">
                            <v-text-field
                                label="Time Start"
                                v-model="scheduleData.timeStart"
                                outlined
                                dense
                                type="time"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                label="Time End"
                                v-model="scheduleData.timeEnd"
                                outlined
                                dense
                                type="time"
                            ></v-text-field> 
                        </v-col>
                    </v-row>
                    <v-autocomplete
                        :items="rooms.concat(laboratories)"
                        item-text="name"
                        item-value="code"
                        label="Room/Laboratory"
                        v-model="scheduleData.room"
                        outlined
                        dense
                    >
                    </v-autocomplete>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        @click="closeDialog('dialogScheduleForm')"
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
        <v-dialog v-model="dialogRemoveSubject" max-width="700px">
            <v-card>
                <v-toolbar color="primary" class="headline" dark>
                    Remove subject?
                </v-toolbar>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        @click="closeDialog('removeSubject')"
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

        <!-- remove subject dialog -->
        <v-dialog v-model="dialogRemoveSchedule" max-width="700px">
            <v-card>
                <v-toolbar color="primary" class="headline" dark>
                    Remove schedule?
                </v-toolbar>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        @click="closeDialog('removeSchedule')"
                    >
                        Cancel
                    </v-btn>
                    <v-btn
                        color="primary"
                        @click="deleteSchedule()"
                    >
                        Remove
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-row>
            <v-col md="10">
                <span class="font-weight-bold">SECTION NAME</span>
                <br />
                <span style="font-size: 12px"
                    >COURSE</span
                >
            </v-col>
            <v-col md="2">
                <div class="d-flex justify-end">
                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                            color="primary"
                            dark
                            v-bind="attrs"
                            v-on="on"
                            style="min-width: 0px !important"
                            class="ml-2"
                            @click="addSubject = true; openDialog('dialogSubjectForm')"
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
        <!-- <v-row>
            <v-col cols="8" md="8">
                <v-autocomplete
                        :items="addSubject ? availableSubjects : subjects"
                        item-text="name"
                        item-value="code"
                        label="Subject"
                        :error-messages="subjectErrorMessage"
                        :error="subjectError"
                        v-model="subjectData.code"
                        outlined
                        :disabled="!addSubject"
                        :rules="addSubject ? $rules.required('Subject') : []"
                        ref="subject"
                        @change=" e => {
                            subjectErrorMessage = '';
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
            </v-col>
            <v-col cols="4" md="4">
                 <v-btn
                    color="primary"
                    block
                    @click="addSubject"
                >
                    Add Subject
                </v-btn>
                <div style="font-size: 12px; color: red; text-align: center" class="mt-1">{{ this.subjectAddingError }}</div>
            </v-col>
        </v-row> -->
        <div class="pt-5">
            <v-data-table
                :hide-default-footer="true"
                :headers="headers"
                :items="section.schedule"
                item-key="subject"
                class="elevation-1"
                show-expand
                :expanded.sync="expanded"
            >   
                <template v-slot:[`item.employeeName`]="{ item }">{{ fullName(employees.filter(val => val.employeeNumber == item.employee)[0]) }}</template>
                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="subjectData = item; addSchedule = true; openDialog('dialogScheduleForm')"
                    >
                        mdi-plus-thick
                    </v-icon>
                    <v-icon
                        small
                        class="mr-2"
                        @click="subjectData = item; editSubject = true; openDialog('dialogSubjectForm')"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        small
                        @click="subjectData = item; openDialog('dialogRemoveSubject')"
                    >
                        mdi-delete
                    </v-icon>
                </template>
                <template v-slot:expanded-item="{ headers, item }">
                    <td :colspan="headers.length">
                        <v-data-table
                            :hide-default-footer="true"
                            :headers="scheduleHeaders"
                            :items="item.subjectSchedule"
                            :item-key="item => item.subject"
                            class="my-5"
                        >
                            <template v-slot:[`item.schedule`]="{ item }">{{ item.timeStart }} to {{ item.timeEnd }}</template>
                            <template v-slot:[`item.actions`]="{ item }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="scheduleData = item; 
                                            editSchedule = true; 
                                            selectedDays.push(item.day); 
                                            openDialog('dialogScheduleForm')"
                                >
                                    mdi-pencil
                                </v-icon>
                                <v-icon
                                    small
                                    @click="scheduleData = item; openDialog('dialogRemoveSchedule')"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>
                        </v-data-table>
                    </td>
                </template>
            </v-data-table>
        </div>
        
    </v-container>
</template>

<script>
import { mapActions, mapState } from 'vuex'
export default {
    data() {
        return {
            subjectData: {},
            scheduleData: {},
            section: {
                schedule: [
                    {
                        "subject" : "PROG1_L",
                        "name": "FUNDAMENTALS OF PROGRAMMING",
                        "laboratoryUnit": 2,
                        "lectureUnit": 1,
                        "employee": "03-26-0002",
                        "subjectSchedule": [
                            {
                                "room"      : "RVJ101",
                                "day"       : "MONDAY",
                                "timeStart" : "07:00",
                                "timeEnd"   : "08:00"
                            },
                            {
                                "room"      : "RVJ101",
                                "day"       : "TUESDAY",
                                "timeStart" : "07:00",
                                "timeEnd"   : "08:00"
                            }
                        ]

                    },
                ]
            },
            headers: [
                { text: 'Subject', value: 'subject', width: '15%' },
                { text: 'Name', value: 'name', width: '35%' },
                { text: 'Units', value: 'units', width: '5%' },
                { text: 'Instructor', value: 'employeeName', width: '30%' },
                { text: 'Actions', value: 'actions', width: '15%' },
            ],
            scheduleHeaders: [
                { text: 'Day', value: 'day', width: '30%' },
                { text: 'Schedule', value: 'schedule', width: '30%' },
                { text: 'Room', value: 'room', width: '30%' },
                { text: 'Actions', value: 'actions', width: '10%' }
            ],
            subjectAddingError: '',
            subjectError: false,
            subjectErrorMessage: '',

            dialogSubjectForm: false,
            dialogScheduleForm: false,
            dialogRemoveSubject: false,
            dialogRemoveSchedule: false,

            addSubject: false,
            editSubject: false,
            addSchedule: false,
            editSchedule: false,

            expanded: [],

            selectedDays: [],
        }
    },
    computed: {
        ...mapState('subject', {
            subjects: state => state.subjects,
            availableSubjects: state => state.availableSubjects,
        }),
        ...mapState('employee', {
            employees: state => state.employees
        }),
        ...mapState('formItems', {
            days: state => state.days
        }),
        ...mapState('facility', {
            rooms: state => state.rooms,
            laboratories: state => state.laboratories
        })
    },
    methods: {
        ...mapActions('subject', ['getSubjects']),
        ...mapActions('employee', ['getEmployees']),
        ...mapActions('facility', ['getRooms', 'getLaboratories']),
        validateAddSubject: function () {
            let subject = this.subjects.find(x => x.code == this.subjectData.code)
            let data = {
                subject: subject.code,
                name: subject.name,
                units: subject.laboratoryUnit + subject.lectureUnit,
                employee: this.subjectData.employee
            }
            if (this.section.schedule && this.section.schedule.find(x => x.subject == data.code)) {
                this.subjectError = true
                this.subjectErrorMessage = 'Subject is already in the curriculum'
            } else {
                this.section.schedule.push(data)     
            } 
        },
        validateAddSchedule: function() {
            let days = this.selectedDays
            let data = this.scheduleData
            // days.map(val => {
            //     this.section.schedule.
            // })
        },
        validateUpdateSchedule: function() {

        },
        closeDialog: function(dialog) {
            this[dialog] = false
            this.addSubject = false
            this.editSubject = false
            this.addSchedule = false
            this.editSchedule = false
            this.selectedDays = []
        },
        openDialog: function(dialog) {
            this[dialog] = true
        },
        fullName: function(data) {
            let name = ''
            if (data) {
                if (data.middleName) {
                    name = data.firstName + ' ' + data.middleName + ' ' + data.lastName
                } else {
                    name = data.firstName + ' ' + data.lastName
                }
            }
            return name
        }
    },
    mounted: function() {
        this.getSubjects()
        this.getEmployees()
        this.getRooms()
        this.getLaboratories()
    },
}

</script>

<style>
    td:first-child {
        font-weight: 500 !important;
    }
</style>
