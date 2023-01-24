import store from '../store'

export const auth = {
    isEmployee: function () {
        let user = store.getters['user/getUser']
        if (user && user.accountRole) {
            if (user.accountRole[0] == 'STUDENT') {
                return false
            } else {
                return true
            }
        } else {
            return false
        }
        
    },
    isStudent: function () {
        let user = store.getters['user/getUser']
        if (user && user.accountRole) {
            if (user.accountRole[0] == 'STUDENT') {
                return true
            } else {
                return false
            }
        } else {
            return false
        }
    },
    token: function () {
        var user = store.getters['user/getUser']
        return user && user.access_token ? user.access_token : null
    },
    credentials: function () {
        return store.getters['user/getUser']
    },
    auth: function () {
        return store.getters['user/getUser']
    }
}