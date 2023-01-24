<template>
    <v-dialog :value="dialog" width="700" persistent>
        <v-card>
            <v-card-title class="headline white--text" :class="dialogHeaderColor">
                {{dialogTitle + ' Employee'}}
            </v-card-title>

            <v-card-text class="mt-4">
                <span class="my-5" :class="dialogBodyColor" v-if="dialogBody != '' && dialogDeleteClass =='hidden'">
                    {{dialogBody + itemsValue.fullName + '?'}}
                </span>
            </v-card-text>

            <div :class="inputVisibility">
                <br />
                <v-form ref="form" :value="valid" lazy-validation>
                </v-form>

                <div v-if="errorStatus == 422 && clearError == false" class="pa-2 white--text error rounded">
                    <span v-for="(value, index) in message" :key="index">
                        {{value}} <br>
                    </span>
                </div>
            </div>
            <v-divider></v-divider>
            <v-card-actions class="py-4">
                <v-spacer></v-spacer>
                <v-btn :color="dialogHeaderColor == 'error'?'warning':'error'" depressed @click="cancel()">
                    Cancel
                </v-btn>
                <v-btn :color="dialogHeaderColor" depressed @click="validate()" v-if="dialogDeleteClass == 'hidden'"
                    :loading="submitButtonLoading">
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import subMixin from "../../../mixins/subMixin";
    export default {
        mixins: [
            subMixin
        ],
        data() {
            return {
                checkValues: ['noBranch']
            }
        },
    }

</script>
