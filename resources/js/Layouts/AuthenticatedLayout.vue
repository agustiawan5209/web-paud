<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar/Sidebar.vue';

const showingNavigationDropdown = ref(false);
function getWindows() {
    return window.innerWidth;
}

window.addEventListener('resize', () => {
    const newWindowWidth = window.innerWidth;
    const newWindowHeight = window.innerHeight;
});
</script>

<template>

    <transition-group name="nested">
        <aside v-if="showingNavigationDropdown" key="mobile"
            class="fixed top-0 z-10 ml-0 flex h-screen w-full flex-col justify-between border-r bg-white px-6 pb-3 transition duration-300 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%] overflow-y-auto">
            <button class="-mr-2 mt-5 h-16 w-12 border-r lg:hidden"
                @click="showingNavigationDropdown = !showingNavigationDropdown">
                <svg xmlns="http://www.w3.org/2000/svg" class="my-auto h-6 w-6 transition-all" fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <Sidebar  />
        </aside>
        <aside key="dekstop"
            class="fixed top-0 z-10 ml-[-100%] flex h-screen w-full flex-col justify-between border-r bg-white px-6 pb-3 transition duration-300 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%] overflow-y-auto">

            <Sidebar  />
        </aside>
    </transition-group>
    <div class="ml-auto mb-6 lg:w-[75%] xl:w-[80%] 2xl:w-[85%] ">
        <div class="sticky top-0 h-16 border-b bg-white lg:py-2.5 z-50">
            <div class="flex items-center justify-between space-x-4 px-6 2xl:container">

                <h5 hidden class="text-2xl font-medium text-gray-600 lg:block">
                    <slot name="header" />
                </h5>
                <button class="-mr-2 h-16 w-12 border-r lg:hidden"
                    @click="showingNavigationDropdown = !showingNavigationDropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" class="my-auto h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex space-x-4">

                    <Link :href="route('profile.edit')" type="button" :class="route().current('profile.edit') ? 'bg-green-400 active:bg-green-500 text-white' : 'bg-gray-100 active:bg-gray-200'"
                        class="h-10 px-4 w-full rounded-xl border  flex items-center gap-2" >
                        Profile <font-awesome-icon class="text-gray-600" :icon="['fas', 'user']" />
                    </Link>
                </div>
            </div>
        </div>

        <div class="px-2 pt-6 2xl:container relative">
            <slot />
        </div>
    </div>
</template>
<style>
/* delay leave of parent element */
.nested-leave-active {
    transition-delay: 0.25s;
}

.nested-enter-from,
.nested-leave-to {
    transform: translateY(30px);
    opacity: 0;
}

/* we can also transition nested elements using nested selectors */
.nested-enter-active .aside-anime,
.nested-leave-active .aside-anime {
    transition: all 0.3s ease-in-out;
}

/* delay enter of nested element */
.nested-enter-active .aside-anime {
    transition-delay: 0.25s;
}

.nested-enter-from .aside-anime,
.nested-leave-to .aside-anime {
    transform: translateX(30px);
    /*
        Hack around a Chrome 96 bug in handling nested opacity transitions.
      This is not needed in other browsers or Chrome 99+ where the bug
      has been fixed.
    */
    opacity: 0.001;
}
</style>
