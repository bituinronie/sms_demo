<template>
    <v-app :style="{background: $vuetify.theme.dark ?  $vuetify.theme.themes.dark.background :  $vuetify.theme.themes.light.background}">
        <div v-if="$auth.isEmployee() || $auth.isStudent()">
            <Navigation />
        </div>
        <v-main class="pb-16">
            <v-container 
                class="py-8 px-6" 
                style="height: 100%" 
                fluid  
            >
                <router-view></router-view>
                <v-fab-transition>
                    <v-btn
                        :color="$vuetify.theme.dark ? $vuetify.theme.themes.light.background :  $vuetify.theme.themes.dark.background"
                        dark
                        fixed
                        bottom
                        right
                        fab
                        dense
                        :retain-focus-on-click="false"
                        @click="toggleDarkModeState"
                    >
                        <v-icon 
                            :color="$vuetify.theme.dark ? $vuetify.theme.themes.dark.background :  $vuetify.theme.themes.light.background"
                        >
                            {{ $vuetify.theme.dark ? 'mdi-weather-sunny' : 'mdi-weather-night' }}
                        </v-icon>
                    </v-btn>
                </v-fab-transition>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
    import {
      mapActions,
        mapGetters,
        mapState
    } from 'vuex';
    import Navigation from './Navigation'

    export default {
        components: {
            Navigation
        },
        computed: {
            ...mapGetters('user', {
                user: 'getUser'
            }),
            ...mapState('ui', {
                darkMode: state => state.darkMode,
            })
        }, 
        methods: {
            ...mapActions('ui', [ 'toggleDarkMode' ]),
            toggleDarkModeState: function (e) {
                this.$vuetify.theme.dark = !this.$vuetify.theme.dark
                this.toggleDarkMode()
                e.target.blur()
            },
        },
        mounted: function () {
            this.$vuetify.theme.dark = this.darkMode;
            if (!this.$auth.auth()) {
                this.$router.push({name: 'Landing Page'})
            }
        }
    }

</script>

<style lang="scss">
    @import url("https://fonts.googleapis.com/css?family=Inter");

    $font-family: "Inter";

    .v-application {
        [class*="text-"] {
            font-family: $font-family, sans-serif !important;
        }

        span {
            font-family: $font-family, sans-serif !important;
        }

        .caption {
            font-family: $font-family, sans-serif !important;
        }

        font-family: $font-family,
        sans-serif !important;
    }

    .v-navigation-drawer.theme--dark,
    .v-sheet.theme--dark,
    .theme--dark.v-tabs>.v-tabs-bar {
        background: #2C2F33 !important;
    }

    .v-data-table.theme--dark,
    .theme--dark.v-tabs-items,
    .theme--dark.v-expansion-panels .v-expansion-panel  {
        background: #36393F !important;
    }

    .theme--dark.v-data-table tbody tr.v-data-table__selected {
        background: #424549 !important;
    }

    .v-data-table {
        padding: 10px;
    }

    .v-data-table-header th {
        white-space: nowrap;
    }

    .v-btn:not(.v-btn--round):not(.v-btn--block).v-size--default {
        min-width: 150px !important;
    }

    .v-btn.v-btn--fab:hover:before {
        opacity: 0 !important;
    }

    .custom-font {
        font-family: $font-family, sans-serif !important;
    }

    table tr td {
        font-family: $font-family, sans-serif !important;
    }

    ::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
