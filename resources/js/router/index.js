import { createRouter, createWebHistory } from 'vue-router'


import Dashboard from '../components/Dashboard.vue'
import Applicants from '../components/Applicants.vue'
import ManageApplicants from '../components/ManageApplicants.vue'
import ManageJobs from '../components/ManageJobs.vue'
import ManageUsers from '../components/ManageUsers.vue'
import Notifications from '../components/Notifications.vue'
import PostJob from '../components/PostJob.vue'


import Login from '../components/Auth/Login.vue'
import Register from '../components/Auth/Register.vue'

const routes = [
  { path: '/', component: Dashboard },
  { path: '/applicants', component: Applicants },
  { path: '/manage-applicants', component: ManageApplicants },
  { path: '/manage-jobs', component: ManageJobs },
  { path: '/manage-users', component: ManageUsers },
  { path: '/notifications', component: Notifications },
  { path: '/post-job', component: PostJob },

  { path: '/login', component: Login },
  { path: '/register', component: Register },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router