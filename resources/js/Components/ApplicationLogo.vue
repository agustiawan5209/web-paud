<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';

const Logo = ref('/images/logo/logo.png')
function getSetting() {
    axios.get(route('api.setting.informasi'))
        .then((res) => {
            if (res.status == 200) {
                Logo.value = res.data.logo_url;
            }
        }).catch((err)=>{
            Logo.value = '/images/logo/logo.png';
        })
}

onMounted(() => {
    getSetting()
});
</script>
<template>
    <img :src="Logo" class="object-contain" alt="logo" />
</template>
