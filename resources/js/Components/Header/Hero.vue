<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';

</script>

<template>
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
          <div class="mr-auto place-self-center lg:col-span-7">
            <h1 class="max-w-2xl mb-4 text-4xl font-extrabold leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white">
              PAUD Insan Masagena: <br>Taman Belajar Pertama yang Menyenangkan
            </h1>
            <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
              PAUD Insan Masagena adalah sekolah Taman Kanak-kanak yang berfokus pada pendidikan anak usia dini. Kami menyediakan lingkungan belajar yang menyenangkan dan menstimulasi untuk anak-anak, membantu mereka tumbuh dan berkembang secara optimal.
            </p>
            <div class="space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
              <Link :href="route('phone-login')" class="inline-flex items-center justify-center w-full px-5 py-3 text-sm font-medium text-center text-gray-900 border border-gray-200 rounded-lg sm:w-auto hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">

                Masuk Menggunakan Nomor Telepon
              </Link>
              <Link :href="route('login')" class="inline-flex items-center justify-center w-full px-5 py-3 mb-2 mr-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">

                  Masuk Menggunakan Email Dan Password
              </Link>
            </div>
          </div>
          <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
            <ApplicationLogo ></ApplicationLogo>

          </div>
        </div>
      </section>
</template>
