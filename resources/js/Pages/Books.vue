<script setup>
import AvailabilityBadge from '@/Components/AvailabilityBadge.vue';
import StarRating from '@/Components/StarRating.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const { books, search } = defineProps({
  books: Object,
  search: String,
});

</script>

<template>
  <AppLayout title="Books">
    <!-- Hero -->
    <section class="bg-gradient-to-tr from-sky-50 via-indigo-50 to-violet-50 py-12
             dark:from-gray-800 dark:via-gray-800/60 dark:to-gray-900">
      <div class="mx-auto flex max-w-screen-xl flex-col items-center gap-6 px-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight lg:text-5xl">
          Browse our <span class="text-blue-600 dark:text-blue-500">Library</span>
        </h1>
        <p class="max-w-2xl text-lg text-[#55534f] dark:text-[#A1A09A]">
          Use the searchbar or simply scroll to explore every book we offer.
        </p>
      </div>
    </section>

    <!-- Books Grid -->
    <section class="flex-1">
      <div class="mx-auto max-w-screen-xl px-6 py-14">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
          <Link v-for="book in books.data" :key="book.id" :href="`/books/${book.slug}`" class="group relative overflow-hidden rounded-2xl bg-white ring-1 ring-gray-100
                   shadow-sm transition hover:-translate-y-1 hover:shadow-lg
                   dark:bg-gray-800 dark:ring-gray-700">
          <img :src="book.cover_image || 'https://via.placeholder.com/300x400?text=No+Cover'" :alt="book.title"
            class="h-60 w-full object-cover transition duration-300 group-hover:scale-105" />

          <!-- availability badge -->
          <AvailabilityBadge :available="book.is_available" />

          <div class="p-5">
            <h2 class="mb-1 line-clamp-2 text-lg font-semibold leading-snug">
              {{ book.title }}
            </h2>
            <p class="mb-3 text-sm text-gray-500 dark:text-gray-400">by {{ book.author }}</p>
            <p class="mb-4 line-clamp-2 text-sm text-gray-600 dark:text-gray-300">
              {{ book.description || 'No description available.' }}
            </p>
            <!-- rating stars + count -->
            <StarRating :average="book.average_rating" :count="book.rating_count" />
          </div>
          </Link>
        </div>

        <!-- pagination -->
        <nav v-if="books.links.length > 3" class="mt-12 flex justify-center" aria-label="Pagination">
          <ul class="inline-flex -space-x-px overflow-hidden rounded-lg border border-gray-200
                   bg-white text-sm shadow dark:border-gray-700 dark:bg-gray-800">
            <li v-for="link in books.links" :key="link.label">
              <Link :href="link.url || '#'" v-html="link.label" class="block px-3 py-2 leading-tight" :class="[
                link.active
                  ? 'z-10 bg-blue-600 text-white hover:bg-blue-700'
                  : link.url
                    ? 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'
                    : 'cursor-not-allowed text-gray-300 dark:text-gray-600',
              ]" />
            </li>
          </ul>
        </nav>
      </div>
    </section>
  </AppLayout>
</template>

<style scoped>
html {
  font-family: 'Inter', sans-serif;
}
</style>
