<script>
import { ref } from 'vue'
import { Notify } from 'quasar'

export default {

  setup () {
    const name = ref(null)
    const age = ref(null)
    const accept = ref(false)
    const router = useRouter();

    return {
      name,
      age,
      accept,

      onSubmit() {
        if (accept.value !== true) {
          Notify.create({
          type: "warning",
          message: "Please accept the license and terms",
          });
        } else {
          Notify.create({
          type: "warning",
          message: "Form submitted",
        }); 
        }
      },

      onReset () {
        name.value = null
        age.value = null
        accept.value = false
      }
    }
  }
}
</script>

<template>
  <div class="q-pa-md" style="max-width: 400px">

    <q-form
      @submit="onSubmit()"
      @reset="onReset"
      class="q-gutter-md"
    >
      <q-input
        filled
        v-model="name"
        label="Your name *"
        hint="Name and surname"
        lazy-rules
        :rules="[ val => val && val.length > 0 || 'Please type something']"
      />

      <q-input
        filled
        type="number"
        v-model="age"
        label="Your age *"
        lazy-rules
        :rules="[
          val => val !== null && val !== '' || 'Please type your age',
          val => val > 0 && val < 100 || 'Please type a real age'
        ]"
      />

      <q-toggle v-model="accept" label="I accept the license and terms" />

      <div>
        <q-btn label="Submit" type="submit" color="primary"/>
        <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
      </div>
    </q-form>

  </div>
</template>