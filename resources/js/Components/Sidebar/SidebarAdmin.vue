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
        <DropdownNavLink title="Master Data" :active="route().current('TahunAjar.index') || route().current('Kelas.index')">
            <template #icon>📂</template>
            <li>
                <DropdownNavItem :href="route('TahunAjar.index')" :active="route().current('TahunAjar.index')"
                    :icon="['fas', 'user']">

                    <span class="-mr-1 font-medium">Tahun Ajaran</span>
                </DropdownNavItem>
            </li>
            <li>
                <DropdownNavItem :href="route('Kelas.index')" :active="route().current('Kelas.index')"
                    :icon="['fas', 'user']">

                    <span class="-mr-1 font-medium">Kelas</span>
                </DropdownNavItem>
            </li>
        </DropdownNavLink>
        <DropdownNavLink title="Master Siswa" :active="route().current('Siswa.index') || route().current('Siswa.create') || route().current('Siswa.edit') || route().current('Siswa.show') || route().current('KelasSiswa.index') || route().current('KelasSiswa.create') || route().current('KelasSiswa.edit') || route().current('KelasSiswa.show') || route().current('Jadwal.index') || route().current('Jadwal.create') || route().current('Jadwal.edit') || route().current('Jadwal.show')">
            <template #icon>📂</template>
            <li class="group">
                <DropdownNavItem :href="route('Siswa.index')"
                    :active="route().current('Siswa.index') || route().current('Siswa.create') || route().current('Siswa.edit') || route().current('Siswa.show')"
                    :icon="['fas', 'person-breastfeeding']">
                    <span class="capitalize">Data Siswa</span>
                </DropdownNavItem>
            </li>
            <li class="group">
                <DropdownNavItem :href="route('KelasSiswa.index')"
                    :active="route().current('KelasSiswa.index') || route().current('KelasSiswa.create') || route().current('KelasSiswa.edit') || route().current('KelasSiswa.show')"
                    :icon="['fas', 'users-line']">

                    <span class="capitalize">Kelas Siswa</span>
                </DropdownNavItem>
            </li>
            <li class="group">
                <DropdownNavItem :href="route('Jadwal.index')"
                    :active="route().current('Jadwal.index') || route().current('Jadwal.create') || route().current('Jadwal.edit') || route().current('Jadwal.show')"
                    :icon="['fas', 'users-line']">

                    <span class="capitalize">Jadwal Siswa</span>
                </DropdownNavItem>
            </li>
        </DropdownNavLink>


        <li>
            <NavLink :href="route('Guru.index')" :active="route().current('Guru.index')"
                :icon="['fas', 'users']">

                <span class="-mr-1 font-medium">Guru</span>
            </NavLink>
        </li>

        <li>
            <NavLink :href="route('OrangTua.index')"
                :active="route().current('OrangTua.index') || route().current('OrangTua.create') || route().current('OrangTua.edit') || route().current('OrangTua.show')"
                :icon="['fas', 'users-line']">

                <span class="capitalize">Orang Tua</span>
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
