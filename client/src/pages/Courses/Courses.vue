<template>
  <div>
    <div>List Courses</div>
    <div class="grid grid-cols-3 gap-8">
      <CourseCard />
      <CourseCard />
      <CourseCard />
      <CourseCard />
    </div>
  </div>
</template>

<script>
import CourseCard from '../../components/Course/CourseCard.vue'
export default {
  components: { CourseCard }
}
</script>

<style></style>
