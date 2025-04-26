<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '@/Components/NavBar.vue';

const props = defineProps({
  title: { type: String, default: 'Library App' },
});
</script>

<template>
  <!-- head -->

  <Head :title="props.title">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>

  <div class="min-h-screen flex flex-col bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
    <Navbar />

    <!-- flash message -->
    <div v-if="$page.props.flash" class="mx-auto mt-4 flex justify-center">
      <div class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow">
        {{ $page.props.flash }}
      </div>
    </div>

    <!-- main slot for page content -->
    <main class="flex-1">
      <slot />
    </main>
  </div>
</template>
