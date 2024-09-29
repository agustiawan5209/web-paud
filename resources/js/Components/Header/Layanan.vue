<script setup>
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <section class="bg-white dark:bg-gray-900 z-20">
        <div
            class="items-center max-w-screen-xl px-4 py-8 mx-auto lg:grid lg:grid-cols-3 lg:gap-16 xl:gap-24 lg:py-24 lg:px-6">

            <div class="col-span-1">
                <p class="text-lg font-medium text-yellow-600 dark:text-yellow-500">Fasilitas Menyenangkan</p>
                <h2 class="mt-3 mb-4 text-3xl font-extrabold tracking-tight text-gray-900 md:text-3xl dark:text-white">
                    Ruang bermain yang luas dan aman untuk belajar dan berkembang</h2>
                <ul class="list-disc space-y-2 pl-4">
                    <li>Ruang belajar yang nyaman dan penuh warna</li>
                    <li>Lapangan bermain outdoor yang luas</li>
                    <li>Area bermain air dan pasir yang menyenangkan</li>
                    <li>Perpustakaan mini dengan berbagai macam buku cerita</li>
                    <li>Dan masih banyak lagi!</li>
                </ul>
            </div>

            <div class="col-span-1">
                <p class="text-lg font-medium text-yellow-600 dark:text-yellow-500">Program Pendidikan yang Menyeluruh
                </p>
                <h2 class="mt-3 mb-4 text-3xl font-extrabold tracking-tight text-gray-900 md:text-3xl dark:text-white">
                    Mempersiapkan anak menuju masa depan yang cerah</h2>
                <ul class="list-disc space-y-2 pl-4">
                    <li>Mengembangkan keterampilan kognitif, sosial, dan emosional anak</li>
                    <li>Memperkenalkan konsep literasi dan numerasi dasar</li>
                    <li>Kegiatan eksplorasi sains dan kreativitas yang menarik</li>
                    <li>Pembelajaran berbasis bermain yang menyenangkan</li>
                    <li>Program agama dan budi pekerti yang berkarakter</li>
                </ul>
            </div>

            <div class="col-span-1">
                <p class="text-lg font-medium text-yellow-600 dark:text-yellow-500">Galeri Foto</p>
                <h2 class="mt-3 mb-4 text-3xl font-extrabold tracking-tight text-gray-900 md:text-3xl dark:text-white">
                    Lihat keseruan belajar di PAUD Insan Masagena</h2>
                <div class="grid grid-cols-2 gap-4">
                    <a href="#" class="group hover:opacity-75">
                        <img src="/images/sk2.jpg" alt="Photo 1"
                            class="rounded-lg w-full h-auto object-cover group-hover:scale-105">
                    </a>
                    <a href="#" class="group hover:opacity-75">
                        <img src="/images/sk4.jpg" alt="Photo 2"
                            class="rounded-lg w-full h-auto object-cover group-hover:scale-105">
                    </a>
                    <a href="#" class="group hover:opacity-75">
                        <img src="/images/sk1.jpg" alt="Photo 3"
                            class="rounded-lg w-full h-auto object-cover group-hover:scale-105">
                    </a>
                    <a href="#" class="group hover:opacity-75">
                        <img src="/images/sk5.jpg" alt="Photo 4"
                            class="rounded-lg w-full h-auto object-cover group-hover:scale-105">
                    </a>
                </div>
            </div>
        </div>
        </section>

        <!-- End block -->
</template>
