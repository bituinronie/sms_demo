 import {
     mapActions,
     mapGetters,
} from 'vuex'
 
 export default {
     computed: {
         ...mapGetters('loading', [
             'getterPageLoading',
             'getterPartLoading'
         ])
     },
     methods: {
         ...mapActions('loading', [
             'resetPageLoading',
             'resetPartLoading',
             'setPageLoading'
         ]),
     },
 };
