<template>
    <v-container style="height: 100% !important">
        <v-row>
            <v-col md="12">
                <span class="font-weight-bold">CCIS1A</span>
                <br>
                <span style="font-size: 12px">BACHELOR OF SCIENCE IN COMPUTER SCIENCE</span>
                <v-divider class="my-2"></v-divider>   
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="8" md="8">
                <v-autocomplete
                    :items="subjects"
                    item-text="name"
                    item-value="id"
                    label="Subject"
                    v-model="subject"
                    outlined
                    @change="subjectAddingError = ''"
                    dense
                >
                    <template v-slot:item="data">
                        <v-list-tile-content>
                            <v-list-tile-title>{{data.item.name}}<br></v-list-tile-title>
                            <v-list-tile-sub-title style="font-size: 12px">{{data.item.code}}</v-list-tile-sub-title>
                        </v-list-tile-content>
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
        </v-row>
        <div class="pt-5">
            <v-data-table
                :hide-default-footer="true"
                :headers="headers"
                :items="section.subjects"
                item-key="name"
                class="elevation-1"
                show-select
            ></v-data-table>
        </div>
        
    </v-container>
</template>

<script>
import { mapState } from 'vuex'
export default {
    data() {
        return {
            subjects: [
                {
                    'id': 1,
                    'name': 'Fundamentals in Programming',
                    'code': 'PROG1'
                }
            ],
            subject: '',
            section: {
                subjects: []
            },
            headers: [
                { text: 'Code', value: 'code', width: '10%' },
                { text: 'Name', value: 'name', width: '30%' },
                { text: 'Pre-requisite', value: 'prerequisite', width: '20%' },
                { text: 'Units', value: 'units', width: '10%' },
                { text: 'Room', value: 'room', width: '10%' },
                { text: 'Instructor', value: 'instructor', width: '20%' },
            ],
            subjectAddingError: ''
        }
    },
    methods: {
        addSubject: function () {
            const subject = this.subjects.find(x => x.id = this.subject)
            
            if (this.section.subjects && this.section.subjects.includes(subject)) {
                this.subjectAddingError = 'Subject is already in the section'
            } else {
                this.section.subjects.push(subject)     
            }
            
        },
    },
}

</script>