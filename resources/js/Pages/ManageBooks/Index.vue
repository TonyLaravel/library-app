<script setup>
import { Link, router } from '@inertiajs/vue3';
import AppLayout        from '@/Layouts/AppLayout.vue';

const { books } = defineProps({ books: Object });

function destroy(id) {
  if (confirm('Delete this book?')) {
    router.delete(route('manage.books.destroy', id));
  }
}
</script>

<template>
  <AppLayout title="Manage Books">
    <div class="mx-auto max-w-screen-xl p-6">
      <!-- header bar -->
      <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">Manage Books</h1>

        <Link
          href="/manage/books/create"
          class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
        >
          Add new
        </Link>
      </div>

      <!-- table -->
      <table class="min-w-full border text-sm">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-3 py-2 text-left">Title</th>
            <th class="px-3 py-2">Author</th>
            <th class="w-32 px-3 py-2">Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="b in books.data" :key="b.id" class="border-t">
            <td class="px-3 py-2">{{ b.title }}</td>
            <td class="px-3 py-2">{{ b.author }}</td>
            <td class="space-x-2 px-3 py-2 text-center">
              <Link
                :href="route('manage.books.edit', b.id)"
                class="text-blue-600 hover:underline"
              >
                Edit
              </Link>

              <button
                @click="destroy(b.id)"
                class="text-red-600 hover:underline"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- pagination -->
      <nav
        v-if="books.links.length > 3"
        class="mt-6 flex justify-center"
        aria-label="Pagination"
      >
        <ul
          class="inline-flex -space-x-px overflow-hidden rounded-lg border
                 border-gray-200 bg-white text-sm shadow
                 dark:border-gray-700 dark:bg-gray-800"
        >
          <li v-for="link in books.links" :key="link.label">
            <Link
              :href="link.url || '#'"
              v-html="link.label"
              class="block px-3 py-2 leading-tight"
              :class="[
                link.active
                  ? 'z-10 bg-blue-600 text-white hover:bg-blue-700'
                  : link.url
                  ? 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'
                  : 'cursor-not-allowed text-gray-300 dark:text-gray-600',
              ]"
            />
          </li>
        </ul>
      </nav>
    </div>
  </AppLayout>
</template>
