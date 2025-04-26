<script setup>
import { Link, router } from '@inertiajs/vue3'
import AppLayout        from '@/Layouts/AppLayout.vue'
import Reviews          from '@/Components/Reviews.vue'

const { book, auth } = defineProps({
  book: Object,
  auth: Object,
})

function checkout() {
  router.post(route('loans.store', book.id))
}

function markReturned() {
  router.patch(route('loans.return', book.active_loan_id))
}
</script>

<template>
  <AppLayout :title="book.title">
    <div class="mx-auto max-w-screen-xl p-6">
      <!-- back -->
      <Link
        href="/books"
        class="mb-6 inline-flex items-center text-sm font-medium text-blue-600 hover:underline dark:text-blue-400"
      >
        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Books
      </Link>

      <!-- card -->
      <div class="mt-6 rounded-2xl bg-white p-8 shadow-lg dark:bg-gray-800">
        <div class="flex flex-col gap-8 md:flex-row">
          <!-- cover -->
          <img
            :src="book.cover_image || 'https://via.placeholder.com/200x300?text=No+Cover'"
            :alt="book.title"
            class="w-full rounded-xl object-cover shadow md:w-1/3"
          />

          <!-- info -->
          <div class="flex-1">
            <div class="mb-1 flex items-start gap-2">
              <h1 class="text-4xl font-bold">{{ book.title }}</h1>

              <Link
                v-if="auth.user?.role === 'Librarian'"
                :href="route('manage.books.edit', book.id)"
                class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400"
                aria-label="Edit book"
              >
              <!-- Pencil icon -->
                <svg
                  class="h-6 w-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <path d="M12 20h9" />
                  <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                </svg>
              </Link>
            </div>

            <p class="mb-4 text-lg text-[#706f6c] dark:text-[#A1A09A]">by {{ book.author }}</p>

            <!-- rating -->
            <div class="mb-6 flex items-center">
              <svg
                v-for="n in 5"
                :key="n"
                class="h-6 w-6"
                :class="n <= Math.round(book.average_rating) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292z"
                />
              </svg>
              <span class="ml-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                {{ book.average_rating.toFixed(1) }}/5 ({{ book.rating_count }})
              </span>
            </div>

            <!-- description -->
            <p class="mb-6 text-base leading-relaxed">
              {{ book.description || 'No description available.' }}
            </p>

            <!-- details -->
            <dl class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
              <div>
                <dt class="font-medium text-[#706f6c] dark:text-[#A1A09A]">Publisher</dt>
                <dd>{{ book.publisher || 'N/A' }}</dd>
              </div>
              <div>
                <dt class="font-medium text-[#706f6c] dark:text-[#A1A09A]">Publication Date</dt>
                <dd>{{ book.publication_date || 'N/A' }}</dd>
              </div>
              <div>
                <dt class="font-medium text-[#706f6c] dark:text-[#A1A09A]">Category</dt>
                <dd>{{ book.category || 'N/A' }}</dd>
              </div>
              <div>
                <dt class="font-medium text-[#706f6c] dark:text-[#A1A09A]">ISBN</dt>
                <dd>{{ book.isbn || 'N/A' }}</dd>
              </div>
              <div>
                <dt class="font-medium text-[#706f6c] dark:text-[#A1A09A]">Pages</dt>
                <dd>{{ book.page_count || 'N/A' }}</dd>
              </div>
              <div>
                <dt class="font-medium text-[#706f6c] dark:text-[#A1A09A]">Availability</dt>
                <dd :class="book.is_available ? 'text-emerald-600' : 'text-red-600'">
                  {{ book.is_available ? 'Available' : 'Checked out' }}
                </dd>
              </div>

              <button
                v-if="book.is_available"
                @click="checkout"
                class="rounded bg-blue-600 px-4 py-2 text-white"
              >
                Check out for 5&nbsp;days
              </button>

              <button
                v-else-if="$page.props.auth.user?.role === 'Librarian'"
                @click="markReturned"
                class="rounded bg-emerald-600 px-4 py-2 text-white"
              >
                Mark returned
              </button>
            </dl>
          </div>
        </div>

        <!-- reviews -->
        <div class="mt-10">
          <Reviews :book="book" :auth="auth" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
html { font-family: 'Inter', sans-serif; }
</style>
