const state = {}
const mutations = {}
const getters = {}
const actions = {
    getTags(context, data) {
        return window.axios.get('/tags', data)
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}