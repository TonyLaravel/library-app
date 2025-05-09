<script setup>
import DangerButton      from '@/Components/DangerButton.vue'
import SecondaryButton   from '@/Components/SecondaryButton.vue'
import InputLabel        from '@/Components/InputLabel.vue'
import InputError        from '@/Components/InputError.vue'
import TextInput         from '@/Components/TextInput.vue'
import Modal             from '@/Components/Modal.vue'
import { useForm }       from '@inertiajs/vue3'
import { ref, nextTick } from 'vue'

const confirmingUserDeletion = ref(false)
const passwordInput          = ref(null)

const form = useForm({ password: '' })

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true
  nextTick(() => passwordInput.value?.focus())
}

const deleteUser = () => {
  form.delete(route('profile.destroy'), {
    preserveScroll: true,
    onSuccess: closeModal,
    onError  : () => passwordInput.value?.focus(),
    onFinish : () => form.reset(),
  })
}

const closeModal = () => {
  confirmingUserDeletion.value = false
  form.clearErrors()
  form.reset()
}
</script>

<template>
  <section class="space-y-6">
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Delete Account
      </h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Once your account is deleted, all of its resources and data will be permanently removed.
        Please download anything you wish to keep before proceeding.
      </p>
    </header>

    <DangerButton @click="confirmUserDeletion">
      Delete Account
    </DangerButton>

    <Modal :show="confirmingUserDeletion" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Confirm account deletion
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          This action is irreversible. Enter your password to confirm.
        </p>

        <div class="mt-6">
          <InputLabel for="password" value="Password" class="sr-only" />

          <TextInput
            id="password"
            ref="passwordInput"
            v-model="form.password"
            type="password"
            placeholder="Password"
            class="mt-1 block w-3/4 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
            @keyup.enter="deleteUser"
          />

          <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal">
            Cancel
          </SecondaryButton>

          <DangerButton
            class="ms-3"
            :disabled="form.processing"
            :class="{ 'opacity-25': form.processing }"
            @click="deleteUser"
          >
            Delete Account
          </DangerButton>
        </div>
      </div>
    </Modal>
  </section>
</template>
