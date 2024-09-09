<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import DropdownNavLink from './DropdownNavLink.vue';
import DropdownNavItem from './DropdownNavItem.vue';
import { Link, usePage } from '@inertiajs/vue3';
import SidebarAdmin from './SidebarAdmin.vue';
import SidebarGuru from './SidebarGuru.vue';
import SidebarOrg from './SidebarOrg.vue';
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
    <div class="flex flex-col w-full h-full bg-gray-800 text-white z-[9999]">
        <div class="flex items-center justify-center h-16 bg-gray-900">
            <h1 class="text-2xl font-bold">PAUD</h1>
        </div>
        <nav class="flex-1 overflow-y-auto ">
            <SidebarAdmin v-if="roleToCheck('Admin')"/>
            <SidebarGuru v-if="roleToCheck('Guru')"/>
            <SidebarOrg v-if="roleToCheck('Orang Tua')"/>
        </nav>
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
