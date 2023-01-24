<template>
    <v-dialog :value="dialog" width="700" persistent>
        <v-card>
            <v-card-title class="headline white--text" :class="dialogHeaderColor">
                {{dialogTitle}} {{this.$route.name}}
            </v-card-title>

            <v-card-text class="mt-4">
                <span class="my-5" :class="dialogBodyColor" v-if="dialogBody != '' && dialogDeleteClass =='hidden'">
                    {{dialogBody + itemsValue.name + '?'}}
                </span>

                <div :class="dialogDeleteClass">
                    <span class="error--text my-5" v-if="dialogBody != ''">
                        {{itemsValue.name + ' will be permanently deleted in:'}}
                    </span>
                    <h1 class="text-center font-weight-bold mt-4 red--text">{{countDown}}</h1>
                </div>

                <div :class="inputVisibility">
                    <v-form ref="form" :value="valid" class="mx-3" lazy-validation>
                        <v-autocomplete v-model="branch" :items="branchList.ALL" item-text="name" label="Branch"
                            :rules="$rules.required('Branch')" :class="branchVisibility" @change="changeBranch()"
                            return-object>
                        </v-autocomplete>
                        <v-text-field v-model="itemsValue.code" label="Code" :rules="$rules.required('Code')"
                            @input="changeToUpperCase('code')">
                        </v-text-field>
                        <v-text-field v-model="itemsValue.name" @input="changeToUpperCase('name')" label="Name"
                            :rules="$rules.required('Name')">
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
                branch: null,
                checkValues: ['branch']
            }
        },
    }

</script>
