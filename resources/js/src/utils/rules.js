export const rules = {
    required: function (str) {
        return [
            v => !!v || str + ' is required',
        ]
    },
    max: function (str, num) {
        return [
            v => (!v || v.length <= num) || str + ' should not be more than ' + num + ' characters',
        ]
    },
    min: function (str, num) {
        return [
            v => (!v || v.length >= num) || str + ' should not be less than ' + num + ' characters',
        ]
    },
    wholeNumber: function (str) {
        return [
            v => (!v || v >= 0) || str + ' should be a whole number'
        ]
    },
    greaterThan: function (str, num) {
        return [
            v => (!v || v > num) || str + ' should be greater than ' + num
        ]
    },
    length: function (str, num) {
        return [
            v => (!v || v.length == num) || str + ' should be ' + num + ' characters',
        ]
    },
    email: function () {
        return [
            v => !v || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Email must be valid'
        ]
    },
    file: function (str, ext) {
        var exts = ext.split("/")
        return [
            v => !v || exts.includes(v.name.split('.').pop()) || str + ' is not in valid format'
        ]
    },
    fileSize: function (str, num) {
        return [
            v => !v || v.size < num || 'File size should be less than ' + str
        ]
    },
    equal: function (str, val) {
        return [
            v => !v || v == val || str + ' does not match'
        ]
    }
}
