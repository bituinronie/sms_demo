<template>
    <div>
        <v-tabs v-model="tabs" centered>
            <v-tab v-for="item in items" :key="item">
                {{ item }}
            </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tabs">

            <v-tab-item>
                <v-simple-table>
                    <template v-slot:default>
                        <tbody class="caption">
                            <tr>
                                <td width="25%">Full Name:</td>
                                <td>{{ applicantInformation.guardianFullName }}</td>
                            </tr>
                            <tr>
                                <td width="25%">Relationship:</td>
                                <td>{{ applicantInformation.guardianRelationship }}</td>
                            </tr>
                            <tr>
                                <td>Occupation:</td>
                                <td>{{ applicantInformation.guardianOccupation }}</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>{{ applicantInformation.guardianAddress }}</td>
                            </tr>
                            <tr>
                                <td>Contact Number:</td>
                                <td>{{ applicantInformation.guardianContactNumber }}</td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td>{{ applicantInformation.guardianEmail }}</td>
                            </tr>
                            <tr>
                                <td>Average Income:</td>
                                <td>
                                    <span v-if="applicantInformation.parentsOrGuardianAverageIncome != 'OTHER'">
                                        {{ applicantInformation.parentsOrGuardianAverageIncome }}
                                    </span>
                                    <span v-else>
                                        {{ applicantInformation.otherAverageIncome }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-tab-item>

            <v-tab-item v-if="father == true">
                <v-simple-table class="my-3">
                    <template v-slot:default>
                        <tbody class="caption">
                            <tr>
                                <td width="25%">Full Name:</td>
                                <td>{{ applicantInformation.fatherFullName }}</td>
                            </tr>
                            <tr>
                                <td>Occupation:</td>
                                <td>{{ applicantInformation.fatherOccupation }}</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>{{ applicantInformation.fatherAddress }}</td>
                            </tr>
                            <tr>
                                <td>Contact Number:</td>
                                <td>{{ applicantInformation.fatherContactNumber }}</td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td>{{ applicantInformation.fatherEmail }}</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-tab-item>

            <v-tab-item v-if="mother ==true">
                <v-simple-table class="my-3">
                    <template v-slot:default>
                        <tbody class="caption">
                            <tr>
                                <td width="25%">Full Name:</td>
                                <td>{{ applicantInformation.motherFullName }}</td>
                            </tr>
                            <tr>
                                <td>Occupation:</td>
                                <td>{{ applicantInformation.motherOccupation }}</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>{{ applicantInformation.motherAddress }}</td>
                            </tr>
                            <tr>
                                <td>Contact Number:</td>
                                <td>{{ applicantInformation.motherContactNumber }}</td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td>{{ applicantInformation.motherEmail }}</td>
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
            'applicantInformation'
        ],
        computed: {
            items(){
                let item = ['GUARDIAN']
                if(this.applicantInformation.fatherFullName != null && this.applicantInformation.fatherFullName != ''){
                    item.push('FATHER')
                    this.father = true
                }
                if(this.applicantInformation.motherFullName != null && this.applicantInformation.motherFullName != ''){
                    this.mother = true
                    item.push('MOTHER')
                }
                return item
            }
        },
        data() {
            return {
                tabs: null,
                father: false,
                mother: false
            }
        },
        beforeDestroy(){
            this.father = false,
            this.mother = false
        }
    }

</script>
