<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const text = ref('');

const saveMessage = async () => {
    if (text.value.trim() === '') {
        alert('Por favor, digite uma mensagem antes de salvar.');
        return;
    }

    try {
        await router.post(route('messages.store'), { content: text.value });

        router.post('send-messages');

        router.visit('clients');
    } catch (error) {
        console.error('Erro ao processar a requisição:', error);
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