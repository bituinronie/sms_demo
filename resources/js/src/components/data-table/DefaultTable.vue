<template>
    <div>
        <v-data-table :headers="headers" :items="getterPageLoading == false ? itemList:[]"
            class="elevation-0 pointer mt-5 tstyle" :class="getterPageLoading == null ? 'error-table' : getterPageLoading == true ? 'loading-table':''"
            :loading="getterPageLoading" :loading-text="$router.currentRoute.name + ' List is Being Downloaded...'" 
            :no-data-text="getterErrorMessage != null ? getterErrorMessage:''" multi-sort @click:row="redirect">

            <template v-if="$router.currentRoute.name.toUpperCase() == 'PROGRAM'" v-slot:[`item.duration`]="{ item }">
                <span>{{ item.duration + ' YEARS' }}</span>
            </template>

            <template v-slot:[`item.actions`]="{ item }">
                <td v-if="list == 'OFFICIAL LIST'">
                    <div v-if="dataTableButtons.index.includes('button')">
                        <div class="d-inline mx-1" v-if="dataTableButtons.index.includes('reset')">
                             <v-btn depressed color="primary" small @click="buttonFunction('Reset', item), btnClick()">
                                <v-icon left small>
                                    mdi-lock-reset
                                </v-icon>
                                Reset
                            </v-btn>
                        </div>
                        <div class="d-inline mx-1" v-if="dataTableButtons.index.includes('update')">
                             <v-btn depressed color="primary" small @click="buttonFunction('Update', item), btnClick()">
                                <v-icon left small>
                                    mdi-pencil
                                </v-icon>
                                Update
                            </v-btn>
                        </div>
                        <div class="d-inline mx-1" v-if="dataTableButtons.index.includes('archive')">
                            <v-btn depressed color="error" small @click="buttonFunction('Archive', item), btnClick()">
                                <v-icon left small>
                                    mdi-archive
                                </v-icon>
                                Archive
                            </v-btn>
                        </div>
                    </div>
                    <div v-else>
                        <div class="d-inline mx-1" v-if="dataTableButtons.index.includes('reset')">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon dense color="primary" dark v-bind="attrs" v-on="on"
                                        @click="buttonFunction('Reset', item)">
                                        mdi-lock-reset
                                    </v-icon>
                                </template>
                                <span>Reset Password</span>
                            </v-tooltip>
                        </div>
                        <div class="d-inline mx-1" v-if="dataTableButtons.index.includes('update')">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon dense color="primary" dark v-bind="attrs" v-on="on"
                                        @click="buttonFunction('Update', item), btnClick()">
                                        mdi-pencil
                                    </v-icon>
                                </template>
                                <span>Update</span>
                            </v-tooltip>
                        </div>
                        <div class="d-inline mx-1" v-if="dataTableButtons.index.includes('archive')">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon dense color="error" dark v-bind="attrs" v-on="on"
                                        @click="buttonFunction('Archive', item), btnClick()">
                                        mdi-archive
                                    </v-icon>
                                </template>
                                <span>Archive</span>
                            </v-tooltip>
                        </div>
                    </div>
                </td>
               
                <td v-else>

                    <div v-if="dataTableButtons.list.includes('button')">
                        <div class="d-inline mx-1" v-if="dataTableButtons.list.includes('restore')">
                            <v-btn depressed color="primary" small @click="buttonFunction('Restore', item), btnClick()">
                                <v-icon left small>
                                    mdi-restore
                                </v-icon>
                                Restore
                            </v-btn>
                        </div>
                        <div class="d-inline mx-1" v-if="dataTableButtons.list.includes('delete')">
                            <v-btn depressed color="error" small @click="buttonFunction('Delete', item), btnClick()">
                                <v-icon left small>
                                    mdi-delete
                                </v-icon>
                                delete
                            </v-btn>
                        </div>
                    </div>

                    <div v-else>
                        <div class="d-inline mx-1" v-if="dataTableButtons.list.includes('restore')">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon dense color="primary" dark v-bind="attrs" v-on="on"
                                        @click="buttonFunction('Restore', item), btnClick()">
                                        mdi-restore
                                    </v-icon>
                                </template>
                                <span>Restore</span>
                            </v-tooltip>
                        </div>
                        <div class="d-inline mx-1" v-if="dataTableButtons.list.includes('delete')">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon dense color="error" dark v-bind="attrs" v-on="on"
                                        @click="buttonFunction('Delete', item), btnClick()">
                                        mdi-delete
                                    </v-icon>
                                </template>
                                <span>Delete</span>
                            </v-tooltip>
                        </div>
                    </div>
                </td>
            </template>
        </v-data-table>
    </div>
</template>
<script>
    export default {
        props: [
            'list',
            'headers',
            'itemList',
            'buttonFunction',
            'getterPageLoading',
            'getterErrorMessage',

            'redirect',
            'wRedirect',
            'dataTableButtons'
        ],
        methods: {
            btnClick() {
                this.$emit('btnClickValue', true)
            },
        },
    }

</script>
