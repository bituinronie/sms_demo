<template>
    <div>
        <v-tabs v-model="tabs" centered>
            <v-tab v-for="item in items" :key="item">
                {{ item }}
            </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tabs">

            <v-tab-item v-if="elementary == true">
                <v-simple-table>
                    <template v-slot:default>
                        <tbody class="caption">
                            <tr>
                                <td width="25%">Name:</td>
                                <td>{{ applicantInformation.elementaryName }}</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>{{ applicantInformation.elementaryAddress }}</td>
                            </tr>
                            <tr>
                                <td>Year Completed:</td>
                                <td>{{ applicantInformation.elementaryYearCompleted }}</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-tab-item>

            <v-tab-item v-if="juniorHigh == true">
                <v-simple-table>
                    <template v-slot:default>
                        <tbody class="caption">
                            <tr>
                                <td width="25%">Name:</td>
                                <td>{{ applicantInformation.juniorHighSchoolName }}</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>{{ applicantInformation.juniorHighSchoolAddress }}</td>
                            </tr>
                            <tr>
                                <td>Year Completed:</td>
                                <td>{{ applicantInformation.juniorHighSchoolYearCompleted }}</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-tab-item>

            <v-tab-item v-if="seniorHigh == true">
                <v-simple-table>
                    <template v-slot:default>
                        <tbody class="caption">
                            <tr>
                                <td width="25%">Name:</td>
                                <td>{{ applicantInformation.seniorHighSchoolName }}</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>{{ applicantInformation.seniorHighSchoolAddress }}</td>
                            </tr>
                            <tr>
                                <td>Year Completed:</td>
                                <td>{{ applicantInformation.seniorHighSchoolYearCompleted }}</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-tab-item>

            <v-tab-item v-if="college == true">
                <v-simple-table>
                    <template v-slot:default>
                        <tbody class="caption">
                            <tr>
                                <td width="25%">Name:</td>
                                <td>{{ applicantInformation.collegeName }}</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>{{ applicantInformation.collegeAddress }}</td>
                            </tr>
                            <tr>
                                <td>Year Completed:</td>
                                <td>{{ applicantInformation.collegeYearCompleted }}</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-tab-item>

            <v-tab-item v-if="previousSchool == true">
                <v-simple-table>
                    <template v-slot:default>
                        <tbody class="caption">
                            <tr>
                                <td width="25%">Name:</td>
                                <td>{{ applicantInformation.previousSchool }}</td>
                            </tr>
                            <tr>
                                <td>Type:</td>
                                <td>{{ applicantInformation.previousSchoolType }}</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>
<script>
    export default {
        props: [
            'applicantInformation',
        ],
        computed: {
            items() {
                let item = []
                if (this.applicantInformation.elementaryName != null && this.applicantInformation
                    .elementaryName !=
                    '') {
                    item.push('ELEMENTARY')
                    this.elementary = true
                }
                if (this.applicantInformation.juniorHighSchoolName != null && this.applicantInformation
                    .juniorHighSchoolName !=
                    '') {
                    item.push('JUNIOR HIGH')
                    this.juniorHigh = true
                }
                if (this.applicantInformation.seniorHighSchoolName != null && this.applicantInformation
                    .seniorHighSchoolName !=
                    '') {
                    this.seniorHigh = true
                    item.push('SENIOR HIGH')
                }
                if (this.applicantInformation.collegeName != null && this.applicantInformation
                    .collegeName !=
                    '') {
                    this.college = true
                    item.push('COLLEGE')
                }
                if (this.applicantInformation.previousSchool != null && this.applicantInformation
                    .previousSchool !=
                    '') {
                    this.previousSchool = true
                    item.push('PREVIOUS SCHOOL')
                }
                return item
            }
        },
        data() {
            return {
                tabs: null,
                elementary: false,
                juniorHigh: false,
                seniorHigh: false,
                college: false,
                previousSchool: false,
            }
        }
    }

</script>
