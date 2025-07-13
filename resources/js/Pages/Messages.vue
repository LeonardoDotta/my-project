<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const text = ref('Olá, {nome}, tudo bem?'); 
const selectedClients = ref([]);
const page = usePage();

onMounted(() => {
    const clientIds = page.props.clients;
    console.log(clientIds);

    if (!clientIds || clientIds.length === 0) {
        console.warn("Nenhum cliente foi passado.");
        return;
    }

    selectedClients.value = clientIds; 
});

const generateMessages = () => {
    return selectedClients.value.map(client => {
        const firstName = client.name.split(' ')[0]; 
        return {
            id: client.id,
            name: firstName,
            message: text.value.replace(/{nome}/g, firstName) 
        };
    });
};

const saveMessage = async () => {
    if (text.value.trim() === '') {
        alert('Por favor, digite uma mensagem antes de salvar.');
        return;
    }

    if (selectedClients.value.length === 0) {
        alert('Nenhum cliente selecionado.');
        return;
    }

    const messagesToSend = generateMessages();

    try {
        await router.post(route('messages.store'), { messages: messagesToSend });
        
        await router.post(route('messages.send'), { messages: messagesToSend });
        
        router.visit(route('clients'));

        alert("Mensagens enviadas com sucesso!");
        text.value = '';
    } catch (error) {
        console.error('Erro ao processar a requisição:', error);
    }
};
</script>

<template>
    <div class="div_contacts_and_messages">
        <div style="margin-top: 2rem; margin-left: 2rem;">
            <q-toolbar class="bg-primary text-white shadow-2">
                <q-toolbar-title style="text-align: center;">Selected Contacts</q-toolbar-title>
            </q-toolbar>
            <q-item v-for="client in selectedClients" :key="client.id" clickable v-ripple class="div_contacts"> 
                <q-item-section avatar class="each_contact">
                    <q-avatar color="primary" text-color="white" class="avatar">
                        {{ client.name.charAt(0) }}
                    </q-avatar>
                </q-item-section>
                <q-item-section>
                    <q-item-label>{{ client.name }}</q-item-label>
                </q-item-section>
            </q-item>
        </div>

        <div class="div_messages">
            <div class="div_input_messages">
                <q-input
                    v-model="text"
                    filled
                    type="textarea"
                />
            </div>
            <div>
                <q-btn color="primary" label="Salvar e Enviar Mensagem" @click="saveMessage" />
            </div>
        </div>
    </div>
</template>

<style>
.div_contacts_and_messages {
    display: inline-flex;
    align-items: center;
    width: -webkit-fill-available;
    justify-content: space-between;
}

.div_contacts {
    max-width: 300px;
    display: flex;
    align-items: center;
    background: rgba(0, 0, 0, 0.05);
}

.each_contact {
    width: 0;
}

.avatar {
    display: flex;
    justify-content: center;
}

.div_messages {
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

.q-toolbar {
    width: auto !important;
    max-width: 300px !important;
}
</style>
