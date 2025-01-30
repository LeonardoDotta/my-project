import { defineStore } from 'pinia'

export const useClientsStore = defineStore('clients', {
  state: () => ({ name: 'Eduardo', phone: '9', address: 'Calle 123' }),
})