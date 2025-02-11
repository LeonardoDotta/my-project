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
        router.post(route('messages.store'), { content: text.value });
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

const offline = ref([
  { id: 5, name: 'Brunhilde Panswick', email: 'bpanswick4@csmonitor.com', avatar: 'avatar2.jpg' },
  { id: 6, name: 'Winfield Stapforth', email: 'wstapforth5@pcworld.com', avatar: 'avatar6.jpg' }
]);
</script>

<template>
    <div class="div_contacts_and_messages">
        <div class="div_contacts">
            <q-toolbar class="bg-primary text-white shadow-2">
            <q-toolbar-title>Contacts</q-toolbar-title>
            </q-toolbar>

            <q-list bordered>
            <q-item v-for="contact in contacts" :key="contact.id" class="q-my-sm" clickable v-ripple>
                <q-item-section avatar>
                <q-avatar color="primary" text-color="white">
                    {{ contact.letter }}
                </q-avatar>
                </q-item-section>

                <q-item-section>
                <q-item-label>{{ contact.name }}</q-item-label>
                <q-item-label caption lines="1">{{ contact.email }}</q-item-label>
                </q-item-section>

                <q-item-section side>
                <q-icon name="chat_bubble" color="green" />
                </q-item-section>
            </q-item>

            <q-separator />
            <q-item-label header>Offline</q-item-label>

            <q-item v-for="contact in offline" :key="contact.id" class="q-mb-sm" clickable v-ripple>
                <q-item-section avatar>
                <q-avatar>
                    <img :src="`https://cdn.quasar.dev/img/${contact.avatar}`">
                </q-avatar>
                </q-item-section>

                <q-item-section>
                <q-item-label>{{ contact.name }}</q-item-label>
                <q-item-label caption lines="1">{{ contact.email }}</q-item-label>
                </q-item-section>

                <q-item-section side>
                <q-icon name="chat_bubble" color="grey" />
                </q-item-section>
            </q-item>
            </q-list>
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
                <q-btn color="primary" label="Salvar Mensagem" @click="saveMessage" />
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