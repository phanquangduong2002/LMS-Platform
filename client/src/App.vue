<template>
  <div class="bg-transparent max-w-[1280px] mx-auto">
    <Header />
    <router-view></router-view>
    <Footer />
  </div>
</template>

<script>
import Footer from './components/Footer/Footer.vue'
import Header from './components/Header/Header.vue'

export default {
  components: { Header, Footer }
}
</script>

<style></style>
