<template>
  <div
    class="p-6 shadow-lg rounded-box hover:scale-[1.02] transition-all duration-[450ms] bg-white"
  >
    <div>
      <div class="relative">
        <router-link :to="{ name: 'course-detail', params: { id: 1 } }">
          <img
            src="../../assets/images/course-01.webp"
            alt="Course thumb"
            class="rounded-lg"
          />
          <div class="absolute bottom-6 right-5 w-16 h-16">
            <img
              src="../../assets/images/offer-badge-bg-color.svg"
              alt="Badge Background"
            />
            <div
              class="absolute flex flex-col items-center justify-center top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-xs font-semibold text-white"
            >
              <span>-120%</span>
              <span>Off</span>
            </div>
          </div>
        </router-link>
      </div>
      <div
        class="pt-6 flex items-center justify-start text-gray text-sm font-medium"
      >
        <div class="flex items-center justify-center gap-1">
          <span v-for="i in 5" :key="i">
            <img src="../../assets/icons/star-rate.svg" alt="Star" />
          </span>
        </div>
        <span class="ml-2">(<span>15</span> Reviews)</span>
        <button
          class="ml-auto flex items-center justify-center rounded-full w-10 h-10 hover:bg-base-200 transition-all duration-400"
        >
          <img src="../../assets/icons/bookmark.svg" alt="Bookmark" />
        </button>
      </div>
      <h3 class="text-2xl font-bold mt-2">
        {{ course.title }}
      </h3>
      <ul class="mt-3 flex items-center justify-start gap-3 text-body text-sm">
        <li class="flex items-center justify-center gap-1">
          <span>
            <img src="../../assets/icons/book.svg" alt="Lessons" />
          </span>
          <span>12</span>
          <span>Lessons</span>
        </li>
        <li class="flex items-center justify-center gap-1">
          <span><img src="../../assets/icons/users.svg" alt="Students" /></span>
          <span>30</span>
          <span>Students</span>
        </li>
      </ul>
      <p class="mt-4 text-body text-base tracking-wide">
        {{ course.description }}
      </p>
      <router-link
        :to="{ name: 'home' }"
        class="mt-4 ml-2 flex items-center justify-start gap-4 text-body text-sm"
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
      <div class="mt-4 flex items-center justify-between">
        <div class="flex items-center justify-center gap-[6px]">
          <span class="text-body text-2xl font-bold">$70</span>
          <span class="text-body text-xl font-semibold line-through opacity-50"
            >$120</span
          >
        </div>
        <router-link
          :to="{ name: 'course-detail', params: { id: 1 } }"
          class="flex items-center justify-center gap-2 text-heading text-sm font-medium"
          >Learn More <img src="../../assets/icons/right.svg" alt="Learn more"
        /></router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    course: Object
  }
}
</script>

<style></style>
