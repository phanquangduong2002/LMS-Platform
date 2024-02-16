const auth = [
  {
    path: '/auth',
    name: 'auth',
    component: () => import('../layouts/Auth.vue'),
    children: [
      {
        path: 'login',
        name: 'auth-login',
        component: () => import('../pages/Auth/Login.vue')
      },
      {
        path: 'register',
        name: 'auth-register',
        component: () => import('../pages/Auth/Register.vue')
      },
      {
        path: 'forgot-password',
        name: 'auth-forgot-password',
        component: () => import('../pages/Auth/ForgotPassword.vue')
      }
    ]
  }
]

export default auth
