<script setup>
import { defineProps, ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import Modal from '../Modal.vue';
const props = defineProps(['jasa' ,'tipe'])

const ShowModal = ref(false);
const Form = useForm({
    slug: null,
})
const funModal = (id)=>{
    ShowModal.value = true;
    Form.slug = id;
};

</script>

<template>

    <div class="mx-auto grid max-w-md grid-cols-1 gap-8 lg:max-w-7xl lg:grid-cols-3 lg:gap-8">
        <div v-for="item in jasa" class="flex flex-col rounded-3xl  bg-gray-900 shadow-xl ring-1 ring-black/10">
            <Link :href="route('produk.detail', { tipe: tipe, slug: item.id })"  v-for="(image,index) in item.image">
                <img class="h-60 rounded-t-lg object-cover w-full"
                    v-if="image.status" :src="image.image_url"
                    alt="product image" />
                <img class="h-60 rounded-t-lg object-cover"
                    v-else-if="index == 0" :src="image.image_url"
                    alt="product image" />

            </Link>
            <div class="p-8 sm:p-10">
                <div class="flex">
                    <h3 class="text-lg font-semibold leading-8 tracking-tight text-teal-400"
                        id="tier-basic">{{item.nama}}</h3>
                    <div class="items-center ml-2"></div>
                </div>
                <div
                    class="mt-4 flex items-baseline text-2xl tracking-tight text-gray-200 font-semibold">
                    {{ item.rupiah }}
                    <span
                        class="text-lg font-semibold leading-8 tracking-normal text-gray-400"></span>
                </div>
                <!-- <p class="mt-6 text-base leading-7 text-gray-300">Great for getting
                    started. Sign your first two documents
                    for free.</p> -->
            </div>
            <div class="flex flex-1 flex-col p-2">
                <div
                    class="flex flex-1 flex-col justify-between rounded-2xl bg-gray-700 p-6 sm:p-8">
                    <p v-html="item.keterangan" class="text-white text-sm"></p>
                    <div class="mt-8"><Link :href="route('payment.checkout', {slug: item.id})"
                            class="inline-block w-full rounded-lg bg-teal-600 px-4 py-2.5 text-center text-sm font-semibold leading-5 text-white shadow-md hover:bg-teal-500 cursor-pointer"
                            aria-describedby="tier-basic">Mulai Penyewaan</Link></div>
                </div>
            </div>
        </div>
    </div>
</template>
