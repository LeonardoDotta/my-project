<script>
import { ref } from 'vue'

export default {
  setup() {
    const leftDrawerOpen = ref(false)

    return {
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value
      }
    }
  }
}
</script>

<template>
  <q-layout view="hHh lpR fFf">

    <q-header elevated class="bg-primary text-white" height-hint="98">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" class="q-mr-sm" style="width: 0; padding-left: 1rem;" />

        <q-toolbar-title style="padding-left: 5px;">
          Title
        </q-toolbar-title>
      </q-toolbar>

    </q-header>

    <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
      <div class="div_sidebar">
        <div class="div_buttons">
          <button onclick="location.href='clients'" class="buttons">
            <img src="/icons/people_fill.svg" alt="">
            <div>Clientes</div>
          </button>
          <button onclick="location.href='/messages'" class="buttons">
            <img src="/icons/messages.svg" alt="">
            <div>Mensagens</div>
          </button>
        </div>
        <div class="div_buttons">
          <button onclick="location.href='/logout'" class="buttons">
            <img src="/icons/logout.svg" alt="">
            <div>Logout</div>
          </button>
        </div>
      </div>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>

    <q-footer elevated class="bg-grey-8 text-white">
      <q-toolbar>
        <q-toolbar-title>
          <div>Footer</div>
        </q-toolbar-title>
      </q-toolbar>
    </q-footer>

  </q-layout>
</template>

<style>
.div_sidebar {
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.div_buttons {
  display: flex;
  flex-direction: column;
}

.buttons {
  background-color: white;
  border: none;
  height: 3rem;
  margin-bottom: 1rem;
  border-radius: 10px;
  text-align: justify;
  padding-left: 1rem;
  display: flex;
  gap: 10px;
  align-items: center;
}

.buttons:hover {
  background-color: #e6f3ff;
}

.footer {
  justify-content: center;
}
</style>
