<template>
  <div
    class="flex items-center justify-center gap-3 text-body text-lg font-medium"
  >
    <button
      class="w-10 h-10 bg-white shadow rounded-md hover:text-white hover:bg-primary transition-all duration-[400ms]"
      :class="{ 'btn-disabled opacity-60': meta.current_page === 1 }"
      @click="$emit('getData', links.prev_page_url)"
    >
      «
    </button>
    <button
      class="w-10 h-10 bg-white shadow rounded-md hover:text-white hover:bg-primary transition-all duration-[400ms]"
      :class="{ hidden: meta.current_page < 3 }"
      @click="$emit('getData', links.first_page_url)"
    >
      1
    </button>
    <button
      class="btn-disabled opacity-60"
      :class="{ hidden: meta.current_page < 4 }"
    >
      ...
    </button>
    <button
      class="w-10 h-10 bg-white shadow rounded-md hover:text-white hover:bg-primary transition-all duration-[400ms]"
      :class="{ hidden: meta.current_page <= 1 }"
      @click="$emit('getData', links.prev_page_url)"
    >
      {{ meta.current_page - 1 }}
    </button>
    <button
      class="w-10 h-10 bg-primary shadow rounded-md text-white btn-disabled"
    >
      {{ meta.current_page }}
    </button>
    <button
      class="w-10 h-10 bg-white shadow rounded-md hover:text-white hover:bg-primary transition-all duration-[400ms] btn-disabled"
      :class="{ hidden: meta.current_page >= meta.last_page - 1 }"
      @click="$emit('getData', links.next_page_url)"
    >
      {{ meta.current_page + 1 }}
    </button>
    <button
      class="btn-disabled opacity-60"
      :class="{ hidden: meta.last_page - meta.current_page < 3 }"
    >
      ...
    </button>
    <button
      class="w-10 h-10 bg-white shadow rounded-md hover:text-white hover:bg-primary transition-all duration-[400ms]"
      :class="{ hidden: meta.current_page === meta.last_page }"
      @click="$emit('getData', links.last_page_url)"
    >
      {{ meta.last_page }}
    </button>
    <button
      class="w-10 h-10 bg-white shadow rounded-md hover:text-white hover:bg-primary transition-all duration-[400ms]"
      :class="{
        'btn-disabled opacity-60': meta.current_page === meta.last_page
      }"
      @click="$emit('getData', links.next_page_url)"
    >
      »
    </button>
  </div>
</template>

<script>
export default {
  props: {
    meta: Object,
    links: Object,
    getData: Function
  }
}
</script>

<style></style>
