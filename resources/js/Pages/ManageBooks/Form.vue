<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout          from '@/Layouts/AppLayout.vue';

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

//Dark mode text fix.
const fieldBase =
  'block w-full rounded-lg border-gray-300 shadow-sm ' +
  'focus:border-blue-500 focus:ring-blue-500 ' +
  'dark:bg-gray-800 dark:border-gray-600 ' +
  'dark:text-gray-200 dark:placeholder-gray-400';

const labelCls = 'mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300';

function submit() {
  form.id
    ? form.put(route('manage.books.update', form.id))
    : form.post(route('manage.books.store'));
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
          <label :class="labelCls" for="title">Title *</label>
          <input id="title" v-model="form.title" :class="fieldBase" />
          <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
        </div>

        <!-- Author -->
        <div>
          <label :class="labelCls" for="author">Author *</label>
          <input id="author" v-model="form.author" :class="fieldBase" />
          <p v-if="form.errors.author" class="mt-1 text-sm text-red-600">{{ form.errors.author }}</p>
        </div>

        <!-- Description -->
        <div>
          <label :class="labelCls" for="description">Description</label>
          <textarea id="description" rows="4" v-model="form.description" :class="fieldBase"></textarea>
          <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p>
        </div>

        <!-- Cover URL -->
        <div>
          <label :class="labelCls" for="cover">Cover image URL</label>
          <input id="cover" v-model="form.cover_image" :class="fieldBase" />
          <p v-if="form.errors.cover_image" class="mt-1 text-sm text-red-600">{{ form.errors.cover_image }}</p>
        </div>

        <!-- Slug -->
        <div>
          <label :class="labelCls" for="slug">Slug *</label>
          <input id="slug" v-model="form.slug" :class="fieldBase" />
          <p v-if="form.errors.slug" class="mt-1 text-sm text-red-600">{{ form.errors.slug }}</p>
        </div>

        <!-- Publisher / Publication date -->
        <div class="grid gap-6 md:grid-cols-2">
          <div>
            <label :class="labelCls" for="publisher">Publisher</label>
            <input id="publisher" v-model="form.publisher" :class="fieldBase" />
            <p v-if="form.errors.publisher" class="mt-1 text-sm text-red-600">{{ form.errors.publisher }}</p>
          </div>
          <div>
            <label :class="labelCls" for="pubdate">Publication date</label>
            <input id="pubdate" type="date" v-model="form.publication_date" :class="fieldBase" />
            <p v-if="form.errors.publication_date" class="mt-1 text-sm text-red-600">
              {{ form.errors.publication_date }}
            </p>
          </div>
        </div>

        <!-- Category / ISBN -->
        <div class="grid gap-6 md:grid-cols-2">
          <div>
            <label :class="labelCls" for="category">Category *</label>
            <input id="category" v-model="form.category" :class="fieldBase" />
            <p v-if="form.errors.category" class="mt-1 text-sm text-red-600">{{ form.errors.category }}</p>
          </div>
          <div>
            <label :class="labelCls" for="isbn">ISBN *</label>
            <input id="isbn" v-model="form.isbn" :class="fieldBase" />
            <p v-if="form.errors.isbn" class="mt-1 text-sm text-red-600">{{ form.errors.isbn }}</p>
          </div>
        </div>

        <!-- Page count -->
        <div>
          <label :class="labelCls" for="pages">Page count</label>
          <input id="pages" type="number" min="1" v-model="form.page_count" :class="fieldBase" />
          <p v-if="form.errors.page_count" class="mt-1 text-sm text-red-600">{{ form.errors.page_count }}</p>
        </div>

        <!-- Featured -->
        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
          <input type="checkbox" v-model="form.featured" class="rounded border-gray-300 dark:border-gray-600" />
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
          <Link href="/manage/books" class="text-sm text-gray-600 hover:underline dark:text-gray-300">
            Cancel
          </Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped>
html { font-family: 'Inter', sans-serif; }
</style>
