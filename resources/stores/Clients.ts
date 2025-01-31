import { defineStore } from 'pinia'
import axios from 'axios'

export const useClientsStore = defineStore('clients', {
  state: () => ({
    name: '',
    phone: '',
    address: '',
    clients: [] as Array<{ name: string, phone: string, address: string }>,
  }),
  actions: {
    addClient() {
      this.clients.push({ name: this.name, phone: this.phone, address: this.address });
      this.sendClientToServer({ name: this.name, phone: this.phone, address: this.address });
      this.name = '';
      this.phone = '';
      this.address = '';
    },
    async sendClientToServer(clientData: { name: string; phone: string; address: string }) {
      try {
        const response = await axios.post('http://localhost:8000/clients', clientData, {
          headers: {
            'Content-Type': 'application/json',
          }
        });
        console.log('Cliente salvo com sucesso:', response.data);
      } catch (error) {
        console.error('Erro ao enviar cliente:', error);
      }
    },
    async fetchClients() {
      try {
        const response = await axios.get('http://localhost:8000/clients');
        this.clients = response.data;
      } catch (error) {
        console.error('Erro ao buscar clientes:', error);
      }
    }
  }
})