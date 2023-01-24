import axios from 'axios'
import Vuex from 'vuex'
import Vue from 'vue'


//load Vuex
Vue.use(Vuex);

export const path = {
    namespaced: true,
    state: () => ({
        fileUrl: process.env.MIX_STORAGE_URL,
        placeHolderUrl: process.env.MIX_FILE_URL,
        localFileUrl: '/storage',
        localPlaceHolderUrl: '../images'
    }),
}
