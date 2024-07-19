<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar/Sidebar.vue';

const Page = usePage().props.auth;
const Roles = Page.role;
function roleToCheck(role) {
    if (Array.isArray(Roles)) {
        return Roles.includes(role)
    } else {
        return false;
    }
}

const isDropdownOpen = ref(false)
const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value
}
const isDropdownLaporanOpen = ref(false)
const toggleDropdownLaporan = () => {
    isDropdownLaporanOpen.value = !isDropdownLaporanOpen.value
}
</script>
<template>
    <ul class="mt-6  overflow-hidden" v-if="roleToCheck('Admin')">
        <li class="relative">

            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                <font-awesome-icon :icon="['fas', 'house']" />
                <span class="ml-4">Dashboard</span>
            </NavLink>
        </li>
        <li class="relative">

            <NavLink :href="route('Customer.index')" :active="route().current('Customer.index')">
                <font-awesome-icon :icon="['fas', 'users']" />
                <span class="ml-4">Customer</span>
            </NavLink>
        </li>
        <li class="relative py-3">
            <div class="group px-3">
                <button @click="toggleDropdown" class="flex items-center justify-between w-full text-white ">
                    <span class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12h18m-6-6h6m-6 6h6m-6 6h6"></path>
                        </svg>
                        Produk
                    </span>
                    <svg :class="{ 'transform rotate-180': isDropdownOpen }"
                        class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
            <transition name="fade">
                <div v-if="isDropdownOpen" class="pl-6">
                    <div class="flex items-center justify-between mb-2">
                        <NavLink :href="route('Produk.Jasa.index')" :active="route().current('Produk.Jasa.index')">
                            <font-awesome-icon :icon="['fas', 'bag-shopping']" />
                            <span class="ml-4">Jasa</span>
                        </NavLink>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <NavLink :href="route('Produk.Alat.index')" :active="route().current('Produk.Alat.index')">
                            <font-awesome-icon :icon="['fas', 'briefcase']" />
                            <span class="ml-4">Alat</span>
                        </NavLink>
                    </div>
                </div>
            </transition>
        </li>
        <li class="relative">
            <NavLink :href="route('Diskon.index')" :active="route().current('Diskon.index')">
                <font-awesome-icon :icon="['fas', 'tags']" />
                <span class="ml-4">Diskon</span>
            </NavLink>
        </li>
        <li class="relative">
            <NavLink :href="route('Penyewaan.index')" :active="route().current('Penyewaan.index')">
                <font-awesome-icon :icon="['fas', 'cart-shopping']" />
                <span class="ml-4">Penyewaan</span>
            </NavLink>
        </li>
        <li class="relative">
            <NavLink :href="route('Pembayaran.index')" :active="route().current('Pembayaran.index')">
                <font-awesome-icon :icon="['fas', 'credit-card']" />
                <span class="ml-4">Transaksi</span>
            </NavLink>
        </li>
        <li class="relative">
            <NavLink :href="route('Riwayat.index')" :active="route().current('Riwayat.index')">
                <font-awesome-icon :icon="['fas', 'credit-card']" />
                <span class="ml-4">Riwayat Penyewaan</span>
            </NavLink>
        </li>
        <li class="relative py-3">
            <div class="group px-3">
                <button @click="toggleDropdownLaporan" class="flex items-center justify-between w-full text-white ">
                    <span class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12h18m-6-6h6m-6 6h6m-6 6h6"></path>
                        </svg>
                        Laporan
                    </span>
                    <svg :class="{ 'transform rotate-180': isDropdownLaporanOpen }"
                        class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
            <transition name="fade">
                <div v-if="isDropdownLaporanOpen" class="pl-6">
                    <div class="flex items-center justify-between mb-2">
                        <NavLink :href="route('Laporan.jasa', { produk: 'jasa' })"
                            :active="route().current('Laporan.jasa')">
                            <font-awesome-icon :icon="['fas', 'bag-shopping']" />
                            <span class="ml-4">Jasa</span>
                        </NavLink>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <NavLink :href="route('Laporan.alat', { produk: 'alat' })"
                            :active="route().current('Laporan.alat')">
                            <font-awesome-icon :icon="['fas', 'briefcase']" />
                            <span class="ml-4">Alat</span>
                        </NavLink>
                    </div>
                </div>
            </transition>
        </li>

    </ul>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to

/* .fade-leave-active in <2.1.8 */
    {
    opacity: 0;
}
</style>
