import { defineStore } from 'pinia'
import { router } from '@inertiajs/vue3'
import axios from 'axios'

export const useClientsStore = defineStore('clients', {
  state: () => ({
    form: {
      name: '',
      phone: '',
      address: '',
      clients: [] as Array<{ name: string, phone: string, address: string }>,
    },
  }),
  actions: {
    initializeForm(data: Record<string, string>) {
      this.form = {
        ...this.form,
        ...data, 
        clients: this.form.clients || [],
      };
    },
    addClient() {
      const newClient = { name: this.form.name, phone: this.form.phone, address: this.form.address };
      
      this.form.clients.push(newClient);
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