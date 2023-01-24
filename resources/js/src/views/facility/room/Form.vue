<template>
    <v-dialog :value="dialog" width="700" persistent>
        <v-card>
            <v-card-title class="headline white--text" :class="dialogHeaderColor">
                {{ dialogTitle }} {{ this.$route.name }}
            </v-card-title>

            <v-card-text class="mt-4">
                <span class="my-5" :class="dialogBodyColor" v-if="dialogBody != '' && dialogDeleteClass == 'hidden'">
                    {{ dialogBody + itemsValue.name + "?" }}
                </span>

                <div :class="dialogDeleteClass">
                    <span class="error--text my-5" v-if="dialogBody != ''">
                        {{
                            itemsValue.name + " will be permanently deleted in:"
                        }}
                    </span>
                    <h1 class="text-center font-weight-bold mt-4 red--text">
                        {{ countDown }}
                    </h1>
                </div>

                <div :class="inputVisibility">
                    <v-form ref="form" :value="valid" class="mx-3" lazy-validation>
                        <v-autocomplete v-if="user.accountBranchType == 'MAIN'" v-model="branch" :items="branchList.ALL"
                            item-text="name" label="Branch" return-object
                            :clearable="dialogTitle == 'Create' ? true : false"
                            hint="This is not required. This is for filtering of Building and Laboratory only."
                            persistent-hint @change="changeBranch()">
                        </v-autocomplete>
                        <v-autocomplete v-model="building"
                            :items="user.accountBranchType == 'MAIN' ? buildingList[branch!= null ? branch.name:'ALL']:buildingList.ALL"
                            item-text="name" label="Building" :rules="$rules.required('Building')"
                            :loading="buildingList == 'LOADING' ? true : false"
                            :hint="buildingList == 'LOADING'? 'Building List is being downloaded.':''" persistent-hint
                            return-object>
                        </v-autocomplete>
                        <v-text-field v-model="itemsValue.code" label="Code" :rules="$rules.required('Code')"
                            @input="changeToUpperCase('code')">
                        </v-text-field>
                        <v-text-field v-model="itemsValue.name" @input="changeToUpperCase('name')" label="Name"
                            :rules="$rules.required('Name')">
                        </v-text-field>
                        <v-autocomplete v-model="itemsValue.type" :items="roomTypeList" item-text="roomTypeList"
                            label="Type" :rules="$rules.required('Type')" return-object @change="changeType">
                        </v-autocomplete>
                        <v-autocomplete v-model="laboratory"
                            :items="user.accountBranchType == 'MAIN' ? laboratoryList[branch!= null ? branch.name:'ALL']: laboratoryList.ALL"
                            item-text="name" label="Laboratory"
                            :class="itemsValue.type != 'LABORATORY'? 'hidden': 'show'"
                            :rules="itemsValue.type == 'LABORATORY'? $rules.required('Laboratory'): []"
                            @click="changeLab" :loading="laboratoryList == 'LOADING'? true:false"
                            :hint="laboratoryList == 'LOADING'? 'Laboratory List is being downloaded.':''"
                            persistent-hint return-object>
                        </v-autocomplete>
                    </v-form>

                    <div v-if="errorStatus == 422 && clearError == false" class="pa-2 white--text error rounded">
                        <span v-for="(value, index) in message" :key="index">
                            {{ value }} <br />
                        </span>
                    </div>
                </div>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions class="py-4">
                <v-spacer></v-spacer>
                <v-btn :color="dialogHeaderColor == 'error' ? 'warning' : 'error'" depressed @click="cancel()">
                    Cancel
                </v-btn>
                <v-btn :color="dialogHeaderColor" depressed @click="validate()" v-if="dialogDeleteClass == 'hidden'"
                    :loading="
                        buildingList == 'LOADING' && (itemsValue.type == 'LABORATORY' ? laboratoryList == 'LOADING':true)
                            ? true
                            : false
                    ">
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import subMixin from "../../../mixins/subMixin";
    export default {
        mixins: [subMixin],
        data() {
            return {
                branch: null,
                building: null,
                laboratory: null,
                checkValues: [
                    'branch',
                    'laboratory',
                    'building'
                ]
            }
        },
        methods: {
            changeLab() {
                this.laboratory = null;
            },
            changeType() {
                if (this.itemsValue.type == 'LECTURE') {
                    this.laboratory = null;
                }
            }
        }
    };

</script>
