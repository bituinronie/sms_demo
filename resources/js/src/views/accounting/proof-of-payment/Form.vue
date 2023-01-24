<template>
    <v-dialog :value="dialog" width="800" persistent>
        <v-card>
            <v-card-title class="headline white--text" :class="dialogHeaderColor">
                {{dialogTitle + ' Status'}}
            </v-card-title>

            <v-card-text class="mt-4">
                <span class="my-5" :class="dialogBodyColor" v-if="dialogBody != ''">
                    {{dialogBody + itemsValue.paymentCode + '?'}}
                </span>

                <div :class="inputVisibility">
                    <v-form ref="form" :value="valid" class="mx-3" lazy-validation>
                        <v-text-field v-model="itemsValue.paymentCode" label="Code" readonly persistent-hint>
                        </v-text-field>
                        <v-autocomplete v-model="itemsValue.paymentStatus" :items="paymentStatusList"
                            item-text="paymentStatusList" label="Status" :rules="$rules.required('Status')"
                            @change="itemsValue.paymentStatus != 'PENDING'?itemsValue.remark = null:itemsValue.remark = 'CURRENTLY BEING REVIEWED'"
                            return-object>
                        </v-autocomplete>
                        <v-text-field :class="itemsValue.paymentStatus == 'PENDING'?'hidden':'show'"
                            v-model="itemsValue.remark" label="Remark" :rules="$rules.required('Remark')" clearable
                            @input="changeToUpperCase('remark')">
                        </v-text-field>
                    </v-form>

                    <div v-if="errorStatus == 422 && clearError == false" class="pa-2 white--text error rounded">
                        <span v-for="(value, index) in message" :key="index">
                            {{value}} <br>
                        </span>
                    </div>
                </div>
            </v-card-text>

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
                checkValues: []
            }
        },
    }

</script>
