<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout         from '@/Layouts/AppLayout.vue';

const { book } = defineProps({ book: Object });

const form = useForm({
  id:               book?.id               ?? null,
  title:            book?.title            ?? '',
  author:           book?.author           ?? '',
  description:      book?.description      ?? '',
  cover_image:      book?.cover_image      ?? '',
  slug:             book?.slug             ?? '',
  publisher:        book?.publisher        ?? '',
  publication_date: book?.publication_date ?? '',
  category:         book?.category         ?? '',
  isbn:             book?.isbn             ?? '',
  page_count:       book?.page_count       ?? '',
  featured:         Boolean(book?.featured),
});

function submit() {
  if (form.id) {
    form.put(route('manage.books.update', form.id));
  } else {
    form.post(route('manage.books.store'));
  }
}
</script>

<template>
  <AppLayout :title="form.id ? 'Edit Book' : 'Add Book'">
    <div class="mx-auto max-w-3xl p-6">
      <h1 class="mb-8 text-3xl font-semibold">
        {{ form.id ? 'Edit Book' : 'Add Book' }}
      </h1>

      <form @submit.prevent="submit" class="grid grid-cols-1 gap-6">
        <!-- Title -->
        <div>
          <label for="title" class="mb-1 block text-sm font-medium">Title *</label>
          <input
            id="title"
            v-model="form.title"
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          />
          <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
        </div>

        <!-- Author -->
        <div>
          <label for="author" class="mb-1 block text-sm font-medium">Author *</label>
          <input
            id="author"
            v-model="form.author"
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          />
          <p v-if="form.errors.author" class="mt-1 text-sm text-red-600">{{ form.errors.author }}</p>
        </div>

        <!-- Description -->
        <div>
          <label for="description" class="mb-1 block text-sm font-medium">Description</label>
          <textarea
            id="description"
            v-model="form.description"
            rows="4"
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          ></textarea>
          <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p>
        </div>

        <!-- Cover URL -->
        <div>
          <label for="cover" class="mb-1 block text-sm font-medium">Cover image URL</label>
          <input
            id="cover"
            v-model="form.cover_image"
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          />
          <p v-if="form.errors.cover_image" class="mt-1 text-sm text-red-600">{{ form.errors.cover_image }}</p>
        </div>

        <!-- Slug -->
        <div>
          <label for="slug" class="mb-1 block text-sm font-medium">Slug *</label>
          <input
            id="slug"
            v-model="form.slug"
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          />
          <p v-if="form.errors.slug" class="mt-1 text-sm text-red-600">{{ form.errors.slug }}</p>
        </div>

        <!-- Publisher / Publication date -->
        <div class="grid gap-6 md:grid-cols-2">
          <div>
            <label for="publisher" class="mb-1 block text-sm font-medium">Publisher</label>
            <input
              id="publisher"
              v-model="form.publisher"
              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
            <p v-if="form.errors.publisher" class="mt-1 text-sm text-red-600">{{ form.errors.publisher }}</p>
          </div>
          <div>
            <label for="pubdate" class="mb-1 block text-sm font-medium">Publication date</label>
            <input
              id="pubdate"
              type="date"
              v-model="form.publication_date"
              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
            <p
              v-if="form.errors.publication_date"
              class="mt-1 text-sm text-red-600"
            >
              {{ form.errors.publication_date }}
            </p>
          </div>
        </div>

        <!-- Category / ISBN -->
        <div class="grid gap-6 md:grid-cols-2">
          <div>
            <label for="category" class="mb-1 block text-sm font-medium">Category *</label>
            <input
              id="category"
              v-model="form.category"
              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
            <p v-if="form.errors.category" class="mt-1 text-sm text-red-600">{{ form.errors.category }}</p>
          </div>
          <div>
            <label for="isbn" class="mb-1 block text-sm font-medium">ISBN *</label>
            <input
              id="isbn"
              v-model="form.isbn"
              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
            <p v-if="form.errors.isbn" class="mt-1 text-sm text-red-600">{{ form.errors.isbn }}</p>
          </div>
        </div>

        <!-- Page count -->
        <div>
          <label for="pages" class="mb-1 block text-sm font-medium">Page count</label>
          <input
            id="pages"
            type="number"
            min="1"
            v-model="form.page_count"
            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          />
          <p v-if="form.errors.page_count" class="mt-1 text-sm text-red-600">{{ form.errors.page_count }}</p>
        </div>

        <!-- Featured -->
        <label class="flex items-center gap-2 text-sm font-medium">
          <input type="checkbox" v-model="form.featured" class="rounded border-gray-300" />
          Featured
        </label>

        <!-- Buttons -->
        <div class="flex items-center gap-4">
          <button
            type="submit"
            :disabled="form.processing"
            class="rounded bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 disabled:opacity-50"
          >
            {{ form.id ? 'Save changes' : 'Create book' }}
          </button>
          <Link href="/manage/books" class="text-sm text-gray-600 hover:underline">Cancel</Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
