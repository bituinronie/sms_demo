import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

import colors from 'vuetify/lib/util/colors'

Vue.use(Vuetify)

const opts = {
    theme: {
        options: {
            customProperties: true,
            themeCache: {
                get: key => localStorage.getItem(key),
                set: (key, value) => localStorage.setItem(key, value),
            },
        },
        themes: {
            light: {
                primary: '#3F51B5',
                secondary: '#009688',
                accent: '#F9A825',
                error: '#f44336',
                warning: '#F9A825',
                info: '#2196f3',
                success: '#66BB6A',
                background: '#FFF'
            },
            dark: {
                primary: '#5C6BC0',
                secondary: '#009688',
                accent: '#F9A825',
                error: '#EF5350',
                warning: '#F9A825',
                info: '#2196f3',
                success: '#66BB6A',
                background: '#2C2F33',
            }
        }
    }
}

export default new Vuetify(opts)