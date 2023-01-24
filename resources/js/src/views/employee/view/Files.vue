<template>
    <div class="pa-10">
        <v-row>
            <v-col v-if="employeeData.imageIdFront" cols="6" md="4">
                <v-img
                    :src="`${$path.fileBaseUrl()}/employee/${employeeData.employeeNumber}/${employeeData.imageIdFront}`"
                    class="pa-5 mb-10"
                    :aspect-ratio="2/3"
                    max-height="200"
                ></v-img>
                <div class="text-center" style="font-size: 12px">ID Picture (Front)</div>
            </v-col>
            <v-col v-if="employeeData.imageIdBack" cols="6" md="4">
                <v-img
                    :src="`${$path.fileBaseUrl()}/employee/${employeeData.employeeNumber}/${employeeData.imageIdBack}`"
                    class="pa-5 mb-10"
                    :aspect-ratio="2/3"
                    max-height="200"
                ></v-img>
                <div class="text-center" style="font-size: 12px">ID Picture (Back)</div>
            </v-col>
            <v-col v-if="employeeData.imageSignature" cols="12" md="4">
                <v-img
                    :src="`${$path.fileBaseUrl()}/employee/${employeeData.employeeNumber}/${employeeData.imageSignature}`"
                    class="pa-5 mb-10"
                    :aspect-ratio="2/3"
                    max-height="200"
                ></v-img>
                <div class="text-center" style="font-size: 12px">Signature</div>
            </v-col>
        </v-row>
    </div>
</template>
<script>
    export default {
        props: [
            'employeeData',
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
                        value: 'fileType',
                    },
                ],
                requirement: true,
                files: null
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
        },

    }

</script>
