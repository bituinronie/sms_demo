 import {
     mapActions,
     mapGetters,
 } from 'vuex'

 export default {
     computed: {
         ...mapGetters('notificationMessage', [
             'getterMessage',
             'getterRedirectMessage',
             'getterSecondRedirect',
             'getterOtherMessage',
             'getterErrorMessage'
         ]),
     },
     methods: {
         ...mapActions('notificationMessage', [
             'resetMessage',
             'resetRedirectMessage',
             'resetSecondRedirect',
             'resetOtherMessage',
             'resetErrorMessage'
         ]),
         onUpdateAlert(newValue) {
             this.alert = newValue
         },
     },
 };
