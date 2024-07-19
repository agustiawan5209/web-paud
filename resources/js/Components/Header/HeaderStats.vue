
<script setup>
import CardStats from "@/Components/Card/CardStats.vue";
import { defineProps } from "vue";

const props = defineProps({
    pengguna: Number,
    balita: Number,
});
</script>

<template>
  <!-- Header -->
  <div class="relative pb-3">
    <div class=" mx-auto w-full">
      <div>
        <!-- Card stats -->
        <div class="grid grid-cols-2 md:grid-cols-2">
          <div class="w-full h-full  px-4">
            <card-stats
              statSubtitle="Jumlah Data Bayi/Balita"
              :statTitle="balita"
              statArrow="up"
              statPercent="3.48"
              statPercentColor="text-emerald-500"
              statDescripiron="Since last month"
              :statIconName="['fas', 'person-breastfeeding']"
              statIconColor="bg-red-500"
            />
          </div>
          <div class="w-full h-full  px-4">
            <card-stats
              statSubtitle=" Jumlah Pengguna"
              :statTitle="pengguna"
              statArrow="down"
              statPercent="3.48"
              statPercentColor="text-red-500"
              statDescripiron="Since last week"
              :statIconName="['fas' ,'user-group']"
              statIconColor="bg-orange-500"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

