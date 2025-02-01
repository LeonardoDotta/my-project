<script setup lang="ts">
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import axios from 'axios';

const page = usePage();
const clients = ref(page.props.clients);

const columns = [
    { label: '#', field: (row: any) => row.id || '', align: 'left' },
    { label: 'Nome', field: 'name', align: 'left', sortable: true },
    { label: 'Endereço', field: 'address', align: 'left', sortable: true },
    { label: 'Telefone', field: 'phone', align: 'left', sortable: true },
    { label: 'Ações', name: 'actions', align: 'left' }
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
</script>

<template>
  <div>
    <div class="create_button">
      <q-btn color="primary" label="Adicionar Cliente" @click="goToCreatePage" />
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
          <q-td>
            <div>
              <button class="actions_button" @click="handleAction(props.row)">
                <img src="/icons/dots.svg" width="16" height="16" />
              </button>
  
              <div v-if="activeRow === props.row" class="dropdown">
                <q-btn :href="route('clients.edit', { id: props.row.id })">Editar</q-btn>
                <q-btn @click="openDeleteModal(props.row)">Deletar</q-btn>
              </div>
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
    justify-content: flex-end;
    padding: 2%;
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