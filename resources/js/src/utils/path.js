import store from '../store'

export const path = {
    isLocal: function () {
        // var base_url = window.location.origin
        if (process.env.MIX_APP_ENV == 'local') {
            return true
        } else {
            return false
        }
    },
    fileBaseUrl: function () {
        var url = ''
        if (this.isLocal()) {
            url = store.state.path.localFileUrl
        } else {
            url = store.state.path.fileUrl
        }
        return url
    },
    placeHolderUrl: function () {
        var url = ''
        if (this.isLocal()) {
            url = store.state.path.localPlaceHolderUrl
        } else {
            url = store.state.path.placeHolderUrl
        }
        return url
    }
}
