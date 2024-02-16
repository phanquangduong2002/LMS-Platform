<template>
  <div class="p-6 shadow-lg rounded-box">
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
        <span>5 sao</span>
        <span class="ml-1">(<span>15</span> Reviews)</span>
        <button
          class="ml-auto flex items-center justify-center rounded-full w-10 h-10 hover:bg-base-200 transition-all duration-400"
        >
          <img src="../../assets/icons/bookmark.svg" alt="Bookmark" />
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {}
</script>

<style></style>
