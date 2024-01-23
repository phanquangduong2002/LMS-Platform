const auth = [
  {
    path: '/auth',
    name: 'auth',
    component: () => import('../layouts/Auth.vue'),
    children: [
      {
        path: 'signin',
        name: 'auth-signin',
        component: () => import('../pages/Auth/SignIn.vue')
      },
      {
        path: 'register',
        name: 'auth-register',
        component: () => import('../pages/Auth/Register.vue')
      }
    ]
  }
]

export default auth
