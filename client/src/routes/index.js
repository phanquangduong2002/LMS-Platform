import { createRouter, createWebHistory } from 'vue-router'

import auth from './auth'
import home from './home'
import courses from './courses'

const routes = [...auth, ...home, ...courses]

const router = createRouter({
  history: createWebHistory(),
  routes: routes
})

export default router
