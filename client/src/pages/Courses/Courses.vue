<template>
  <div class="pb-24">
    <div class="pt-[60px] pb-[200px] md:pb-[240px] relative overflow-hidden">
      <div
        class="absolute top-0 right-0 bottom-0 left-0 -z-[4] bg-banner after:absolute after:content after:top-0 after:left-0 after:w-full after:h-full -after:z-[1] after:bg-blur"
      ></div>
      <div
        class="px-8 md:px-16 lg:px-20 flex flex-col items-start justify-center"
      >
        <div class="text-sm text-body flex items-center justify-center gap-1">
          <span>
            <router-link
              :to="{ name: 'home' }"
              class="hover:text-primary transition-all duration-[400ms]"
              >Home</router-link
            >
          </span>
          <span>
            <img src="../../assets/icons/right-arrow.svg" alt="Breadcrumbs" />
          </span>
          <span class="opacity-60">All Courses</span>
        </div>

        <div class="my-5 flex item-center justify-center gap-5">
          <h3 class="text-[42px] font-bold text-heading leading-[2.9rem]">
            All Courses
          </h3>
          <router-link
            :to="{ name: 'course-list' }"
            class="h-[50px] flex items-center justify-center px-5 text-sm text-heading font-medium gap-1 bg-[rgba(226,213,252,.8)] rounded-full border border-white hover:text-primary transiton-all duration-[400ms]"
          >
            <span class="mr-[6px]">🎉</span>
            <span>{{ totalCourse }}</span> Courses
          </router-link>
        </div>
        <p class="text-heading text-lg">
          Courses that help beginner designers become true unicorns.
        </p>
        <div
          class="w-full mt-7 flex flex-col md:flex-row items-start md:items-start justify-between gap-6"
        >
          <div class="flex items-center justify-center gap-5">
            <div
              class="flex items-center justify-center p-2 rounded-full bg-white-opacity"
            >
              <button
                class="flex items-center justify-center gap-[6px] py-[6px] px-4 cursor-pointer bg-transparent text-heading rounded-full transition-all duration-[400ms]"
                :class="{ 'bg-white text-primary': type === 'grid' }"
                @click="type = 'grid'"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor"
                  width="16px"
                  height="16px"
                  viewBox="0 0 32 32"
                  version="1.1"
                >
                  <path
                    d="M30 32h-10c-1.105 0-2-0.895-2-2v-10c0-1.105 0.895-2 2-2h10c1.105 0 2 0.895 2 2v10c0 1.105-0.895 2-2 2zM30 20h-10v10h10v-10zM30 14h-10c-1.105 0-2-0.896-2-2v-10c0-1.105 0.895-2 2-2h10c1.105 0 2 0.895 2 2v10c0 1.104-0.895 2-2 2zM30 2h-10v10h10v-10zM12 32h-10c-1.105 0-2-0.895-2-2v-10c0-1.105 0.895-2 2-2h10c1.104 0 2 0.895 2 2v10c0 1.105-0.896 2-2 2zM12 20h-10v10h10v-10zM12 14h-10c-1.105 0-2-0.896-2-2v-10c0-1.105 0.895-2 2-2h10c1.104 0 2 0.895 2 2v10c0 1.104-0.896 2-2 2zM12 2h-10v10h10v-10z"
                  />
                </svg>
                Grid
              </button>
              <button
                class="flex items-center justify-center gap-[6px] py-[6px] px-4 cursor-pointer bg-transparent text-heading rounded-full transition-all duration-[400ms]"
                :class="{ 'bg-white text-primary': type === 'list' }"
                @click="type = 'list'"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16px"
                  height="16px"
                  viewBox="0 0 24 24"
                  fill="none"
                >
                  <path
                    d="M8 6.00067L21 6.00139M8 12.0007L21 12.0015M8 18.0007L21 18.0015M3.5 6H3.51M3.5 12H3.51M3.5 18H3.51M4 6C4 6.27614 3.77614 6.5 3.5 6.5C3.22386 6.5 3 6.27614 3 6C3 5.72386 3.22386 5.5 3.5 5.5C3.77614 5.5 4 5.72386 4 6ZM4 12C4 12.2761 3.77614 12.5 3.5 12.5C3.22386 12.5 3 12.2761 3 12C3 11.7239 3.22386 11.5 3.5 11.5C3.77614 11.5 4 11.7239 4 12ZM4 18C4 18.2761 3.77614 18.5 3.5 18.5C3.22386 18.5 3 18.2761 3 18C3 17.7239 3.22386 17.5 3.5 17.5C3.77614 17.5 4 17.7239 4 18Z"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
                List
              </button>
            </div>
            <div class="text-heading">
              Showing 1-<span>{{
                totalCourse > perPage ? perPage : totalCourse
              }}</span>
              of <span>{{ totalCourse }}</span> results
            </div>
          </div>
          <div
            class="flex flex-col sm:flex-row items-start sm:items-center justify-center gap-5"
          >
            <form class="relative">
              <input
                type="text"
                class="bg-transparent h-[50px] min-w-[300px] pl-5 pr-16 text-white text-medium placeholder:text-white border-2 border-white rounded-full outline-none"
                placeholder="Search Your Course..."
              />
              <button
                class="absolute top-1/2 -translate-y-1/2 right-[0.45rem] p-[6px] rounded-full text-white hover:text-primary after:absolute after:content after:top-0 after:left-0 after:w-full after:h-full after:bg-gray-light after:-z-[1] after:rounded-full after:scale-[0.8] after:opacity-0 hover:after:scale-100 hover:after:opacity-100 transition-all duration-[400ms] after:transition-all after:duration-[400ms]"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="26px"
                  height="26px"
                  viewBox="0 -0.5 25 25"
                  fill="none"
                >
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M5.5 11.1455C5.49956 8.21437 7.56975 5.69108 10.4445 5.11883C13.3193 4.54659 16.198 6.08477 17.32 8.79267C18.4421 11.5006 17.495 14.624 15.058 16.2528C12.621 17.8815 9.37287 17.562 7.3 15.4895C6.14763 14.3376 5.50014 12.775 5.5 11.1455Z"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M15.989 15.4905L19.5 19.0015"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </button>
            </form>

            <button
              class="h-[50px] flex items-center justify-center gap-[6px] px-6 text-heading font-medium bg-white rounded-full hover:bg-primary hover:text-white transition-all duration-[500ms]"
            >
              Filter
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18px"
                height="18px"
                viewBox="0 0 24 24"
                fill="none"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M2.73224 5.32873C1.58574 4.03892 2.50136 2 4.22706 2H19.7734C21.4991 2 22.4147 4.03893 21.2682 5.32873L15.0002 12.3802V21C15.0002 21.3466 14.8208 21.6684 14.5259 21.8507C14.2311 22.0329 13.863 22.0494 13.553 21.8944L9.553 19.8944C9.21421 19.725 9.00021 19.3788 9.00021 19V12.3802L2.73224 5.32873ZM19.7734 4H4.22706L10.7476 11.3356C10.9103 11.5187 11.0002 11.7551 11.0002 12V18.382L13.0002 19.382V12C13.0002 11.7551 13.0901 11.5187 13.2528 11.3356L19.7734 4Z"
                  fill="currentColor"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="px-8 md:px-16 lg:px-20 -mt-[145px]">
      <div
        class="grid grid-cols-1 gap-4 md:gap-8 sm:grid-cols-2 md:grid-cols-3"
      >
        <div v-for="course in courses" :key="course.id">
          <CourseCard :course="course" />
        </div>
      </div>
    </div>
    <div class="w-full flex items-center justify-center mt-14">
      <Pagination
        :meta="meta"
        :links="links"
        @getCourses="handlePaginationClick"
      />
    </div>
  </div>
</template>

<script>
import { defineComponent, ref, toRefs, reactive } from 'vue'
import { api, apiKey } from '../../api/constants'
import CourseCard from '../../components/Course/CourseCard.vue'
import Pagination from '../../components/Pagination/Pagination.vue'
export default defineComponent({
  components: { CourseCard, Pagination },
  setup() {
    const courses = ref([])
    const totalCourse = ref(0)
    const perPage = ref(0)

    const meta = ref({
      current_page: 0,
      last_page: 0
    })

    const links = ref({
      first_page_url: '',
      last_page_url: '',
      prev_page_url: '',
      next_page_url: ''
    })

    const type = ref('grid')

    const getCourses = async url => {
      url = url || `${api}/course`
      const res = await axios.get(`${url}`, {
        headers: {
          'x-api-key': apiKey
        }
      })

      if (res.data.success) {
        courses.value = res.data.courses.data
        totalCourse.value = res.data.courses.total
        perPage.value = res.data.courses.per_page

        meta.value.current_page = res.data.courses.current_page
        meta.value.last_page = res.data.courses.last_page

        links.value.first_page_url = res.data.courses.first_page_url
        links.value.last_page_url = res.data.courses.last_page_url
        links.value.prev_page_url = res.data.courses.prev_page_url
        links.value.next_page_url = res.data.courses.next_page_url
      }
    }

    getCourses()

    return {
      courses,
      totalCourse,
      perPage,
      meta,
      links,
      type,
      getCourses
    }
  },
  methods: {
    async handlePaginationClick(url) {
      await this.getCourses(url)

      url = new URL(url)
      const searchParams = new URLSearchParams(url.search)
      const page = searchParams.get('page')

      this.$router.push({ name: 'course-list', query: { page: page } })

      window.scrollTo({ top: 0 })
    }
  }
})
</script>

<style></style>
