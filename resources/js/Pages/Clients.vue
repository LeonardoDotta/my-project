<script setup lang="ts">
import { ref } from 'vue';

type Column = {
    label: string;
    field: string | ((row: any) => any);
    align?: string;
    required?: boolean;
    format?: (val: any) => string;
    sortable?: boolean;
};

type Row = {
    name: string;
    index?: number;
    address: string;
    phone: string;
};

const columns = [
    { label: '#', field: 'id' },
    { label: 'Nome', field: 'name', align: 'left', sortable: true },
    { label: 'Endereço', field: 'address', align: 'left', sortable: true },
    { label: 'Telefone', field: 'phone', align: 'left', sortable: true }
];

const seed: Row[] = [
];

let rows: Row[] = [];
for (let i = 0; i < 100; i++) {
    rows = rows.concat(seed.map(r => ({ ...r })));
}
rows.forEach((row, index) => {
    row.index = index;
});

const pagination = ref({
    rowsPerPage: 0
});
</script>

<template>
    <div class="title">
        Clientes
    </div>
    <div class="q-pa-md">
        <q-table class="my-sticky-virtscroll-table" virtual-scroll flat bordered v-model:pagination="pagination"
            :rows-per-page-options="[0]" :virtual-scroll-sticky-size-start="48" row-key="index" title="Clients"
            :rows="rows" :columns="columns" />
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