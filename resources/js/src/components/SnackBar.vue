<template>
    <v-snackbar v-model="snackbar" color="success">
        {{getMessage}}
        <template v-slot:action="{ attrs }">
            <v-btn color="white" text v-bind="attrs" @click="close_snackbar()">
                Close
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script>
    export default {
        props: ['getMessage', 'snackbar'],
        data() {
            return {}
        },
        methods: {
            close_snackbar() {
                this.$emit("update_snackbar", false);
            },
        },
        mounted: function () {
            window.setInterval(() => {
                if (this.snackbar == true) {
                    this.$emit("update_snackbar", false);
                }
            }, 15000)
        },
        beforeDestroy() {
           this.$emit("update_snackbar", false);
        },
    }

</script>
