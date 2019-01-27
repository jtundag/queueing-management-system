const state = {
}
const mutations = {
}
const getters = {
}
const actions = {
    pushQueue(context, data){
        return window.axios.post('/push', data)
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}