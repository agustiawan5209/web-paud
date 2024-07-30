<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import DropdownNavLink from './DropdownNavLink.vue';
import DropdownNavItem from './DropdownNavItem.vue';
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


const openDropdown = ref([]);

const toggleDropdown = (menu) => {
    if (openDropdown.value.includes(menu)) {
        openDropdown.value = openDropdown.value.filter(item => item !== menu);
    } else {
        openDropdown.value.push(menu);
    }
};

const isOpenDropdown = (menu) => openDropdown.value.includes(menu);

</script>
<template>
    <ul>
        <li>
            <NavLink :href="route('dashboard')" :active="route().current('dashboard')" :icon="['fas', 'home']">

                <span class="-mr-1 font-medium">Dashboard</span>
            </NavLink>
        </li>
        <li class="group">
            <NavLink :href="route('Guru.Jadwal.index')"
                :active="route().current('Guru.Jadwal.index') || route().current('Guru.Jadwal.create') || route().current('Guru.Jadwal.edit') || route().current('Guru.Jadwal.show')"
                :icon="['fas', 'calendar-days']">
                <span class="capitalize text-sm">Jadwal Kegiatan</span>
            </NavLink>
        </li>
        <li>
            <NavLink :href="route('Absen.index')"
                :active="route().current('Absen.index') || route().current('Absen.create') || route().current('Absen.edit') || route().current('Absen.show')"
                :icon="['far', 'calendar-check']">
                <span class="capitalize">Absensi Siswa</span>
            </NavLink>
        </li>
        <li>
            <NavLink :href="route('NilaiSiswa.index')"
                :active="route().current('NilaiSiswa.index') || route().current('NilaiSiswa.create') || route().current('NilaiSiswa.edit') || route().current('NilaiSiswa.show')"
                :icon="['fas', 'chess-board']">

                <span class="capitalize">Nilai Siswa</span>
            </NavLink>
        </li>
        <li>
            <NavLink :href="route('Perkembangan.index')"
                :active="route().current('Perkembangan.index') || route().current('Perkembangan.create') || route().current('Perkembangan.edit') || route().current('Perkembangan.show')"
                :icon="['fas', 'chart-line']">

                <span class="capitalize text-sm">Laporan Perkembangan Siswa</span>
            </NavLink>
        </li>
        <li class=" flex items-center justify-between border-t">
            <NavLink :href="route('logout')" method="post" as="button" :icon="['fas', 'right-from-bracket']">
                <span class="capitalize">Logout</span>
            </NavLink>
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
