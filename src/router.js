import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/Home.vue'

import NestedRouteView from '@/views/NestedRouteView.vue'

import Students from '@/views/Students/Students.vue'
import CreateStudent from '@/views/Students/CreateStudent.vue'
import Personnels from '@/views/Personnels/Personnels.vue'
import CreatePersonnel from '@/views/Personnels/CreatePersonnel.vue'

import Departments from '@/views/Departments/Departments.vue'
import CreateDepartment from '@/views/Departments/CreateDepartment.vue'

Vue.use(Router)

export default new Router({
	mode: 'history',
	routes: [{
		path: '/',
		name: 'dashboard',
		component: Home
	}, {
		path: '/users',
		component: NestedRouteView,
		name: 'users',
		children: [{
				path: '/users/students',
				name: 'users',
				component: Students
			},
			{
				path: '/users/students/create',
				name: 'users',
				component: CreateStudent
			},
			{
				path: '/users/personnels',
				name: 'users',
				component: Personnels
			}, {
				path: '/users/personnels/create',
				name: 'users',
				component: CreatePersonnel
			}
		]
	}, {
		path: '/departments',
		component: NestedRouteView,
		name: 'departments',
		children: [{
				path: '/',
				name: 'departments',
				component: Departments
			},
			{
				path: '/departments/create',
				name: 'departments',
				component: CreateDepartment
			}
		]
	}]
})