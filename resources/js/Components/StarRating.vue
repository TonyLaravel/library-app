<script setup>
const props = defineProps({
  average: { type: Number, default: 0 },
  count:   { type: Number, default: 0 },
  size:    { type: String, default: 'h-4 w-4' },
});
</script>

<template>
  <div class="flex items-center gap-0.5">
    <!-- stars -->
    <svg
      v-for="n in 5"
      :key="n"
      :class="[size, n <= Math.round(average) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600']"
      viewBox="0 0 20 20"
      fill="currentColor"
    >
      <path
        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292z"
      />
    </svg>

    <!-- number & count -->
    <span class="ml-2 text-xs font-medium text-gray-500 dark:text-gray-400">
      {{ average.toFixed(1) }}/5
      <span v-if="count">({{ count }})</span>
    </span>
  </div>
</template>
