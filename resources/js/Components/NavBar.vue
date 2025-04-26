<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import SearchBar from '@/Components/SearchBar.vue';
import { computed, ref, onMounted } from 'vue';
import { initFlowbite } from 'flowbite';

defineProps({ activePage: String });
const { props } = usePage();
const user = computed(() => props.auth?.user ?? null);
const query = ref((props.search ?? '')); //Volar complaint


function toggleTheme() {
  const html = document.documentElement;
  const isDark = html.classList.toggle('dark');
  localStorage.theme = isDark ? 'dark' : 'light';
}

onMounted(() => initFlowbite());
</script>

<template>
  <nav class="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <div class="mx-auto flex max-w-screen-xl flex-wrap items-center justify-between gap-6 p-4">
      <!-- logo -->
      <Link href="/" class="flex items-center">
      <span class="text-2xl font-semibold whitespace-nowrap dark:text-white">Library.us</span>
      </Link>

      <!-- search -->
      <div class="hidden flex-1 justify-center px-4 sm:flex">
        <SearchBar :search="query" route-name="books" />
      </div>

      <!-- hamburger -->
      <button data-collapse-toggle="navbar-default" type="button"
        class="inline-flex h-10 w-10 items-center justify-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 md:hidden dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        aria-controls="navbar-default" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="h-5 w-5" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>

      <!-- menu -->
      <div id="navbar-default" class="hidden w-full md:block md:w-auto">
        <ul
          class="mt-4 flex flex-col rounded-lg border border-gray-100 bg-gray-50 p-4 font-medium md:mt-0 md:flex-row md:space-x-8 md:border-0 md:bg-transparent md:p-0 dark:border-gray-700 dark:bg-gray-800 md:dark:bg-transparent">
          <li>
            <Link :href="'/'"
              :class="['block rounded py-2 px-3 md:p-0', activePage === 'home' ? 'text-blue-700 dark:text-blue-500' : 'text-gray-900 hover:text-blue-700 dark:text-white']">
            Home</Link>
          </li>
          <li>
            <Link :href="'/books'"
              :class="['block rounded py-2 px-3 md:p-0', activePage === 'books' ? 'text-blue-700 dark:text-blue-500' : 'text-gray-900 hover:text-blue-700 dark:text-white']">
            Books</Link>
          </li>
          <li v-if="$page.props.auth.user?.role === 'Librarian'">
            <Link href="/manage/books" class="block rounded py-2 px-3 hover:bg-gray-100 md:p-0 dark:hover:bg-gray-700">
            Manage
            </Link>
          </li>

          <!-- auth dropdown -->
          <li v-if="user">
            <button id="userMenuButton" data-dropdown-toggle="userMenu"
              class="flex items-center gap-2 rounded-lg py-2 px-3 text-gray-900 hover:bg-gray-100 md:p-0 dark:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
              <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M4 21v-2a4 4 0 0 1 3-3.87" />
                <circle cx="12" cy="7" r="4" />
              </svg>
              {{ user.name }}
              <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M5.23 7.21a.75.75 0 011.06.02L10 10.586l3.71-3.356a.75.75 0 111.02 1.097l-4.25 3.847a.75.75 0 01-1.02 0L5.25 8.327a.75.75 0 01-.02-1.06z"
                  clip-rule="evenodd" />
              </svg>
            </button>

            <!-- dropdown -->
            <div id="userMenu"
              class="z-50 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-800">
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                <li>
                  <Link href="/profile"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</Link>
                </li>
                <li>
                  <button @click.stop="toggleTheme"
                    class="flex w-full items-center gap-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    
                    <!-- sun / moon icon -->
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path
                        d="M12 3v1M12 20v1M4.22 4.22l.7.7M18.36 18.36l.7.7M1 12h1M22 12h1M4.22 19.78l.7-.7M18.36 5.64l.7-.7" />
                      <circle cx="12" cy="12" r="5" />
                    </svg>
                    Toggle theme
                  </button>
              </li>
            </ul>
            <div class="py-2">
              <Link method="post" as="button" href="/logout"
                class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white">
              Log out</Link>
            </div>
          </div>
        </li>

        <!-- guest link -->
        <li v-else>
          <Link href="/login"
            class="block rounded py-2 px-3 text-gray-900 hover:bg-gray-100 md:p-0 dark:text-white dark:hover:bg-gray-700">
          Log in</Link>
        </li>
      </ul>
    </div>
  </div>
</nav></template>
