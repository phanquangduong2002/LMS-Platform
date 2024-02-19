const courses = [
  {
    path: '/courses',
    name: 'courses',
    component: () => import('../layouts/Courses.vue'),
    children: [
      {
        path: '',
        name: 'course-list',
        component: () => import('../pages/Courses/Courses.vue')
        // props: route => ({ page: route.query.page || 1 })
      },
      {
        path: ':slug',
        name: 'course-detail',
        component: () => import('../pages/Courses/CourseDetail.vue')
      }
    ]
  }
]

export default courses
