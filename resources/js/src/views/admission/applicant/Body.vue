<template>
    <div>
        <div class="text-center justify-center py-6 primary">
            <span class="font-weight-bold white--text">
                APPLICANT INFORMATION
            </span>
        </div>
        <v-tabs v-model="tabs" centered>
            <v-tab v-for="item in items" :key="item" active-class="active primary--text">
                {{ item }}
            </v-tab>
        </v-tabs>
        <v-divider class="black"></v-divider>
        <v-tabs-items v-model="tabs" class="custom-font">
            <v-tab-item>
                <div>
                    <PersonalInformation 
                    :applicantInformation="applicantInformation" 
                    :getterPartLoading="getterPartLoading"
                    :getAddress="getAddress" 
                    :email="email" 
                    />
                </div>
            </v-tab-item>
            <v-tab-item>
                <div>
                    <GuardianInformation 
                    :applicantInformation="applicantInformation" />
                </div>
            </v-tab-item>
            <v-tab-item>
                <div>
                    <EducationalBackground 
                    :applicantInformation="applicantInformation" />
                </div>
            </v-tab-item>
            <v-tab-item>
                <div>
                    <Requirements 
                    :getRequirement="getRequirement" 
                    :applicantInformation="applicantInformation" />
                </div>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>
    import "../../../styles/tables/simple_table.css";
    import PersonalInformation from "../applicant/PersonalInformation";
    import GuardianInformation from "../applicant/GuardianInformation";
    import EducationalBackground from "../applicant/EducationalBackground";
    import Requirements from "../applicant/Requirements";

    export default {
        components: {
            PersonalInformation,
            GuardianInformation,
            EducationalBackground,
            Requirements,
        },
        props: [
            'applicantInformation',
            'getAddress',
            'getterPartLoading',
            'getRequirement',
            'email',
        ],
        data() {
            return {
                valid: true,
                tabs: null,
                items: [
                    'PERSONAL INFORMATION', 'FAMILY INFORMATION', 'EDUCATIONAL BACKGROUND',
                    'REQUIREMENTS SUBMITTED'
                ],
            }
        },
    }

</script>
