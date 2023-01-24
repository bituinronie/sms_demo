export const transformCase = {
    toSentenceCase: function (str) {
        return str.toLowerCase().replace(/\.\s+([a-z])[^\.]|^(\s*[a-z])[^\.]/g, s => s.replace(/([a-z])/,s => s.toUpperCase()))
    }
}