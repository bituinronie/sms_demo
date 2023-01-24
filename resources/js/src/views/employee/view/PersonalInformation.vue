<template>
    <v-simple-table>
        <template v-slot:default>
            <tbody class="caption">
                <tr>
                    <td width="25%">Birthday:</td>
                    <td>{{ $dateFormat.mdy(employeeData.birthDate) }} </td>
                </tr>
                <tr>
                    <td>Birthplace:</td>
                    <td>{{ employeeData.birthPlace }}</td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td>{{ employeeData.gender }}</td>
                </tr>
                <tr>
                    <td>Civil Status:</td>
                    <td>{{ employeeData.civilStatus }}</td>
                </tr>
                <tr>
                    <td>Nationality:</td>
                    <td>{{ employeeData.nationality }}</td>
                </tr>
                <tr>
                    <td>Religion:</td>
                    <td>{{ employeeData.religion }}</td>
                </tr>
                <tr>
                    <td>Current Address:</td>
                    <td>
                        {{ 
                            employeeData.currentAddressHouseNumber + ' ' +
                            employeeData.currentAddressStreetName + ', ' +
                            employeeData.currentAddressBarangay + ', ' +
                            employeeData.currentAddressCity + ', ' +
                            employeeData.currentAddressProvince + ' ' +
                            employeeData.currentAddressZipCode 
                        }}
                    </td>
                </tr>
                <tr>
                    <td>Permanent Address:</td>
                    <td>
                        {{ 
                            employeeData.permanentAddressHouseNumber + ' ' +
                            employeeData.permanentAddressStreetName + ', ' +
                            employeeData.permanentAddressBarangay + ', ' +
                            employeeData.permanentAddressCity + ', ' +
                            employeeData.permanentAddressProvince + ' ' +
                            employeeData.permanentAddressZipCode 
                        }}
                    </td>
                </tr>
                <tr>
                    <td>Mobile Number:</td>
                    <td>{{ '+63'+employeeData.mobileNumber }}</td>
                </tr>
                <tr>
                    <td>Email Adress:</td>
                    <td>{{ employeeData.emailAddress }}</td>
                </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>

<script>
    export default {
        props: [
            'employeeData',
        ],
        data() {
            return {

            }
        },
    };

</script>
<style scoped>
    .hidden {
        display: none;
    }

    .show {
        display: block;
    }

</style>
