<script setup lang="ts">
import { useClientsStore } from '../../stores/Clients'
import { defineProps } from 'vue'

const clientsStore = useClientsStore();

const props = defineProps({
    client: Object
});

clientsStore.initializeForm({...props.client, _method: 'put'});
</script>

<template>
    <div class="div_inputs">
        <q-input filled v-model="clientsStore.form.name" label="Name" placeholder="Name" class="inputs" />
        <q-input filled v-model="clientsStore.form.phone" label="Phone" placeholder="Phone" class="inputs" />
        <q-input filled v-model="clientsStore.form.address" label="Address" placeholder="Address" class="inputs" />
        <q-btn 
            color="primary" 
            label="clientsStore.form.id"
            class="create_client_button"  
            @click="clientsStore.updateClient()" 
        />
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