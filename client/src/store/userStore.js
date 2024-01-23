import { defineStore } from 'pinia'

export const useUser = defineStore('userStore', {
  state: () => {
    user: {
      name: 'Quang Dương'
    }
  },
  actions: {},
  persist: true
})
