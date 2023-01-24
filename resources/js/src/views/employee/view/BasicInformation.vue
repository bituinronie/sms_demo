<template>
    <div class="mt-3">
        <v-card class="white--text info" rounded="2" elevation="0">
            <v-row>
                <v-col cols="12" md="12" align="center" justify="center" position="center center">
                    <v-img class=" mx-3 my-3" v-if="employeeData.imageIdFront"
                       :src="`${$path.fileBaseUrl()}/employee/${employeeData.employeeNumber}/${employeeData.imageIdFront}`"
                        max-width="70%">
                    </v-img>
                    <div class="mx-3">
                        <h5>
                            {{ 
                                employeeData.lastName + ', ' + 
                                employeeData.firstName + ' ' + 
                                employeeData.middleName
                            }}
                        </h5>
                        <h5>{{employeeData.employeeNumber}}</h5>
                    </div>
                </v-col>
            </v-row>
        </v-card>
        <div class="text--primary mt-6 ml-2">
            <h5>
                <span class="font-weight-bold">EMPLOYEE TYPE: </span><br>
                <span class="font-weight-regular">{{ employeeData.type }}</span>
            </h5>

            <v-divider class="my-3"></v-divider>
            <h5>
                <span class="font-weight-bold">REGISTRATION DATE:</span><br>
                <span class="font-weight-regular">{{ $dateFormat.mdy_time(employeeData.createdAt) }}</span>
            </h5>
        </div>

    </div>

</template>

<script>
    export default {
        props: [
            'employeeData',
        ]
    };

</script>
