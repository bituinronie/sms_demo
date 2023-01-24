import store from '../store'
const moment = require('moment')
export const dateFormat = {  
    ymd_number(value) {
        return moment(value).format('YYYY-MM-DD').toUpperCase()
    },
    mdy(value) {
        return moment(value).format('MMMM DD, YYYY').toUpperCase()
    },
    mdy_time(value) {
        return moment(value).format('MMMM DD, YYYY | h:mm a').toUpperCase()
    },
}
