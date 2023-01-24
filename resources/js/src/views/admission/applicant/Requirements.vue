<template>
    <div>
        <v-data-table :headers="headers" :items="getRequirement" :single-expand="singleExpand" :expanded.sync="expanded"
            item-key="name" show-expand class="elevation-1">

            <template v-slot:[`item.image`]="{ item }">
                <img v-if="item.fileType == 'image'"
                    :src="`${$path.fileBaseUrl()}/student/${applicantInformation.priorityNumber}/${item.img}`"
                    width="20px" max-width="20px">
                <img v-else-if="item.fileType == 'pdf'" :src="`${$path.placeHolderUrl()}/pdf.png`" width="20px"
                    max-width="20px">
                <v-icon v-else-if="item.fileType == 'none'" sm color="warning darken-1">
                    mdi-alert
                </v-icon>
                <img v-else :src="`${$path.placeHolderUrl()}/not_found.png`" width="20px" max-width="20px">
            </template>
            <template v-slot:expanded-item="{ headers, item }">
                <td :colspan="headers.length" height="100%">
                    <center>
                        <v-img v-if="item.fileType == 'image' && requirement == true"
                            :src="`${$path.fileBaseUrl()}/student/${applicantInformation.priorityNumber}/${item.img}`"
                            :max-width="`${$vuetify.breakpoint.width * .8}`" @error="errorImage" @load="loadImage">
                        </v-img>
                        <iframe v-else-if="item.fileType == 'pdf'"
                            :src="`${$path.fileBaseUrl()}/student/${applicantInformation.priorityNumber}/${item.img}`"
                            :width="`${$vuetify.breakpoint.width * .6}`" :height="`${$vuetify.breakpoint.height * .7}`"
                            frameborder="0"></iframe>
                        <div v-else-if="item.fileType == 'none'" class="error--text">
                            Invalid File
                        </div>
                        <div v-else class="error--text">
                            File not Found
                        </div>
                    </center>
                </td>
            </template>
        </v-data-table>
    </div>
</template>
<script>
    export default {
        props: [
            'getRequirement',
            'applicantInformation'
        ],
        data() {
            return {
                dialog: false,
                expanded: [],
                singleExpand: true,
                headers: [{
                        text: 'Image',
                        align: 'start',
                        sortable: false,
                        value: 'image',
                    },
                    {
                        text: 'Description',
                        value: 'name',
                        width: '70%'
                    },
                    {
                        text: 'File Type',
                        value: 'type',
                    },
                ],
                requirement: true
            }
        },
        methods: {
            errorImage() {
                this.requirement = false
            },
            loadImage() {
                this.requirement = true
            }
        },
        watch: {
            expanded() {
                this.requirement = true
            }
        }

    }

</script>
