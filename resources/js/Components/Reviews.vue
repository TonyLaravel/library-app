<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const { book, auth } = defineProps({
    book: Object,
    auth: Object,
});

const commentForm = useForm({ content: '' });
const ratingForm = useForm({ value: 0 });
const hoverRating = ref(0);

const setHover = n => (hoverRating.value = n);
const clearHover = () => (hoverRating.value = 0);
const initial = n => (n ? n.charAt(0).toUpperCase() : '?');
const fmtDate = iso => new Date(iso).toLocaleDateString();

function submitComment() {
    commentForm.post(route('books.comments.store', book.slug), {
        preserveScroll: true,
        onSuccess: () => commentForm.reset(),
    });
}

function submitRating(val) {
    ratingForm.value = val;
    ratingForm.post(route('books.ratings.store', book.slug), {
        preserveScroll: true,
    });
}
</script>

<template>
    <!-- rating -->
    <section class="mt-10">
        <div v-if="auth.user" class="mb-10">
            <h3 class="mb-2 text-lg font-medium">Rate this book</h3>

            <div class="flex gap-1" role="radiogroup" aria-label="rate">
                <button v-for="n in 5" :key="n" type="button"
                    class="transition-transform duration-150 hover:-translate-y-0.5 focus:outline-none"
                    @mouseover="setHover(n)" @mouseleave="clearHover" @click="submitRating(n)">
                    <svg class="h-8 w-8"
                        :class="n <= (hoverRating || ratingForm.value) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </button>
            </div>

            <p v-if="ratingForm.errors.value" class="mt-1 text-sm text-red-600 dark:text-red-400">
                {{ ratingForm.errors.value }}
            </p>
        </div>
    </section>

    <!-- comments -->
    <section>
        <h2 class="mb-4 text-2xl font-semibold">Customer Reviews</h2>

        <div v-if="auth.user" class="mb-8">
            <h3 class="mb-2 text-lg font-medium">Add a Review</h3>
            <form @submit.prevent="submitComment">
                <textarea v-model="commentForm.content" rows="4" placeholder="Write something nice..." class="w-full rounded-lg border border-gray-300 bg-gray-50 p-4 text-sm
                 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600
                 dark:bg-gray-700 dark:text-white"></textarea>

                <p v-if="commentForm.errors.content" class="mt-1 text-sm text-red-600 dark:text-red-400">
                    {{ commentForm.errors.content }}
                </p>

                <button type="submit" class="mt-3 inline-flex items-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white
                 hover:bg-blue-700 focus:outline-none dark:bg-blue-500 dark:hover:bg-blue-600">
                    Submit
                </button>
            </form>
        </div>
        <p v-else class="mb-8 text-sm text-gray-500 dark:text-gray-400">
            Please
            <Link href="/login" class="text-blue-600 hover:underline dark:text-blue-400">log in</Link>
            to leave a review and rate.
        </p>

        <div v-if="book.comments.length" class="space-y-6">
            <article v-for="c in book.comments" :key="c.id" class="rounded-lg bg-gray-50 p-6 dark:bg-gray-700">
                <footer class="mb-2 flex items-center space-x-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100
                   text-xs font-semibold text-blue-600 dark:bg-blue-500 dark:text-white">
                        {{ initial(c.user_name) }}
                    </div>
                    <div class="text-sm">
                        <p class="font-medium text-gray-900 dark:text-white">{{ c.user_name }}</p>
                        <time :datetime="c.created_at" class="text-xs text-gray-500 dark:text-gray-400">
                            {{ fmtDate(c.created_at) }}
                        </time>
                    </div>
                </footer>
                <p class="text-gray-700 dark:text-gray-300">{{ c.content }}</p>
            </article>
        </div>
        <p v-else class="text-sm text-gray-500 dark:text-gray-400">No reviews yet.</p>
    </section>
</template>
