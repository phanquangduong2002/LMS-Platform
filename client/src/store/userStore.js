import { defineStore } from 'pinia'

export const useUser = defineStore('userStore', {
  state: () => ({
    user: {
      name: 'quangduong'
    }
  }),
  actions: {},
  persist: true
})
