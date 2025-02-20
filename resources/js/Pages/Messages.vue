<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';

const text = ref('');
const selectedClients = ref([]);
const page = usePage();

onMounted(async () => {
    const clientIds = page.props.clients; 
    console.log(clientIds, selectedClients);

    if (!clientIds || clientIds.length === 0) {
        console.warn("Nenhum cliente foi passado.");
        return;
    }

    try {
        const response = await axios.get('/clients/get-by-ids', { params: { ids: clientIds } });
        selectedClients.value = response.data;
    } catch (error) {
        console.error("Erro ao buscar clientes:", error.response || error.message);
    }
});

const saveMessage = async () => {
    if (text.value.trim() === '') {
        alert('Por favor, digite uma mensagem antes de salvar.');
        return;
    }

    if (selectedClients.value.length === 0) {
        alert('Nenhum cliente selecionado.');
        return;
    }

    try {
        await axios.post('/send-messages', {
            message: text.value,
            clients: selectedClients.value.map(client => client.id) 
        });

        alert("Mensagem enviada com sucesso!");
    } catch (error) {
        console.error("Erro ao enviar mensagem:", error);
    }
};

const contacts = ref([
  { id: 1, name: 'Ruddy Jedrzej', email: 'rjedrzej0@discuz.net', letter: 'R' },
  { id: 2, name: 'Mallorie Alessandrini', email: 'malessandrini1@marketwatch.com', letter: 'M' },
  { id: 3, name: 'Elisabetta Wicklen', email: 'ewicklen2@microsoft.com', letter: 'E' },
  { id: 4, name: 'Seka Fawdrey', email: 'sfawdrey3@wired.com', letter: 'S' }
]);
</script>

<template>
    <div class="div_contacts_and_messages">
        <div class="div_contacts">
            <q-toolbar class="bg-primary text-white shadow-2">
            <q-toolbar-title>Contacts</q-toolbar-title>
            </q-toolbar>
            <q-item v-for="contact in contacts" :key="contact.id" clickable v-ripple>
                <q-item-section avatar class="each_contact">
                <q-avatar color="primary" text-color="white" class="avatar">
                    {{ contact.letter }}
                </q-avatar>
                </q-item-section>
                <q-item-section>
                <q-item-label>{{ contact.name }}</q-item-label>
                <q-item-label caption lines="1">{{ contact.email }}</q-item-label>
                </q-item-section>
            </q-item>
        </div>
        <div class="div_messages">
            <div>
                Digitar mensagem
            </div>
            <div class="div_input_messages">
            <q-input
                v-model="text"
                filled
                type="textarea"
            />
            </div>
            <div>
                <q-btn color="primary" label="Salvar e Enviar WhatsApp" @click="saveMessage" />
            </div>
        </div>
    </div>
</template>

<style>
.div_contacts_and_messages {
    display: flex;
}

.div_contacts {
    padding: 16px;
    max-width: 350px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.each_contact {
    width: 0;
}

.avatar {
    display: flex;
    justify-content: center;
}

.div_messages{
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 10%;
    width: 100%;
}

.div_input_messages {
    width: 40%;
    padding: 2%;
}
</style>