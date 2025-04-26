<script setup>
import AppLayout             from '@/Layouts/AppLayout.vue';
import DeleteUserForm        from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm    from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

defineProps({
  mustVerifyEmail: Boolean,
  status:          String,
});
</script>

<template>
  <AppLayout title="Profile">
    <section class="py-12 bg-gray-50 dark:bg-gray-900">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-gray-100">Profile</h1>

        <div class="rounded-lg bg-white p-4 shadow sm:p-8 dark:bg-gray-800">
          <UpdateProfileInformationForm
            :must-verify-email="mustVerifyEmail"
            :status="status"
            class="max-w-xl"
          />
        </div>

        <div class="rounded-lg bg-white p-4 shadow sm:p-8 dark:bg-gray-800">
          <UpdatePasswordForm class="max-w-xl" />
        </div>

        <div class="rounded-lg bg-white p-4 shadow sm:p-8 dark:bg-gray-800">
          <DeleteUserForm class="max-w-xl" />
        </div>
      </div>
    </section>
  </AppLayout>
</template>
