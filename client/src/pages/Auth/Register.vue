<template>
  <div class="w-[40%] mx-auto my-16">
    <div
      class="px-10 py-6 flex flex-col items-start justify-center gap-8 bg-transparent rounded-lg shadow-2xl"
    >
      <h4 class="text-xl font-bold">Register</h4>
      <div class="relative w-full">
        <input
          type="text"
          id="email"
          class="w-full border-b py-1 text-sm focus:outline-none focus:border-primary focus:border-b-2 transition-colors peer"
          autocomplete="off"
          v-model="email"
        />
        <label
          for="email"
          class="absolute left-0 top-1 text-gray-600 text-sm cursor-text peer-focus:text-xs peer-focus:-top-4 peer-focus:text-primary transition-all"
          :class="{ '-top-4 text-xs text-primary': username.length > 0 }"
          >Email *</label
        >
      </div>
      <div class="relative w-full">
        <input
          type="text"
          id="username"
          class="w-full border-b py-1 text-sm focus:outline-none focus:border-primary focus:border-b-2 transition-colors peer"
          autocomplete="off"
          v-model="username"
        />
        <label
          for="username"
          class="absolute left-0 top-1 text-gray-600 text-sm cursor-text peer-focus:text-xs peer-focus:-top-4 peer-focus:text-primary transition-all"
          :class="{ '-top-4 text-xs text-primary': username.length > 0 }"
          >Username *</label
        >
      </div>
      <div class="relative w-full">
        <input
          type="password"
          id="password"
          class="w-full border-b py-1 text-sm focus:outline-none focus:border-primary focus:border-b-2 transition-colors peer"
          autocomplete="off"
          v-model="password"
        />
        <label
          for="password"
          class="absolute left-0 top-1 text-gray-600 text-sm cursor-text peer-focus:text-xs peer-focus:-top-4 peer-focus:text-primary transition-all"
          :class="{ '-top-4 text-xs text-primary': password.length > 0 }"
          >Password *</label
        >
      </div>
      <div class="relative w-full">
        <input
          type="password"
          id="confirm_password"
          class="w-full border-b py-1 text-sm focus:outline-none focus:border-primary focus:border-b-2 transition-colors peer"
          autocomplete="off"
          v-model="password"
        />
        <label
          for="confirm_password"
          class="absolute left-0 top-1 text-gray-600 text-sm cursor-text peer-focus:text-xs peer-focus:-top-4 peer-focus:text-primary transition-all"
          :class="{ '-top-4 text-xs text-primary': password.length > 0 }"
          >Confirm password *</label
        >
      </div>
      <button
        class="w-full text-center bg-gradient py-2 px-4 rounded-md text-base font-semibold text-white"
      >
        Register
      </button>
      <div class="w-full flex items-center justify-center gap-1 text-sm">
        <p class="text-gray-600">Do you have an account?</p>
        <router-link
          :to="{ name: 'auth-login' }"
          class="text-primary font-medium"
          >Login</router-link
        >
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, ref, reactive, toRefs } from 'vue'
export default defineComponent({
  setup() {
    const user = reactive({
      email: '',
      username: '',
      password: '',
      confirm_password: ''
    })

    return {
      ...toRefs(user)
    }
  }
})
</script>

<style></style>
