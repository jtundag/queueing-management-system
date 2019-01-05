const state = {
    users: []
}
const mutations = {}
const getters = {}
const actions = {
    createService(context, data) {
        return window.axios.post('/config/services/create', data)
    },
    updateService(context, data) {
        return window.axios.patch(`/config/services/${data.id}/update`, data)
    },
    getServices(context, data) {
        return window.axios.get('/config/services', data)
    },
    deleteService(context, id){
        return window.axios.delete('/config/services/delete', { params: { id } })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}