<script setup>
import { ref, watch, onMounted } from 'vue';
import { router , usePage } from '@inertiajs/vue3';
import { Calendar, DatePicker, Popover } from 'v-calendar';
import 'v-calendar/style.css';
import axios from 'axios';

const dates = ref(null);
watch(dates, (value) => {
    const Jadwal = new Date(value)
    const search = `${Jadwal.getFullYear()}-${String(Jadwal.getMonth() + 1).padStart(2, '0')}-${Jadwal.getDate().toString().padStart(2, '0')}`;

    router.get(route('Jadwal.index', {search: search}))
})
const Loaded = ref(false)
const AttributeData = ref([{
    key: 'today',
    highlight: {
        color: 'purple',
        fillMode: 'solid',
        contentClass: 'italic',
    },
    dates: new Date(),
},])

const user_id = usePage().props.auth.user.id;
onMounted(() => {
    // dates.value = new Date();
    axios.get(route('api.jadwal.getJadwal', {user:  user_id}))
        .then((res) => {
            if (res.status == 200) {
                const Jadwal = res.data.data;
                for (let i = 0; i < Jadwal.length; i++) {
                    const element = Jadwal[i];
                    AttributeData.value.push({
                        key: i.toString(),
                        highlight: {
                            color: 'blue',
                            fillMode: 'outline',
                            contentClass: 'italic',
                        },
                        dot: 'red',
                        dates: element.tanggal,
                        popover: {
                            label: element.deskripsi,
                            isInteractive: false,
                        }
                    })
                }
                Loaded.value = true;
            } else {
                console.log('Error Data Gagal Didapat')
            }
        })
        .catch((err) => {
            console.log(err)
            // console.error('Error :' + err)
        })
})
</script>


<template>
    <div class="w-full h-full box-content" v-if="Loaded">
        <DatePicker v-model.lazy="dates"  :attributes="AttributeData" expanded :locale="{ id: 'id', firstDayOfWeek: 2, masks: { weekdays: 'WWWW' } }"/>
    </div>
</template>
