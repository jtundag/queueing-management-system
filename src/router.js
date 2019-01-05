import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/Home.vue'
import Login from '@/views/Login.vue'
import store from '@/store'
import Middlewares from './middlewares'

import NestedRouteView from '@/views/NestedRouteView.vue'

import Students from '@/views/Students/Students.vue'
import StudentForm from '@/views/Students/StudentForm.vue'
import Personnels from '@/views/Personnels/Personnels.vue'
import PersonnelForm from '@/views/Personnels/PersonnelForm.vue'

import Servers from '@/views/Servers/Servers.vue'
import ServerForm from '@/views/Servers/ServerForm.vue'

import ConfigGeneral from '@/views/Config/General.vue'
import ConfigServices from '@/views/Config/Services.vue'
import ConfigGroups from '@/views/Config/Groups.vue'
import ConfigDepartments from '@/views/Config/Departments.vue'

import Guest from '@/views/Guest/Guest.vue'

Vue.use(Router)

const router = new Router({
	mode: 'history',
	routes: [{
		path: '/login',
		name: 'login',
		component: Login,
		beforeEnter: Middlewares.userNotAuth,
		meta: {
			title: 'Login'
		}
	}, {
		path: '/',
		name: 'dashboard',
		component: Home,
		beforeEnter: Middlewares.userAuth,
		meta: {
			title: 'Dashboard'
		}
	}, {
		path: '/users',
		component: NestedRouteView,
		name: 'users',
		beforeEnter: Middlewares.userAuth,
		children: [{
				path: '/users/students',
				name: 'users',
				component: Students,
				meta: {
					title: 'Students'
				}
			},
			{
				path: '/users/students/create',
				name: 'users',
				component: StudentForm,
				meta: {
					title: 'Create Student'
				}
			}, {
				path: '/users/students/:id/edit',
				name: 'users',
				component: StudentForm,
				meta: {
					title: 'Edit Student'
				}
			},
			{
				path: '/users/personnels',
				name: 'users',
				component: Personnels,
				meta: {
					title: 'Personnels'
				}
			}, {
				path: '/users/personnels/create',
				name: 'users',
				component: PersonnelForm,
				meta: {
					title: 'Create Personnel'
				}
			}, {
				path: '/users/personnels/:id/edit',
				name: 'users',
				component: PersonnelForm,
				meta: {
					title: 'Edit Personnel'
				}
			}
		]
	}, {
		path: '/servers',
		component: NestedRouteView,
		name: 'servers',
		beforeEnter: Middlewares.userAuth,
		children: [{
				path: '/',
				name: 'servers',
				component: Servers,
				meta: {
					title: 'Servers'
				}
			},
			{
				path: '/servers/create',
				name: 'servers',
				component: ServerForm,
				meta: {
					title: 'Create Server'
				}
			}, {
				path: '/servers/:id/edit',
				name: 'servers',
				component: ServerForm,
				meta: {
					title: 'Edit Server'
				}
			}
		]
	}, {
		path: '/config',
		component: NestedRouteView,
		name: 'config',
		beforeEnter: Middlewares.userAuth,
		children: [{
				path: '/',
				name: 'config',
				component: ConfigGeneral,
				meta: {
					title: 'General'
				}
			},
			{
				path: '/config/services',
				name: 'config',
				component: ConfigServices,
				meta: {
					title: 'Services'
				}
			}, {
				path: '/config/groups',
				name: 'config',
				component: ConfigGroups,
				meta: {
					title: 'Groups'
				}
			}, {
				path: '/config/departments',
				name: 'config',
				component: ConfigDepartments,
				meta: {
					title: 'Departments'
				}
			}
		]
	}, {
		path: '/guest',
		name: 'dashboard',
		component: Guest,
		beforeEnter: Middlewares.userAuth,
		meta: {
			title: 'Guest'
		}
	}]
})

router.beforeEach((to, from, next) => {
	if(localStorage.getItem('jwt-auth-token')){
		// store.dispatch('checkUser')
		// 	.then((response) => {
		// 	})
	}
	next()
})

export default router