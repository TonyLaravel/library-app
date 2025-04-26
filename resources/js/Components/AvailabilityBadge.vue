<script setup>
const { available } = defineProps({ available: Boolean });
</script>

<template>
  <span
    class="absolute right-2 top-2 rounded-full px-2.5 py-0.5 text-xs font-semibold"
    :class="
      available
        ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300'
        : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300'
    "
  >
    {{ available ? 'Available' : 'Checked out' }}
  </span>
</template>
