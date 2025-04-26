<script setup>
import AvailabilityBadge from '@/Components/AvailabilityBadge.vue';
import StarRating from '@/Components/StarRating.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const { featuredBooks, sortBy, sortDir } = defineProps({
  featuredBooks: Array,
  sortBy: String,
  sortDir: String,
});

function applySort(event) {
  const [sBy, sDir] = event.target.value.split(':');
  window.location.href =
    route('home', { sort_by: sBy, sort_dir: sDir });
}
</script>

<template>
  <AppLayout title="Home">

    <!-- Hero -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-sky-100 to-indigo-50
                 dark:from-gray-800 dark:via-gray-800/60 dark:to-gray-900">
      <div class="pointer-events-none absolute inset-0">
        <svg class="-left-20 -top-20 h-[60rem] w-[60rem] text-blue-300 opacity-20 dark:text-gray-700"
          viewBox="0 0 600 600">
          <circle cx="300" cy="300" r="300" fill="currentColor" />
        </svg>
      </div>

      <div class="relative z-10 mx-auto max-w-screen-xl px-6 py-20 text-center md:py-28">
        <h1 class="mb-4 text-5xl font-extrabold tracking-tight drop-shadow-sm lg:text-6xl">
          Discover Your <span class="text-blue-600 dark:text-blue-500">Next Book</span>
        </h1>
        <p class="mx-auto mb-8 max-w-2xl text-lg text-[#55534f] dark:text-[#A1A09A] md:text-xl">
          Browse, borrow, and share reviews with book lovers worldwide.
        </p>
        <div class="mb-10 flex justify-center gap-3">
          <Link href="/books" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-3
                   text-base font-medium text-white shadow hover:bg-blue-700 focus:outline-none
                   focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600
                   dark:focus:ring-blue-800">
          Browse Books
          </Link>
        </div>
      </div>
    </section>

    <!-- Featured -->
    <section id="Featured" class="flex-1">
      <div class="mx-auto max-w-screen-xl px-6 py-14">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <h2 class="text-3xl font-semibold">Featured Books</h2>

          <!-- sort select -->
          <label class="inline-flex items-center gap-2 text-sm font-medium text-[#55534f] dark:text-gray-300">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M3 6h18M6 12h12M9 18h6" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <select @change="applySort" class="rounded-lg border-gray-300 bg-gray-50 p-2 text-sm
                     focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600
                     dark:bg-gray-700 dark:text-white">
              <option value="title:asc" :selected="sortBy === 'title' && sortDir === 'asc'">Title A–Z</option>
              <option value="title:desc" :selected="sortBy === 'title' && sortDir === 'desc'">Title Z–A</option>
              <option value="author:asc" :selected="sortBy === 'author' && sortDir === 'asc'">Author A–Z</option>
              <option value="author:desc" :selected="sortBy === 'author' && sortDir === 'desc'">Author Z–A</option>
              <option value="available:desc" :selected="sortBy === 'available' && sortDir === 'desc'">Available first</option>
              <option value="available:asc" :selected="sortBy === 'available' && sortDir === 'asc'">Unavailable first</option>
            </select>
          </label>
        </div>

        <!-- grid -->
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
          <Link v-for="book in featuredBooks" :key="book.id" :href="`/books/${book.slug}`" class="group relative overflow-hidden rounded-2xl bg-white ring-1 ring-gray-100
                   shadow-sm transition hover:-translate-y-1 hover:shadow-lg
                   dark:bg-gray-800 dark:ring-gray-700">
          <img :src="book.cover_image || 'https://via.placeholder.com/300x400?text=No+Cover'" :alt="book.title"
            class="h-60 w-full object-cover transition duration-300 group-hover:scale-105" />

          <!-- availability badge -->
          <AvailabilityBadge :available="book.is_available" />

          <div class="p-5">
            <h3 class="line-clamp-2 mb-1 text-lg font-semibold leading-snug">
              {{ book.title }}
            </h3>
            <p class="mb-3 text-sm text-gray-500 dark:text-gray-400">by {{ book.author }}</p>
            <p class="line-clamp-2 mb-4 text-sm text-gray-600 dark:text-gray-300">
              {{ book.description || 'No description available.' }}
            </p>

            <!-- rating stars + count -->
            <StarRating :average="book.average_rating" :count="book.rating_count" />
          </div>
          </Link>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<style scoped>
html {
  font-family: 'Inter', sans-serif;
}
</style>
