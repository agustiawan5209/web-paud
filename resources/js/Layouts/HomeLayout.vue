<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="container mx-auto">
        <!-- Top Bar Nav -->
        <nav class="w-full py-4 bg-blue-800 shadow">
            <div class="w-full container mx-auto flex flex-wrap items-center justify-between">

                <nav>
                    <ul class="flex items-center justify-between font-bold text-sm text-white uppercase no-underline">
                        <li><Link class="hover:text-gray-200 hover:underline px-4" :href="route('login')">Masuk</Link></li>
                        <li><Link class="hover:text-gray-200 hover:underline px-4" :href="route('register')">Daftar</Link></li>
                    </ul>
                </nav>

                <div class="flex items-center text-lg no-underline text-white pr-6">
                    <a class="" href="#">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a class="pl-6" href="#">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="pl-6" href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="pl-6" href="#">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>

        </nav>

        <!-- Text Header -->
        <header class="w-full container mx-auto">
            <div class="flex flex-col items-center py-4">
                <a class="font-bold text-gray-800 uppercase hover:text-gray-700 text-3xl" href="#">
                    Minimal Blog
                </a>
                <p class="text-lg text-gray-600">
                    Lorem Ipsum Dolor Sit Amet
                </p>
            </div>
        </header>

        <!-- Topic Nav -->
        <nav class="w-full py-4 border-t border-b bg-gray-100" x-data="{ open: false }">
            <div class="block sm:hidden">
                <a href="#"
                    class=" md:hidden text-base font-bold uppercase text-center flex justify-center items-center"
                    @click="open = !open">
                    Topics <i :class="open ? 'fa-chevron-down' : 'fa-chevron-up'" class="fas ml-2"></i>
                </a>
            </div>
            <div :class="open ? 'block' : 'hidden'" class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
                <div
                    class="w-full container mx-auto flex flex-col sm:flex-row items-center justify-center text-xs font-bold uppercase mt-0 px-6 ">
                    <a href="#" class="hover:bg-gray-400 rounded py-2 px-4 mx-2">Technology</a>
                    <a href="#" class="hover:bg-gray-400 rounded py-2 px-4 mx-2">Automotive</a>
                    <a href="#" class="hover:bg-gray-400 rounded py-2 px-4 mx-2">Finance</a>
                    <a href="#" class="hover:bg-gray-400 rounded py-2 px-4 mx-2">Politics</a>
                    <a href="#" class="hover:bg-gray-400 rounded py-2 px-4 mx-2">Culture</a>
                    <a href="#" class="hover:bg-gray-400 rounded py-2 px-4 mx-2">Sports</a>
                </div>
            </div>
        </nav>

        <main>
            <slot />
        </main>
    </section>

    <footer class=" divide-y bg-white border-t shadow-2xl">
        <div class="container flex flex-col justify-between py-10 mx-auto space-y-8 lg:flex-row lg:space-y-0">
            <div class="lg:w-1/3">
                <a rel="noopener noreferrer" href="#" class="flex justify-center space-x-3 lg:justify-start">
                    <ApplicationLogo class="w-10 object-cover"/>
                    <span class="self-center text-2xl font-semibold" >UPT Puskesmas Karassing</span>
                </a>
            </div>
            <div class="grid grid-cols-2 text-sm gap-x-3 gap-y-8 lg:w-2/3 sm:grid-cols-2">
                <div class="space-y-3">
                    <h3 class="tracking-wide uppercase font-semibold">Jadwal Pelayanan Puskesmas</h3>
                    <ul class="space-y-5">
                        <li>
                            <a rel="noopener noreferrer" href="#">Senin-Kamis : 07.30-15.00 WIB</a>
                        </li>
                        <li>
                            <a rel="noopener noreferrer" href="#">Jumat : 07.30-15.30 WIB</a>
                        </li>
                        <li>
                            <a rel="noopener noreferrer" href="#">Unit Pelayanan Bersalin 24 Jam</a>
                        </li>
                    </ul>
                </div>
                <div class="space-y-3">
                    <h3 class="uppercase">Hubungi Kami</h3>
                    <ul class="space-y-1">
                        <li class="flex gap-4">
                            <font-awesome-icon :icon="['fas', 'location-dot']"/>
                            <span v-if="Puskesmas != null">{{ Puskesmas.alamat }}</span>
                            <span v-else>Ds. Karassing, Kec. Hero Lange-Lange</span>
                        </li>
                        <li class="flex gap-4">
                            <font-awesome-icon :icon="['fas', 'phone']"/>
                            <span>+62 85255814561</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="py-6 text-sm text-center bg-primary">UPT Puskesmas Karassing© {{ Year }}. All rights reserved.</div>
    </footer>
</template>
