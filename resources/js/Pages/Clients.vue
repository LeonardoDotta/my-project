<script setup lang="ts">
import { ref } from 'vue';
import { route } from 'ziggy-js';
import { router, usePage } from '@inertiajs/vue3';
import axios from 'axios';

const page = usePage();
const clients = ref(page.props.clients);

const columns = [
  { label: '#', field: (row: any) => row.id || '', align: 'left' },
  { label: 'Nome', field: 'name', align: 'left', sortable: true },
  { label: 'Endereço', field: 'address', align: 'left', sortable: true },
  { label: 'Telefone', field: 'phone', align: 'left', sortable: true },
  { label: 'Ações', name: 'actions', align: 'left' },
  { name: 'clientStatus', label: 'Status', field: 'is_client', sortable: true, align: 'left', style: 'width: 10%' },
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

const goToOverviewScreen = () => {
  if (selectedClients.value.length === 0) {
    alert("Selecione pelo menos um cliente para criar o resumo.");
    return;
  }

  router.visit(route('overview.index'), {
    method: 'get',
    data: { clients: selectedClients.value }
  });
};

async function toggleClientStatus(row: any) {
  row.is_client = !row.is_client;
  try {
    await axios.put(`/clients/${row.id}/toggleStatus`, {
      is_client: row.is_client
    });
  } catch (error) {
    console.error('Erro ao atualizar status:', error);
    alert('Erro ao atualizar status do cliente');
    row.is_client = !row.is_client;
  }
}

function getRowClass(row: any) {
  return row.is_client ? 'row-green' : 'row-red';
}
</script>

<template>
  <div>
    <div style="display: flex;justify-content: space-between; padding: 0.5rem;">
      <div style="padding-top: 0.5rem ; padding-left: 0;">
        <button style="background: none; border: none; padding-left: 0 !important;" @click="router.visit('/dashboard')">
          <img src="/icons/back.svg" style="width: 4vw; max-height: 36px;" />
        </button>
      </div>
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; flex-direction: row;">
          <q-btn color="primary" label="Adicionar Cliente" style="margin: 0.5rem;" @click="goToCreatePage" />
          <q-btn color="primary" label="Enviar Mensagem" style="margin: 0.5rem;" @click="goToMessageScreen" />
          <q-btn color="primary" label="Criar Resumo" style="margin: 0.5rem;" @click="goToOverviewScreen" />
        </div>
      </div>
    </div>

    <div style="display: flex; justify-content: flex-end; padding: 0 2rem 1rem 2rem; font-weight: bold;">
      Clientes Selecionados: ({{ selectedClients.length }})
    </div>

    <div class="q-pa-md" style="display: flex; justify-content: center; padding-top: 1rem;">
      <q-table
        class="my-sticky-virtscroll-table"
        flat
        bordered
        v-model:pagination="pagination"
        :rows-per-page-options="[50]"
        row-key="id"
        title="Clients"
        :rows="clients"
        :columns="columns"
        :row-class="getRowClass"
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
            <div style="display: contents;">
              <q-checkbox
                v-model="selectedClients"
                :val="props.row.id"
                style="width: 5%; margin-right: 2rem;"
              />
            </div>
          </q-td>
        </template>

        <template #body-cell-clientStatus="props">
          <q-td :props="props">
            <q-btn
              :label="props.row.is_client ? 'Cliente' : 'Não Cliente'"
              :color="props.row.is_client ? 'positive' : 'negative'"
              size="sm"
              outline
              @click="toggleClientStatus(props.row)"
            />
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
  background-color: #f7f7f7;
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

.q-table tr.row-green {
  background-color: #e6f4ea !important;
}

.q-table tr.row-red {
  background-color: #fcebea !important;
}
</style>
