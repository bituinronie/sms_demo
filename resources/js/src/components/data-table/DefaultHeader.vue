<template>
    <v-row>
        <v-col cols="12" md="3">
            <v-btn v-if="wCreate == true || wCreate == 'reroute'" color="info" class="elevation-0 white--text mt-2 px-2"
                @click="wCreate == true ? buttonFunction('Create') : wCreate == 'reroute' ? reroute():''"
                :disabled="wCreate == true ? getterPageLoading:false">Create
                {{ $router.currentRoute.meta.name }}
            </v-btn>
        </v-col>
        <v-col cols="12" md="5"> </v-col>
        <v-col cols="12" md="4">
            <v-select v-model="listValue" :items="listOption" item-text="listOption" :disabled="getterPageLoading"
                label="Option" @change="changeList()" return-object>
            </v-select>
        </v-col>
    </v-row>
</template>
<script>
    export default {
       props: [
            'list',
            'listChange',
            'listOption',

            'wCreate',
            'buttonFunction',
            'getterPageLoading'
        ],
        data() {
            return {
                listValue: this.list
            }
        },
        methods: {
            changeList() {
                this.$emit('changeListValue', this.listValue)
            }, 
            reroute(){
                this.$router.push({
                    name: 'Create ' + this.$router.currentRoute.meta.name
                })
            }
        },
        watch: {
            list(newValue){ 
                this.listValue = newValue
            }
        }
    }

</script>
