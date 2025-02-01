<script setup lang="ts">
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

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

const handleAction = (row: any) => {
  activeRow.value = activeRow.value === row ? null : row;
};

const editRow = () => {
  if (activeRow.value) {
    console.log('Editando', activeRow.value);
  }
  activeRow.value = null;  
};

const deleteRow = () => {
  if (activeRow.value) {
    console.log('Deletando', activeRow.value);
  }
  activeRow.value = null;  
};
</script>

<template>
    <div class="title">
      Clientes
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
                <ul>
                  <li @click="editRow">Editar</li>
                  <li @click="deleteRow">Deletar</li>
                </ul>
              </div>
            </div>
          </q-td>
        </template>
      </q-table>
    </div>
  </template>

<style>
.title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
    display: flex;
    justify-content: center;
    padding-top: 2%;
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
</style>