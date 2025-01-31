<script setup lang="ts">
import { storeToRefs } from 'pinia'
import { useClientsStore } from '../../stores/Clients'

const store = useClientsStore();

const { name, phone, address } = storeToRefs(store)

const saveClient = () => {
  store.addClient();
};
</script>

<template>
    <div class="div_inputs">
        <q-input filled v-model="name" label="Name" placeholder="Name" class="inputs" />
        <q-input filled v-model="phone" label="Phone" placeholder="Phone" class="inputs" />
        <q-input filled v-model="address" label="Address" placeholder="Address" class="inputs" />
        <q-btn color="primary" label="Create Client" class="create_client_button" @click="saveClient" />
    </div>
</template>

<style>
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