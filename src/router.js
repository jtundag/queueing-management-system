import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/Home.vue'

import NestedRouteView from '@/views/NestedRouteView.vue'

import Users from '@/views/Users/Users.vue'
import CreateUser from '@/views/Users/CreateUser.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: Home
    }, {
      path: '/users',
      component: NestedRouteView,
      name: 'users',
      children: [{
        path: '/',
        name: 'users',
        component: Users
      },
      {
        path: '/users/create',
        name: 'users',
        component: CreateUser
      }]
    }
  ]
})
