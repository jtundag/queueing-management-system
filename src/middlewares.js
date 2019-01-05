import store from '@/store'
import router from '@/router'

export default {
    userAuth(to, from, next){
        if(!store.getters.isLoggedIn) return router.replace('/login')
        return next()
    },
    userNotAuth(to, from, next){
        if (store.getters.isLoggedIn) return router.replace('/')
        return next()
    }
}