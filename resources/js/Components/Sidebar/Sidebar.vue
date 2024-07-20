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
    <ul class="mt-6  overflow-hidden" >
        <li >
            <NavLink :href="route('dashboard')" :active="route().current('dashboard')" :icon="['fas', 'home']">

                <span class="-mr-1 font-medium">Dashboard</span>
            </NavLink>
        </li>
        <li >
            <NavLink :href="route('TahunAjar.index')" :active="route().current('TahunAjar.index')" :icon="['fas', 'user']">

                <span class="-mr-1 font-medium">Tahun Ajaran</span>
            </NavLink>
        </li>
        <li >
            <NavLink :href="route('Kelas.index')" :active="route().current('Kelas.index')" :icon="['fas', 'user']">

                <span class="-mr-1 font-medium">Kelas</span>
            </NavLink>
        </li>
        <li >
            <NavLink :href="route('Guru.index')" :active="route().current('Guru.index')" :icon="['fas', 'users']">

                <span class="-mr-1 font-medium">Guru</span>
            </NavLink>
        </li>
        <li >
            <NavLink :href="route('Siswa.index')"
                    :active="route().current('Siswa.index') || route().current('Siswa.create') || route().current('Siswa.edit') || route().current('Siswa.show')"
                    :icon="['fas', 'person-breastfeeding']">
                    <span class="group-hover:text-gray-700 capitalize">Data Siswa</span>
                </NavLink>
        </li>
        <li >
            <NavLink :href="route('OrangTua.index')"
            :active="route().current('OrangTua.index') || route().current('OrangTua.create') || route().current('OrangTua.edit') || route().current('OrangTua.show')"
            :icon="['fas', 'users-line']">

            <span class="group-hover:text-gray-700 capitalize">Orang Tua</span>
        </NavLink>
        </li>

    </ul>
    <div class="-mx-6 flex items-center justify-between border-t px-6 pt-4">
        <NavLink :href="route('logout')" method="post" as="button" :icon="['fas', 'right-from-bracket']">
            <span class="group-hover:text-gray-700 capitalize">Logout</span>
        </NavLink>
    </div>
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
