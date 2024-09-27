<script setup>
import CardStats from "@/Components/Card/CardStats.vue";
import { defineProps } from "vue";
import { usePage } from "@inertiajs/vue3";
const Page = usePage().props.auth;
const Roles = Page.role;
function roleToCheck(role) {
    if (Array.isArray(Roles)) {
        return Roles.includes(role)
    } else {
        return false;
    }
}
const props = defineProps({
    pengguna: {
        type: Number,
        default: 0,
    },
    siswa: {
        type: Number,
        default: 0,
    },
    kelas: {
        type: Number,
        default: 0,
    },
    orangtua: {
        type: Number,
        default: 0,
    },
    guru: {
        type: Number,
        default: 0,
    },
});
</script>

<template>
    <!-- Header -->
    <div class="relative pb-3">
        <div class=" mx-auto w-full">
            <div>
                <!-- Card stats -->
                <div class="grid grid-cols-1"
                    :class="roleToCheck('Admin') ? 'md:grid-cols-3' : 'md:grid-cols-2'">
                    <div class="w-full h-full  px-4">
                        <card-stats statSubtitle="Jumlah Siswa" :statTitle="siswa" statArrow="up" statPercent="3.48"
                            statPercentColor="text-emerald-500" statDescripiron="Since last month"
                            :statIconName="['fas', 'person-breastfeeding']" statIconColor="bg-red-500" />
                    </div>
                    <div class="w-full h-full  px-4" v-if="roleToCheck('Admin')">
                        <card-stats statSubtitle=" Jumlah Guru" :statTitle="guru" statArrow="down" statPercent="3.48"
                            statPercentColor="text-red-500" statDescripiron="Since last week"
                            :statIconName="['fas', 'user-group']" statIconColor="bg-orange-500" />
                    </div>
                    <div class="w-full h-full  px-4">
                        <card-stats statSubtitle=" Jumlah Kelas" :statTitle="kelas" statArrow="down" statPercent="3.48"
                            statPercentColor="text-red-500" statDescripiron="Since last week"
                            :statIconName="['fas', 'bars']" statIconColor="bg-orange-500" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
