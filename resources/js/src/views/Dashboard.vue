<template>
    <div>
        <div v-if="$auth.isEmployee()">
            <ApplicantList />
        </div>
        <div v-else-if="$auth.isStudent()">
            student dashboard
        </div>
    </div>

</template>

<script>
    import ApplicantList from './admission/applicant-list/ApplicantList'

    export default {
        components: {
            ApplicantList
        },
    };

</script>
