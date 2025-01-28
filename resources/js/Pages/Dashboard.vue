<script>
import { ref } from 'vue'

export default {
  setup () {
    const leftDrawerOpen = ref(false)

    return {
      leftDrawerOpen,
      toggleLeftDrawer () {
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
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title>
          Title
        </q-toolbar-title>

      </q-toolbar>

    </q-header>

    <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
      <div class="div_sidebar">
        <div class="div_buttons">
        <button onclick="location.href='/teste1'" class="buttons">
            <router-link to="/teste1">Teste 1</router-link>
        </button>
        <button onclick="location.href='/teste2'" class="buttons">
            <router-link to="/teste2">Teste 2</router-link>
        </button>
        <button onclick="location.href='/teste3'" class="buttons">
            <router-link to="/teste3">Teste 3</router-link>
        </button>
        </div>
        <div class="div_buttons">
        <button onclick="location.href='/logout'" class="buttons">
            <router-link to="/logout">Logout</router-link>
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
          <div>Title</div>
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
}

.buttons:hover {
  background-color: #e6f3ff;
}

.footer {
  justify-content: center;
}
</style>
  
