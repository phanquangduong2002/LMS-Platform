<template>
  <div class="pb-24">
    <div class="pt-[60px] pb-[120px] relative overflow-hidden">
      <div
        class="absolute top-0 right-0 bottom-0 left-0 -z-[4] bg-banner after:absolute after:content after:top-0 after:left-0 after:w-full after:h-full -after:z-[1] after:bg-blur"
      ></div>
      <div
        class="px-8 md:px-16 lg:px-20 w-[75%] flex flex-col items-start justify-center"
      >
        <div
          class="text-sm text-body flex items-center justify-center gap-1 mb-4"
        >
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
          <span class="opacity-60">{{ course.course_category_title }}</span>
        </div>
        <h3 class="mb-3 text-heading text-[50px] font-bold">
          {{ course.title }}
        </h3>
        <p class="text-heading font-lg mb-6">{{ course.description }}</p>
        <div class="flex items-center justify-start gap-3 text-heading text-sm">
          <div
            class="h-[50px] flex items-center justify-center px-5 text-sm text-heading font-medium gap-2 bg-[rgba(226,213,252,.8)] rounded-full border border-white"
          >
            <img
              src="../../assets/images/card-icon-1.webp"
              alt="Best Seller"
              class="w-[30px] h-[30px] object-cover object-center"
            />
            Bestseller
          </div>
          <div class="flex items-center justify-center gap-1">
            <span class="font-medium mt-[2px] mr-[2px]">4.8</span>
            <span v-for="i in 5" :key="i">
              <img src="../../assets/icons/star-rate.svg" alt="Star" />
            </span>
          </div>
          <div
            class="overflow-hidden px-3 py-1 rounded-md bg-white-opacity cursor-pointer relative after:absolute after:content after:top-0 after:left-0 after:w-full after:h-full after:bg-primary-opacity after:opacity-0 after:scale-90 hover:text-primary hover:after:opacity-100 hover:after:scale-100 after:transition-all after:duration-[300ms] transiton-all duration-[400ms]"
          >
            215,000 rating
          </div>
          <div class="font-medium">100,000 students</div>
        </div>
        <router-link
          :to="{ name: 'home' }"
          class="mt-8 mb-6 flex items-center justify-start gap-4 text-body text-sm"
        >
          <div class="avatar">
            <div
              class="w-10 rounded-full ring ring-primaryOpacity ring-offset-base-100 ring-offset-2"
            >
              <img
                src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg"
              />
            </div>
          </div>
          <div>
            <span>By</span>
            <span
              class="text-heading font-medium px-1 hover:text-primary transition-all duration-[500ms]"
              >{{ course.instructor_name }}</span
            >
            <span>In</span>
            <span
              class="text-heading font-medium px-1 hover:text-primary transition-all duration-[500ms]"
              >Advanced Educator</span
            >
          </div>
        </router-link>
        <div class="flex items-center justify-start gap-6 text-heading text-sm">
          <span class="flex item-center justify-center gap-2">
            <img src="../../assets/icons/calendar.svg" alt="Calendar" />
            Last updated<span>12/2024</span>
          </span>
          <span class="flex item-center justify-center gap-2">
            <img src="../../assets/icons/language.svg" alt="Language" />
            English</span
          >
          <span class="flex item-center justify-center gap-2">
            <img src="../../assets/icons/certified.svg" alt="certified" />
            Certified Course</span
          >
        </div>
      </div>
      <div class="absolute bottom-0 right-0 w-[25%]">
        <CoursePreview />
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { api, apiKey } from '../../api/constants'
import CoursePreview from '../../components/Course/CoursePreview.vue'

export default defineComponent({
  components: { CoursePreview },
  setup() {
    const course = ref({})
    return {
      course
    }
  },
  methods: {
    getUrlParam() {
      return this.$route.params.slug
    },
    async getCourseDetail(slug) {
      const res = await axios.get(`${api}/course/${slug}`, {
        headers: {
          'x-api-key': apiKey
        }
      })
      if (res.data.success) this.course = res.data.course
      console.log(res.data)
    }
  },
  mounted() {
    window.scrollTo({ top: 0 })
    const slug = this.getUrlParam()
    this.getCourseDetail(slug)
  }
})
</script>

<style></style>
