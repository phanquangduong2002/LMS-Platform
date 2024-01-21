<template>
  <div>{{ userStore.user.name }}</div>
</template>

<script>
import { useUser } from '../store/userStore'
export default {
  setup() {
    const userStore = useUser()

    return {
      userStore
    }
  }
}
</script>

<style></style>
