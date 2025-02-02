import { defineStore } from 'pinia'
import { router } from '@inertiajs/vue3'
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
      const newClient = { name: this.name, phone: this.phone, address: this.address };
      
      this.clients.push(newClient);
      this.sendClientToServer(newClient)
        .then(() => {
          router.visit('/clients'); 
        });
    
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
    },
    async fetchClientById(id: string) {
      try {
        const response = await axios.get(`http://localhost:8000/clients/${id}`);
        return response.data;
      } catch (error) {
        console.error('Erro ao buscar cliente:', error);
        return null;
      }
    }
  }
})