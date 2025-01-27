<script lang="ts">
import { Notify } from 'quasar';
import { useForm } from '@inertiajs/inertia-vue3';
import { route } from 'ziggy-js';

export default {
  setup() {
    const form = useForm({
      name: '',
      age: '',
      accept: false,
    });

    const onSubmit = () => {
      if (!form.accept) {
        Notify.create({
          type: 'negative',
          message: 'Please accept the license and terms',
        });
        return;
      }

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
  <div class="q-pa-md" style="max-width: 400px">
    <q-form
      @submit.prevent="onSubmit"
      @reset="onReset"
      class="q-gutter-md"
    >
      <q-input
        filled
        v-model="form.name"
        label="Your name *"
        hint="Name and surname"
        lazy-rules
        :rules="[val => val && val.length > 0 || 'Please type something']"
      />

      <q-input
        filled
        type="number"
        v-model="form.age"
        label="Your age *"
        lazy-rules
        :rules="[
          val => val !== null && val !== '' || 'Please type your age',
          val => val > 0 && val < 100 || 'Please type a real age'
        ]"
      />

      <q-toggle
        v-model="form.accept"
        label="I accept the license and terms"
      />

      <div>
        <q-btn label="Submit" type="submit" color="primary" />
        <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
      </div>
    </q-form>
  </div>
</template>
