<script setup>
import AppLayout      from '@/Layouts/AppLayout.vue';
import InputError     from '@/Components/InputError.vue';
import InputLabel     from '@/Components/InputLabel.vue';
import PrimaryButton  from '@/Components/PrimaryButton.vue';
import TextInput      from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  name:                  '',
  email:                 '',
  password:              '',
  password_confirmation: '',
  role:                  'Customer',
});

function submit() {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
}
</script>

<template>
  <AppLayout title="Register">
    <div class="mx-auto mt-12 max-w-md rounded-lg bg-white px-6 py-8 shadow dark:bg-gray-800">
      <h1 class="mb-6 text-center text-2xl font-bold">Create an account</h1>

      <form @submit.prevent="submit" class="space-y-6">
        <!-- name -->
        <div>
          <InputLabel for="name" value="Name" />
          <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
            autocomplete="name"
          />
          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <!-- email -->
        <div>
          <InputLabel for="email" value="Email" />
          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autocomplete="username"
          />
          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <!-- password -->
        <div>
          <InputLabel for="password" value="Password" />
          <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="new-password"
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <!-- confirm -->
        <div>
          <InputLabel for="password_confirmation" value="Confirm password" />
          <TextInput
            id="password_confirmation"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password_confirmation"
            required
            autocomplete="new-password"
          />
          <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>

        <!-- role -->
        <div>
          <InputLabel value="Role" />
          <select
            v-model="form.role"
            class="mt-1 block w-full rounded-lg border-gray-300 text-sm
                   focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700
                   dark:text-white"
          >
            <option value="Customer">Customer</option>
            <option value="Librarian">Librarian</option>
          </select>
          <InputError class="mt-2" :message="form.errors.role" />
        </div>

        <!-- actions -->
        <div class="flex items-center justify-between">
          <Link
            href="/login"
            class="text-sm text-blue-600 hover:underline dark:text-blue-400"
          >
            Already registered?
          </Link>

          <PrimaryButton :disabled="form.processing" :class="{ 'opacity-25': form.processing }">
            Register
          </PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
