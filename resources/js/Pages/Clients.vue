<script setup lang="ts">
import { ref } from 'vue';
import { useClientsStore } from '../../stores/Clients';
import { storeToRefs } from 'pinia'

// const name = ref<string>('');
const phone = ref<string>('');
const address = ref<string>('');
const store = useClientsStore();
const { name, doubleCount } = storeToRefs(store)
name // will always be "Eduardo"
doubleCount // will always be 0

setTimeout(() => {
    store.increment()
}, 1000)
</script>

<template>
    <div>
        Clientes
        <div class="div_inputs">
            <q-input filled v-model="name" label="Name" placeholder="Name" class="inputs" />
            <q-input filled v-model="phone" label="Phone" placeholder="Phone" class="inputs" />
            <q-input filled v-model="address" label="Address" placeholder="Address" class="inputs" />
        </div>
    </div>
</template>

<style>
.div_inputs {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.inputs {
    width: 25%;
}
</style>