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
    { label: 'Ações', field: 'actions', align: 'left' }
];

const pagination = ref({
    rowsPerPage: 0
});
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
        />
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
            <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
        </svg>
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
</style>