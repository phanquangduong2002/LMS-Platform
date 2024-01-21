const auth = [
  {
    path: '/auth',
    name: 'auth',
    component: () => import('../layouts/auth.vue'),
    children: [
      {
        path: 'signin',
        name: 'signin',
        component: () => import('../pages/Auth/SignIn.vue')
      },
      {
        path: 'register',
        name: 'register',
        component: () => import('../pages/Auth/Register.vue')
      }
    ]
  }
]

export default auth
