<template>
    <v-container>
        <v-row style="height: 200px"></v-row>
        <v-row class="mt-16">
            <v-col cols="12" md="6" offset-md="3" class="text-center">
                <v-progress-circular v-if="value == false" :size="100" color="primary" indeterminate>
                </v-progress-circular>
                <span v-else class="error--text">
                    <h2>Loading of Data Have Taken too Long.</h2>
                    Kindly refresh your browser first.
                    <br>
                    If error persists Log-out and Log-in again.
                    <br>
                    <br>
                    If nothing changes please contact risseu@spcf.edu.ph
                </span>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                value: false,
            }
        },
        mounted() {
            setTimeout(() => {
                this.value = true
            }, 120000)
        },
        beforeDestroy() {
            this.value = false
        }
    }

</script>
