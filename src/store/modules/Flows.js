const state = {
    users: []
}
const mutations = {}
const getters = {}
const actions = {
    createPredefinedFlow(context, data) {
        return window.axios.post('/config/predefined-flows/create', data)
    },
    updatePredefinedFlow(context, data) {
        return window.axios.patch(`/config/predefined-flows/${data.id}/update`, data)
    },
    getPredefinedFlows(context, data) {
        return window.axios.get('/config/predefined-flows', data)
    },
    deletePredefinedFlow(context, id){
        return window.axios.delete('/config/predefined-flows/delete', { params: { id } })
    },
    findPredefinedFlow(context, id) {
        return window.axios.get('/config/predefined-flows/find', {
            params: {
                id
            }
        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}