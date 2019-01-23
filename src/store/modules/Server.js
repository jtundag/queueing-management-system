const state = {
    'queues': []
}
const mutations = {
    QUEUES(state, queues){
        state.queues = queues
    }
}
const getters = {
    queues(state){
        return state.queues
    }
}
const actions = {
    getQueues(context, data) {
        return window.axios.get('/server/queues', { params: data })
                    .then((response) => {
                        context.commit('QUEUES', response.data.result)
                    })
    },
    serveNext(){
        
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}