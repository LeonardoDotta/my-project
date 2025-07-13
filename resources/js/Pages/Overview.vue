<script setup lang="ts">
import { route } from 'ziggy-js';
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const selectedClients = ref([]);
const orders = ref<{ [key: number]: string }>({});
const overview = ref<Array<{ id: number; name: string; order: string; phone: string; address: string }>>([]);

onMounted(() => {
    const clientIds = page.props.clients;
    console.log(clientIds);

    if (!clientIds || clientIds.length === 0) {
        console.warn("Nenhum cliente foi passado.");
        return;
    }

    selectedClients.value = clientIds; 
});

const createOverview = () => {
    if (selectedClients.value.length === 0) {
        alert("Selecione pelo menos um cliente para criar o resumo.");
        return;
    }

    router.visit(route('overview.index'), {
        preserveState: true,
        preserveScroll: true,
        only: ['clients']
    });

    overview.value = selectedClients.value.map(client => {
        return {
            id: client.id,
            name: client.name,
            order: orders.value[client.id] || 'Nenhum pedido informado',
            phone: client.phone || 'Telefone não informado',
            address: client.address || 'Endereço não informado'
        };
    });
};

const copyToClipboard = (item: {
  name: string;
  phone: string;
  address: string;
  order: string;
}) => {
  const content = `Nome: ${item.name}
Telefone: ${item.phone}
Endereço: ${item.address}
Pedido: ${item.order}`;

  navigator.clipboard.writeText(content)
    .then(() => {
      alert('Resumo copiado com sucesso!');
    })
    .catch(err => {
      console.error('Erro ao copiar texto:', err);
    });
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
                    <q-input
                        dense
                        filled
                        v-model="orders[client.id]"
                        placeholder="Pedido:"
                        class="q-mt-sm"
                    />
                </q-item-section>
            </q-item>
        </div>

        <div class="div_messages">
            <div>
                <q-btn color="primary" label="Criar Resumo" @click="createOverview" />
            </div>
            <div v-if="overview.length" class="q-mt-lg q-pa-md">
                <h6>Resumo dos Pedidos:</h6>

                <div
                    v-for="item in overview"
                    :key="item.id"
                    class="q-mb-md"
                >
                    <q-card class="q-pa-md shadow-2">
                    <q-card-section>
                        <q-item-label><strong>Nome:</strong> {{ item.name }}</q-item-label>
                        <q-item-label><strong>Telefone:</strong> {{ item.phone }}</q-item-label>
                        <q-item-label><strong>Endereço:</strong> {{ item.address }}</q-item-label>
                        <q-item-label><strong>Pedido:</strong> {{ item.order }}</q-item-label>
                    </q-card-section>

                    <q-card-actions align="right">
                        <q-btn
                        label="Copiar"
                        color="primary"
                        size="sm"
                        @click="copyToClipboard(item)"
                        />
                    </q-card-actions>
                    </q-card>
                </div>
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
