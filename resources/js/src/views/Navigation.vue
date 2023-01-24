<template>
    <div>
        <v-app-bar color="primary" dark dense flat app>
            <v-app-bar-nav-icon @click="toggleDrawerState()"></v-app-bar-nav-icon>

            <v-toolbar-title style="font-size: 15px">{{
                title
            }}</v-toolbar-title>
        </v-app-bar>

        <v-navigation-drawer :value="drawer" :style="{
                background: $vuetify.theme.dark
                    ? $vuetify.theme.themes.dark.background
                    : $vuetify.theme.themes.light.background,
            }" app>
            <v-list>
                <v-list-item>
                    <v-list-item-action>
                        <v-img max-width="24" src="../images/logo.png"></v-img>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title class="font-weight-bold">SPCF</v-list-item-title>
                        <v-list-item-subtitle style="font-size: 10px">School Management System</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list nav dense>
                <div v-for="(link, i) in links" :key="i">
                    <v-list-item v-if="!link.children" :key="i" :to="{ name: link.to }" exact link>
                        <v-list-item-action>
                            <v-icon>{{ link.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>{{
                                link.text
                            }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-group :prepend-icon="link.icon" no-action v-else :key="i" exact>
                        <template v-slot:activator>
                            <v-list-item-content link>
                                <v-list-item-title>{{
                                    link.text
                                }}</v-list-item-title>
                            </v-list-item-content>
                        </template>

                        <template v-for="(child, i) in link.children">
                            <v-list-item :key="i" v-if="$auth.isStudent() ||
                                    child.rolesWithAccess.includes('ALL_EMPLOYEE') ||
                                    child.rolesWithAccess.includes($auth.auth().accountRole[0])"
                                :to="{ name: child.to }" link exact>
                                <v-list-item-content>
                                    <v-list-item-title>{{
                                        child.text
                                    }}</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                    </v-list-group>
                </div>
            </v-list>

            <template v-slot:append>
                <v-divider></v-divider>
                <div class="pa-5">
                    <v-btn block dense color="error" :loading="logoutLoading" @click="logout()">
                        <v-icon left>mdi-logout</v-icon>
                        Log out
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>
    </div>
</template>

<script>
    import {
        mapGetters,
        mapActions,
        mapState
    } from "vuex";
    export default {
        data: () => ({
            employeeLinks: [{
                    icon: "mdi-view-dashboard",
                    text: "Dashboard",
                    to: "Dashboard",
                    rolesWithAccess: ["ALL_EMPLOYEE"],
                },
                {
                    icon: "mdi-account-edit",
                    text: "Admission",
                    rolesWithAccess: [
                        "ADMIN",
                        "ADMISSION",
                        "INFORMATION TECHNOLOGY SERVICE",
                    ],
                    children: [
                        // {
                        //     text: "Applicant Registration",
                        //     to: "Create Applicant",
                        //     rolesWithAccess: [
                        //         "ADMIN",
                        //         "ADMISSION",
                        //         "INFORMATION TECHNOLOGY SERVICE",
                        //     ],
                        // },
                        {
                            text: "Applicant",
                            to: "Applicant",
                            rolesWithAccess: [
                                "ADMIN",
                                "ADMISSION",
                                "INFORMATION TECHNOLOGY SERVICE",
                            ],
                        },
                    ],
                },
                {
                    icon: "mdi-credit-card",
                    text: "Accounting",
                    rolesWithAccess: ["ADMIN", "ACCOUNTING", "CASHIER", "AUDITOR"],
                    children: [{
                        text: "Proof of Payment",
                        to: "Proof of Payment",
                        rolesWithAccess: [
                            "ADMIN",
                            "ACCOUNTING",
                            "CASHIER",
                            "AUDITOR",
                        ],
                    }, ],
                },
                {
                    icon: "mdi-school",
                    text: "College",
                    rolesWithAccess: ["ADMIN", "DEAN", "FACULTY", "PROGRAM HEAD"],
                    children: [{
                            text: "Subject",
                            to: "Subject (College)",
                            rolesWithAccess: [
                                "ADMIN",
                                "DEAN",
                                "FACULTY",
                                "PROGRAM HEAD",
                            ],
                        },
                        {
                            text: "Program",
                            to: "Program",
                            rolesWithAccess: [
                                "ADMIN",
                                "DEAN",
                                "FACULTY",
                                "PROGRAM HEAD",
                            ],
                        },
                        {
                            text: "Curriculum",
                            to: "Curriculum (College)",
                            rolesWithAccess: [
                                "ADMIN",
                                "DEAN",
                                "FACULTY",
                                "PROGRAM HEAD",
                            ],
                        },
                        {
                            text: "Section",
                            to: "Section (College)",
                            rolesWithAccess: [
                                "ADMIN",
                                "DEAN",
                                "FACULTY",
                                "PROGRAM HEAD",
                            ],
                        },
                        {
                            text: "Schedule",
                            to: "Schedule (College)",
                            rolesWithAccess: [
                                "ADMIN",
                                "DEAN",
                                "FACULTY",
                                "PROGRAM HEAD",
                            ],
                        },
                    ],
                },
                {
                    icon: "mdi-school-outline",
                    text: "Basic Education",
                    rolesWithAccess: ["ADMIN", "BASIC EDUCATION"],
                    children: [{
                            text: "Strand",
                            to: "Strand",
                            rolesWithAccess: ["ADMIN", "BASIC EDUCATION"],
                        },
                        // {
                        //     text: "Curriculum",
                        //     to: "Curriculum (Basic Education)",
                        //     rolesWithAccess: [
                        //         "ADMIN",
                        //         "DEAN",
                        //         "FACULTY",
                        //         "PROGRAM HEAD",
                        //     ],
                        // },
                        // {
                        //     text: "Section",
                        //     to: "Section (Basic Education)",
                        //     rolesWithAccess: [
                        //         "ADMIN",
                        //     ],
                        // },
                    ],
                },
                {
                    icon: "mdi-domain",
                    text: "Facility",
                    rolesWithAccess: ["ADMIN"],
                    children: [{
                            text: "Building",
                            to: "Building",
                            rolesWithAccess: ["ADMIN"],
                        },
                        {
                            text: "Laboratory",
                            to: "Laboratory",
                            rolesWithAccess: ["ADMIN"],
                        },
                        {
                            text: "Room",
                            to: "Room",
                            rolesWithAccess: ["ADMIN"],
                        },
                    ],
                },
                {
                    icon: "mdi-account-group",
                    text: "Human Resources",
                    rolesWithAccess: ["ADMIN", "HUMAN RESOURCE"],
                    children: [{
                            text: "Employee",
                            to: "Employee",
                            rolesWithAccess: ["ADMIN", "HUMAN RESOURCE"],
                        },
                        // {
                        //     text: "Employee Registration",
                        //     to: "Create Employee",
                        //     rolesWithAccess: ["ADMIN", "HUMAN RESOURCE"],
                        // },
                    ],
                },
                {
                    icon: "mdi-cog",
                    text: "System",
                    rolesWithAccess: ["ADMIN"],
                    children: [{
                            text: "Activity Logs",
                            to: "Activity Logs",
                            rolesWithAccess: ["ADMIN"],
                        },
                        {
                            text: "Branch",
                            to: "Branch",
                            rolesWithAccess: ["ADMIN"],
                        },
                        {
                            text: "Department",
                            to: "Department",
                            rolesWithAccess: ["ADMIN"],
                        },
                        {
                            text: "User",
                            to: "User",
                            rolesWithAccess: ["ADMIN"],
                        },
                    ],
                },
                {
                    icon: "mdi-account-circle",
                    text: "Account",
                    rolesWithAccess: ["ALL_EMPLOYEE"],
                    children: [{
                        text: "Change Password",
                        to: "Change Password",
                        rolesWithAccess: ["ALL_EMPLOYEE"],
                    }, ],
                },
            ],
            studentLinks: [{
                    text: "Dashboard",
                    icon: "mdi-view-dashboard",
                    to: "Student Dashboard",
                },
                {
                    text: "Profile",
                    icon: "mdi-face",
                    to: "Student Profile",
                },
                {
                    text: "Payment",
                    icon: "mdi-credit-card",
                    to: "Student Proof of Payment",
                },
                {
                    text: "Account",
                    icon: "mdi-account-circle",
                    children: [{
                        text: "Change Password",
                        to: "Student Change Password",
                    }, ],
                },
            ],
            links: [],
        }),
        computed: {
            ...mapGetters("user", {
                logoutLoading: "getLogoutLoading",
            }),
            ...mapState('ui', {
                drawer: state => state.drawer,
            }),
            title: function () {
                return this.$route.name;
            },
        },
        methods: {
            ...mapActions("user", ["logout"]),
            ...mapActions('ui', ['toggleDrawer']),
            toggleDrawerState: function () {
                this.toggleDrawer()
            }
        },
        mounted: function () {
            if (this.$auth.isEmployee()) {
                let roles = this.$auth.auth().accountRole;
                let that = this;
                this.employeeLinks.map((val, key) => {
                    if (
                        val.rolesWithAccess.includes("ALL_EMPLOYEE") ||
                        val.rolesWithAccess.some(role => roles.includes(role))
                    ) {
                        that.links.push(val);
                    }
                });
            } else if (this.$auth.isStudent()) {
                this.links = this.studentLinks;
            }
        },
    };

</script>

<style lang="scss" scoped>
    .v-list-item--active {
        color: var(--v-primary-base) !important;
    }

    .theme--dark .v-list .v-list-item--active,
    .theme--dark .v-list .v-list-item--active .v-icon {
        color: white !important;
    }

    .v-application .theme--dark .primary--text {
        color: white !important;
    }

</style>
