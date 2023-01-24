<template>
    <v-alert :value="alert" :type="typeValue" transition="slide-x-transition">
        {{alertMessage}}
        <v-btn class="float-right" outlined x-small fab @click="close()">
            <v-icon>mdi-close</v-icon>
        </v-btn>
    </v-alert>
</template>

<script>
    export default {
        props: ['alertMessage', 'alert', 'typeValue'],
        data() {
            return {}
        },
        methods: {
            close() {
                this.$emit("updateAlert", false);
            },
        },
        mounted: function () {
            window.setInterval(() => {
                if (this.alert == true) {
                    this.$emit("updateAlert", false);
                }
            }, 5000)
        },
    }

</script>
