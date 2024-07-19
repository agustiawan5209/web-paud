<script setup>
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <div class="container mx-auto px-2 overflow-hidden">

        <div class="relative py-16">
            <div class="container relative m-auto px-6 text-gray-500 md:px-12">
                <div class="grid gap-6 md:mx-auto md:w-8/12 lg:w-full lg:grid-cols-3">
                    <div
                        class="group space-y-6 border border-gray-100 rounded-3xl bg-white px-8 py-12 text-center shadow-2xl shadow-gray-600/10 ">
                        <img class="mx-auto w-24" src="images/svg/Pediatrician-bro.svg" alt="illustration"
                            loading="lazy" />
                        <h3 class="text-2xl font-semibold text-gray-800">Layanan Imunisasi</h3>
                        <p>
                            Obcaecati, quam? Eligendi, nulla numquam natus laborum porro at cum, consectetur ullam
                            tempora ipsa iste officia sed officiis! Incidunt ea animi officiis.
                        </p>
                        <Link :href="route('Jadwal.index')"
                            class="relative mx-auto flex h-10 w-10 items-center justify-center before:absolute before:inset-0 before:rounded-full before:border before:border-gray-100 before:transition before:duration-300 group-hover:before:scale-125">
                            <span class="text-primary">&rightarrow;</span>
                        </Link>
                    </div>
                    <div
                        class="group space-y-6 border border-gray-100 rounded-3xl bg-white px-8 py-12 text-center shadow-2xl shadow-gray-600/10 ">
                        <img class="mx-auto w-24" src="images/svg/Segmentation-bro.svg" alt="illustration"
                            loading="lazy" />
                        <h3 class="text-2xl font-semibold text-gray-800">Grafik Pertumbuan Balita</h3>
                        <p>
                            Obcaecati, quam? Eligendi, nulla numquam natus laborum porro at cum, consectetur ullam
                            tempora ipsa iste officia sed officiis! Incidunt ea animi officiis.
                        </p>

                        <Link :href="route('Balita.index')"
                            class="relative mx-auto flex h-10 w-10 items-center justify-center before:absolute before:inset-0 before:rounded-full before:border before:border-gray-100 before:transition before:duration-300 group-hover:before:scale-125">
                            <span class="text-primary">&rightarrow;</span>
                        </Link>
                    </div>
                    <div
                        class="group space-y-6 border border-gray-100 rounded-3xl bg-white px-8 py-12 text-center shadow-2xl shadow-gray-600/10 ">
                        <img class="mx-auto w-24" src="images/svg/Motherhood-amico.svg" alt="illustration"
                            loading="lazy" />
                        <h3 class="text-2xl font-semibold text-gray-800">Informasi Ibu Dan Anak</h3>
                        <p>
                            Obcaecati, quam? Eligendi, nulla numquam natus laborum porro at cum, consectetur ullam
                            tempora ipsa iste officia sed officiis! Incidunt ea animi officiis.
                        </p>
                        <Link :href="route('login')"
                            class="relative mx-auto flex h-10 w-10 items-center justify-center before:absolute before:inset-0 before:rounded-full before:border before:border-gray-100 before:transition before:duration-300 group-hover:before:scale-125">
                            <span class="text-primary">&rightarrow;</span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
