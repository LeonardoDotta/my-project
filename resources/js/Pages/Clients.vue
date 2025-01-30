<script setup lang="ts">
import { ref } from 'vue';

import { useClientsStore } from '../../stores/Clients';
import { storeToRefs } from 'pinia'

// const name = ref<string>('');
// const phone = ref<string>('');
// const address = ref<string>('');

const store = useClientsStore();
const { name, address, phone } = storeToRefs(store)
name
address
phone

type Column = {
    name: string;
    label: string;
    field: string | ((row: any) => any);
    align?: string;
    required?: boolean;
    format?: (val: any) => string;
    sortable?: boolean;
    sort?: (a: any, b: any) => number;
};

type Row = {
    name: string;
    calories: number;
    fat: number;
    carbs: number;
    protein: number;
    sodium: number;
    calcium: string;
    iron: string;
    index?: number;
};

const columns: Column[] = [
    { name: 'index', label: '#', field: 'index' },
    { name: 'name', required: true, label: 'Dessert (100g serving)', align: 'left', field: (row) => row.name, format: (val) => `${val}`, sortable: true },
    { name: 'calories', align: 'center', label: 'Calories', field: 'calories', sortable: true },
    { name: 'fat', label: 'Fat (g)', field: 'fat', sortable: true },
    { name: 'carbs', label: 'Carbs (g)', field: 'carbs' },
    { name: 'protein', label: 'Protein (g)', field: 'protein' },
    { name: 'sodium', label: 'Sodium (mg)', field: 'sodium' },
    { name: 'calcium', label: 'Calcium (%)', field: 'calcium', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
    { name: 'iron', label: 'Iron (%)', field: 'iron', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) }
];

const seed: Row[] = [
    { name: 'Frozen Yogurt', calories: 159, fat: 6.0, carbs: 24, protein: 4.0, sodium: 87, calcium: '14%', iron: '1%' },
    { name: 'Ice cream sandwich', calories: 237, fat: 9.0, carbs: 37, protein: 4.3, sodium: 129, calcium: '8%', iron: '1%' },
    { name: 'Eclair', calories: 262, fat: 16.0, carbs: 23, protein: 6.0, sodium: 337, calcium: '6%', iron: '7%' },
    { name: 'Cupcake', calories: 305, fat: 3.7, carbs: 67, protein: 4.3, sodium: 413, calcium: '3%', iron: '8%' },
    { name: 'Gingerbread', calories: 356, fat: 16.0, carbs: 49, protein: 3.9, sodium: 327, calcium: '7%', iron: '16%' },
    { name: 'Jelly bean', calories: 375, fat: 0.0, carbs: 94, protein: 0.0, sodium: 50, calcium: '0%', iron: '0%' },
    { name: 'Lollipop', calories: 392, fat: 0.2, carbs: 98, protein: 0, sodium: 38, calcium: '0%', iron: '2%' },
    { name: 'Honeycomb', calories: 408, fat: 3.2, carbs: 87, protein: 6.5, sodium: 562, calcium: '0%', iron: '45%' },
    { name: 'Donut', calories: 452, fat: 25.0, carbs: 51, protein: 4.9, sodium: 326, calcium: '2%', iron: '22%' },
    { name: 'KitKat', calories: 518, fat: 26.0, carbs: 65, protein: 7, sodium: 54, calcium: '12%', iron: '6%' }
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
    <div class="div_inputs">
        <q-input filled v-model="name" label="Name" placeholder="Name" class="inputs" />
        <q-input filled v-model="phone" label="Phone" placeholder="Phone" class="inputs" />
        <q-input filled v-model="address" label="Address" placeholder="Address" class="inputs" />
        <q-btn color="primary" label="Create Client" class="create_client_button" />
    </div>
    <div class="q-pa-md">
        <q-table class="my-sticky-virtscroll-table" virtual-scroll flat bordered v-model:pagination="pagination"
            :rows-per-page-options="[0]" :virtual-scroll-sticky-size-start="48" row-key="index" title="Treats"
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

.div_inputs {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 3%;
}

.inputs {
    width: 25%;
}

.create_client_button {
    margin-top: 10px;
}
</style>