const state = {
    serviceQueues: []
}
const mutations = {
    SERVICE_QUEUES(state, queues){
        state.serviceQueues = queues
    }
}
const getters = {
    serviceQueues(state){
        return state.serviceQueues
    }
}
const actions = {
    getServiceQueues(context, data){
        return window.axios.get('/service-queues', { params: data })
                        .then((response) => {
                            context.commit('SERVICE_QUEUES', response.data.result)
                            return response
                        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}