<script setup>
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const props = defineProps({
  search:    String,
  routeName: String,
  disabled:  { type: Boolean, default: false },
});

const searchForm = useForm({ search: props.search });
watch(() => props.search, newSearch => (searchForm.search = newSearch));

const submit = () => {
  searchForm.get(route(props.routeName), {
    preserveState: true,
    preserveScroll: true,
  });
};
</script>

<template>
  <form @submit.prevent="submit" class="w-full">
    <label for="nav-search" class="sr-only">Search books</label>
    <div class="relative">
      <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" viewBox="0 0 20 20" fill="none">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
        </svg>
      </div>
      <input
        id="nav-search"
        type="search"
        v-model="searchForm.search"
        :disabled="disabled"
        placeholder="Search by title…"
        class="h-9 w-full rounded-md border border-gray-300 bg-gray-50 pl-9 pr-2 text-sm placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
      />
    </div>
  </form>
</template>
