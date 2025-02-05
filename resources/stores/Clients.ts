import { defineStore } from 'pinia'
import { router } from '@inertiajs/vue3'
import axios from 'axios'

export const useClientsStore = defineStore('clients', {
  state: () => ({
    form: {
      id: null,
      name: '',
      phone: '',
      address: '',
      _method: 'POST',
      clients: [] as Array<{ id: number; name: string; phone: string; address: string }>,
    },
  }),
  actions: {
    initializeForm(data: Record<string, any>) {
      this.form = {
        ...this.form,
        ...data, 
        clients: this.form.clients || [],
      };
    },
    addClient() {
      if (this.form.id) {
        this.updateClient();
      } else {
        const newClient = { name: this.form.name, phone: this.form.phone, address: this.form.address };
        this.form.clients.push(newClient);
        this.sendClientToServer(newClient)
          .then(() => {
            router.visit('/clients');
          });
      }
    },
    async updateClient() {
      console.log("ID do cliente:", this.form.id);
      console.log("Dados enviados:", 
        this.form
      );
    
      if (!this.form.id) {
        console.error("Erro: ID do cliente não está definido.");
        return;
      }
    
      try {
        const response = await axios.post(`http://localhost:8000/clients/${this.form.id}`, this.form);
        console.log('Cliente atualizado com sucesso:', response.data);
        router.visit('/clients'); 
      } catch (error) {
        console.error('Erro ao atualizar cliente:', error);
      }
    },
    async sendClientToServer(clientData: { name: string; phone: string; address: string }) {
      try {
        const response = await axios.post('http://localhost:8000/clients', clientData, {
          headers: { 'Content-Type': 'application/json' }
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
        this.initializeForm(response.data);
      } catch (error) {
        console.error('Erro ao buscar cliente:', error);
      }
    }
  },
});