<script setup lang="ts">
import { ref } from 'vue';
import { route } from 'ziggy-js';
import { router, usePage } from '@inertiajs/vue3';
import axios from 'axios';

const page = usePage();
const clients = ref(page.props.clients);
const val = ref(true);

const columns = [
    { label: '#', field: (row: any) => row.id || '', align: 'left' },
    { label: 'Nome', field: 'name', align: 'left', sortable: true },
    { label: 'Endereço', field: 'address', align: 'left', sortable: true },
    { label: 'Telefone', field: 'phone', align: 'left', sortable: true },
    { label: 'Ações', name: 'actions', align: 'left' },
];

const pagination = ref({
    rowsPerPage: 0
});

const activeRow = ref<any | null>(null);
const showDeleteModal = ref(false);
const selectedClient = ref<any | null>(null);

const goToCreatePage = () => {
  window.location.href = 'clients/create';
};

const handleAction = (row: any) => {
  activeRow.value = activeRow.value === row ? null : row;
};

const openDeleteModal = (client: any) => {
  selectedClient.value = client;
  showDeleteModal.value = true;
};

const deleteRow = async () => {
  if (!selectedClient.value) return;

  try {
    await axios.delete(`/clients/${selectedClient.value.id}`); 
    clients.value = clients.value.filter((client: any) => client.id !== selectedClient.value.id);
  } catch (error) {
    console.error('Erro ao deletar cliente:', error);
    alert('Erro ao deletar cliente');
  } finally {
    showDeleteModal.value = false;
    selectedClient.value = null;
  }
};

const selectedClients = ref<number[]>([]); 

const goToMessageScreen = () => {
    if (selectedClients.value.length === 0) {
        alert("Selecione pelo menos um cliente para enviar a mensagem.");
        return;
    }

    router.visit(route('messages.index'), {
        method: 'get',
        data: { clients: selectedClients.value } 
    });
};
</script>

<template>
  <div>
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <div class="back_button">
        <button style="background: none; border: none;" @click="router.visit('/dashboard')">
          <img src="/icons/back.svg" style="width: 4vw; max-height: 36px;" fill="#0c6cfc" />
        </button>
      </div>
      <div style="display: flex; flex-direction: column;">
        <q-btn color="black" label="Adicionar Cliente" style="margin: 1rem;" @click="goToCreatePage" />
        <q-btn color="primary" label="Enviar Mensagem" style="margin: 1rem;" @click="goToMessageScreen" />
      </div>
    </div>
    <div class="q-pa-md">
      <q-table
        class="my-sticky-virtscroll-table"
        virtual-scroll
        flat
        bordered
        v-model:pagination="pagination"
        :rows-per-page-options="[0]"
        :virtual-scroll-sticky-size-start="48"
        row-key="id"
        title="Clients"
        :rows="clients"
        :columns="columns"
      >
        <template #body-cell-actions="props">
          <q-td class="actions_and_checkbox">
            <div>
              <button class="actions_button" @click="handleAction(props.row)">
                <img src="/icons/dots.svg" width="16" height="16" />
              </button>
  
              <div v-if="activeRow === props.row" class="dropdown">
                <q-btn :href="route('clients.edit', { id: props.row.id })">Editar</q-btn>
                <q-btn @click="openDeleteModal(props.row)">Deletar</q-btn>
              </div>
            </div>
            <div>
              <q-checkbox 
                v-model="selectedClients" 
                :val="props.row.id" 
                style="width: 5%; margin-right: 2rem;"
              />
            </div>
          </q-td>
        </template>
      </q-table>
    </div>

    <q-dialog v-model="showDeleteModal">
      <q-card class="deletion_modal">
        <q-card-section>
          <h3 style="text-align: center;">Confirmar Exclusão</h3>
          <p>Tem certeza que deseja excluir este cliente?</p>
        </q-card-section>
        
        <q-card-actions align="right">
          <q-btn flat label="Cancelar" color="primary" @click="showDeleteModal = false" />
          <q-btn flat label="Deletar" color="red" @click="deleteRow" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<style>
.create_button {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 2%;
}

.actions_and_checkbox {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.actions_button {
    border: none;
    background: none;
    border-radius: 10px;
}

.actions_button:hover {
    background-color: #f7f7f7
}

.dropdown {
    position: absolute;
    background-color: white;
    border: 1px solid #ccc;
    top: 20px;
    right: 0;
    width: 10vw;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: center;
    flex-direction: column;
    z-index: 1000;
}

.dropdown ul {
    padding: 0;
    margin: 0;
    list-style: none;
}

.dropdown ul li {
    padding: 8px;
    cursor: pointer;
}

.dropdown ul li:hover {
    background-color: #f0f0f0;  
}

.deletion_modal {
    overflow: hidden !important;
}
</style>