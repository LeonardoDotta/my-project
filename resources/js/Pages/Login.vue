<script lang="ts">
import { Notify } from 'quasar';
import { useForm } from '@inertiajs/inertia-vue3';
import { route } from 'ziggy-js';

export default {
  setup() {
    const form = useForm({
      name: '',
      age: '',
    });

    const onSubmit = () => {
      form.get(route('dashboard'), {
        onSuccess: () => {
          Notify.create({
            type: 'positive',
            message: 'Form submitted successfully',
          });
        },
      });
    };

    const onReset = () => {
      form.reset();
    };

    return {
      form,
      onSubmit,
      onReset,
    };
  },
};
</script>

<template>
  <div class="login">
    <q-form
      @submit.prevent="onSubmit"
      @reset="onReset"
      style="width: 20%;"
    >
      <q-input
        filled
        v-model="form.name"
        label="Your name *"
        hint="Name and surname"
        lazy-rules
        :rules="[val => val && val.length > 0 || 'Please type your name']"
      />

      <q-input
        filled
        v-model="form.age"
        label="Your email *"
        lazy-rules
        :rules="[
          val => val !== null && val !== '' || 'Please type your email',
          val => val > 0 || 'Please type a real email'
        ]"
      />

      <div>
        <q-btn label="Submit" type="submit" color="primary" />
        <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
      </div>
    </q-form>
  </div>
</template>

<style css>
.login {
    display: flex;
    flex-direction: row;
    justify-content: center;
    padding-top: 15%;
    height: 100vh;
    background: azure;
}
</style>
