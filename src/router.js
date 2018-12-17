import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/Home.vue'

import NestedRouteView from '@/views/NestedRouteView.vue'

import Students from '@/views/Students/Students.vue'
import CreateStudent from '@/views/Students/CreateStudent.vue'
import Personnels from '@/views/Personnels/Personnels.vue'
import CreatePersonnel from '@/views/Personnels/CreatePersonnel.vue'

import Servers from '@/views/Servers/Servers.vue'
import CreateServer from '@/views/Servers/CreateServer.vue'

import ConfigGeneral from '@/views/Config/General.vue'
import ConfigServices from '@/views/Config/Services.vue'
import ConfigDepartments from '@/views/Config/Departments.vue'
import ConfigCourses from '@/views/Config/Courses.vue'

import Guest from '@/views/Guest/Guest.vue'

Vue.use(Router)

export default new Router({
	mode: 'history',
	routes: [{
		path: '/',
		name: 'dashboard',
		component: Home,
		meta: {
			title: 'Dashboard'
		}
	}, {
		path: '/users',
		component: NestedRouteView,
		name: 'users',
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
				component: CreateStudent,
				meta: {
					title: 'Create Student'
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
				component: CreatePersonnel,
				meta: {
					title: 'Create Personnel'
				}
			}
		]
	}, {
		path: '/servers',
		component: NestedRouteView,
		name: 'servers',
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
				component: CreateServer,
				meta: {
					title: 'Create Server'
				}
			}
		]
	}, {
		path: '/config',
		component: NestedRouteView,
		name: 'config',
		children: [{
				path: '/',
				name: 'config',
				component: ConfigGeneral,
				meta: { title: 'General' }
			},
			{
				path: '/config/services',
				name: 'config',
				component: ConfigServices,
				meta: {
					title: 'Services'
				}
			}, {
				path: '/config/departments',
				name: 'config',
				component: ConfigDepartments,
				meta: {
					title: 'Departments'
				}
			}, {
				path: '/config/courses',
				name: 'config',
				component: ConfigCourses,
				meta: {
					title: 'Courses'
				}
			}
		]
	}, {
		path: '/guest',
		name: 'dashboard',
		component: Guest,
		meta: {
			title: 'Guest'
		}
	}]
})