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
            <NavLink :href="route('Org.Siswa.index')"
                :active="route().current('Org.Siswa.index') || route().current('Org.Siswa.create') || route().current('Org.Siswa.edit') || route().current('Org.Siswa.show')"
                :icon="['fas', 'person-breastfeeding']">
                <span class="capitalize">Data Siswa</span>
            </NavLink>
        </li>
        <li class="group">
            <NavLink :href="route('Org.Kegiatan.index')"
                :active="route().current('Org.Kegiatan.index') || route().current('Org.Kegiatan.create') || route().current('Org.Kegiatan.edit') || route().current('Org.Kegiatan.show')"
                :icon="['fas', 'calendar-days']">
                <span class="capitalize text-sm">Daftar Kegiatan Siswa</span>
            </NavLink>
        </li>
        <li class="group">
            <NavLink :href="route('Org.Nilai.index')"
                :active="route().current('Org.Nilai.index') || route().current('Org.Nilai.create') || route().current('Org.Nilai.edit') || route().current('Org.Nilai.show')"
                :icon="['fas', 'box-archive']">
                <span class="capitalize text-sm">Daftar Nilai Siswa</span>
            </NavLink>
        </li>
        <li class="group">
            <NavLink :href="route('Org.Perkembangan.index')"
                :active="route().current('Org.Perkembangan.index') || route().current('Org.Perkembangan.create') || route().current('Org.Perkembangan.edit') || route().current('Org.Perkembangan.show')"
                :icon="['fas', 'folder-open']">
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
