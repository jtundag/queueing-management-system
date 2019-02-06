const state = {
    serviceQueues: [],
    pastServiceQueues: []
}
const mutations = {
    SERVICE_QUEUES(state, queues){
        state.serviceQueues = queues
    },
    PAST_SERVICE_QUEUES(state, queues){
        state.pastServiceQueues = queues
    }
}
const getters = {
    serviceQueues(state){
        return state.serviceQueues
    },
    pastServiceQueues(state){
        return state.pastServiceQueues
    }
}
const actions = {
    getServiceQueues(context, data){
        return window.axios.get('/service-queues', { params: data })
                        .then((response) => {
                            context.commit('SERVICE_QUEUES', response.data.result)
                            context.commit('PAST_SERVICE_QUEUES', response.data.past_queues)
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