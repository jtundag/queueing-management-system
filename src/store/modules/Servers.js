const state = {
    users: []
}
const mutations = {}
const getters = {}
const actions = {
    createServer(context, data) {
        return window.axios.post('/servers/create', data)
    },
    updateServer(context, data) {
        return window.axios.patch(`/servers/${data.id}/update`, data)
    },
    getServers(context, data) {
        return window.axios.get('/servers', data)
    },
    deleteServer(context, id){
        return window.axios.delete('/servers/delete', { params: { id } })
    },
    findServer(context, id) {
        return window.axios.get('/servers/find', {
            params: {
                id
            }
        })
    },
    getServerReports(context, id){
        return window.axios.get(`/servers/${id}/reports`)
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}