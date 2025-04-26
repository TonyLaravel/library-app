<script setup>
import AppLayout      from '@/Layouts/AppLayout.vue';
import Checkbox       from '@/Components/Checkbox.vue';
import InputError     from '@/Components/InputError.vue';
import InputLabel     from '@/Components/InputLabel.vue';
import PrimaryButton  from '@/Components/PrimaryButton.vue';
import TextInput      from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
  canResetPassword: Boolean,
  status:          String,
});

const form = useForm({
  email:    '',
  password: '',
  remember: false,
});

function submit() {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
}
</script>

<template>
  <!-- wrap everything in the site-wide layout -->
  <AppLayout title="Log in">
    <div class="mx-auto mt-12 max-w-md px-6 py-8 rounded-lg bg-white shadow dark:bg-gray-800">
      <h1 class="mb-6 text-center text-2xl font-bold">Welcome back</h1>

      <div v-if="status" class="mb-4 rounded bg-emerald-100 p-3 text-sm text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
        {{ status }}
      </div>

      <form @submit.prevent="submit" class="space-y-6">
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
            autocomplete="current-password"
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <!-- remember -->
        <div class="flex items-center">
          <Checkbox name="remember" v-model:checked="form.remember" />
          <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Remember me</span>
        </div>

        <!-- actions -->
        <div class="flex items-center justify-between">
          <Link
            v-if="canResetPassword"
            :href="route('password.request')"
            class="text-sm text-blue-600 hover:underline dark:text-blue-400"
          >
            Forgot password?
          </Link>

          <PrimaryButton :disabled="form.processing" :class="{ 'opacity-25': form.processing }">
            Log in
          </PrimaryButton>
        </div>
      </form>

      <!-- divider & register link -->
      <div class="mt-8">
        <div class="flex items-center">
          <span class="flex-1 border-t border-gray-300 dark:border-gray-600"></span>
          <span class="mx-3 text-sm text-gray-500 dark:text-gray-400">OR</span>
          <span class="flex-1 border-t border-gray-300 dark:border-gray-600"></span>
        </div>

        <div class="mt-4 text-center">
          <Link href="/register" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-400">
            Create a new account
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
