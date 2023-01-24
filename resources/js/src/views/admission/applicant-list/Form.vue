<template>
    <v-dialog :value="dialog" width="700" persistent>
        <v-card>
            <v-card-title class="headline white--text" :class="dialogHeaderColor">
                {{dialogTitle}}
            </v-card-title>

            <v-card-text class="mt-4">
                <span class="my-5" :class="dialogBodyColor" v-if="dialogBody != '' && dialogDeleteClass =='hidden'">
                    {{dialogBody + nameValue + '?'}}
                </span>

                <div :class="dialogDeleteClass">
                    <span class="error--text my-5" v-if="dialogBody != ''">
                        {{nameValue + ' will be permanently deleted in:'}}
                    </span>
                    <h1 class="text-center font-weight-bold mt-4 red--text">{{countDown}}</h1>
                </div>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions class="py-4">
                <v-spacer></v-spacer>
                <v-btn :color="dialogTitle != 'Delete'?'error':'warning'" depressed @click="cancel()">
                    Cancel
                </v-btn>
                <v-btn :color="dialogTitle == 'Delete'?'error':'primary'" depressed @click="validate()" v-if="dialogDeleteClass == 'hidden'">
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import {
        mapActions,
        mapState
    } from 'vuex'

    export default {
        props: [
            'dialog',
            'dialogTitle',
            'items',
            'resetPageLoading',
            'durationStateList',
            'statusStateList'
        ],
        data() {
            return {
                search: '',
                valid: false,
                nameValue: '',
                priorityNumber: '',
                dialogBody: '',
                dialogBodyColor: '',
                dialogHeaderColor: '',
                function: '',
                countDown: 5,
                cancelCountDown: true,
                dialogDeleteClass: 'hidden',
            }
        },
        methods: {
            ...mapActions('applicantList', [
                'changeData'
            ]),
            cancel() {
                this.dialogDeleteClass = 'hidden'
                this.cancelCountDown = true
                this.countDown = 5
                this.$emit("closeDialog", false)
            },
            validate() {
                let data = {
                    id: this.priorityNumber,
                    function: this.function
                }

                switch (this.function) {
                    case 'Restore':
                        this.$emit("closeDialog", false)
                        this.changeData(data)
                        break;
                    case 'Delete':
                        this.$emit("closeDialog", true)
                        this.dialogDeleteClass = 'show'
                        this.cancelCountDown = false
                        this.countDownTimer(data)
                        break;
                    default:
                        break;
                }
            },
            countDownTimer(data) {
                if (this.cancelCountDown == false) {
                    if (this.countDown > 0) {
                        setTimeout(() => {
                            this.countDown -= 1
                            this.countDownTimer(data)
                        }, 1000)
                    }
                }
                if (this.countDown == 0) {
                    this.changeData(data)
                    this.$emit("closeDialog", false)
                    this.dialogDeleteClass = 'hidden'
                    this.dialogDelete = false
                    this.cancelCountDown = true
                    this.countDown = 5
                }
            },
        },
        watch: {
            dialogTitle(newValue) {
                this.function = newValue
                switch (newValue) {
                    case 'Restore':
                        this.dialogBody = 'Are you sure you want to restore '
                        this.dialogBodyColor = 'primary--text'
                        this.dialogHeaderColor = 'primary'
                        this.inputVisibility = 'hidden'
                        break
                    case 'Delete':
                        this.dialogBody = 'Are you sure you want to permanently delete '
                        this.dialogBodyColor = 'error--text'
                        this.dialogHeaderColor = 'error'
                        this.inputVisibility = 'hidden'
                        break
                    default:
                        break;
                }
            },
            items(newValue) {
                if (newValue != null) {
                    this.nameValue = newValue.fullName
                    this.priorityNumber = newValue.priorityNumber
                }
            }
        },
    }

</script>
<style scoped>
    .hidden {
        display: none;
    }

    .show {
        display: block;
    }

</style>
