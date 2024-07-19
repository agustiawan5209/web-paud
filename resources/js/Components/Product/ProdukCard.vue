<script setup>
import { ref, defineProps, inject } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Modal from '../Modal.vue';
import FormRating from './FormRating.vue'

const swal = inject('$swal');
const page = usePage()
const props = defineProps(['produk'])

const ShowModal = ref(false);
const idProduk = ref(null);
const idPenyewaan = ref(null);
function openModal(id, id_penyewaan){
    ShowModal.value = true;
    idProduk.value = id;
    idPenyewaan.value = id_penyewaan;
}
function closeModal(){
    ShowModal.value = false;
    idProduk.value = null;
    idPenyewaan.value = null;
}
</script>

<template>
    <Modal :show="ShowModal" >
        <FormRating :produk="idProduk" :penyewaan="idPenyewaan" :jenis="produk.jenis" @reviewSubmitted="closeModal"></FormRating>
    </Modal>
    <div class="relative my-2 md:m-10 w-full max-w-xs overflow-hidden rounded-lg bg-white shadow-md">
        <a href="#" v-for="(image,index) in produk.produk_id.image">
            <img class="h-60 rounded-t-lg object-cover"
                v-if="image.status" :src="image.image_url"
                alt="product image" />
            <img class="h-60 rounded-t-lg object-cover"
                v-else-if="index == 0" :src="image.image_url"
                alt="product image" />

        </a>
        <div class="mt-4 px-5 pb-5">
            <a href="#">
                <h5 class="text-xl font-semibold tracking-tight text-slate-900">{{ produk.produk_id.nama }}</h5>
            </a>
            <div class="bg-gray-100 p-1.5 my-2">
                <ul class="list-item space-y-3">
                    <li class="text-base font-bold text-slate-700">Harga Sewa: {{produk.produk_id.rupiah}}</li>
                    <li class="text-base font-bold text-slate-700">Tanggal Pengambilan: {{produk.tgl_pengambilan}}</li>
                    <li class="text-base font-bold text-slate-700">Tanggal Pengembalian: {{produk.tgl_pengembalian}}</li>
                    <li class="text-base font-bold text-slate-700">Status Sewa: <span class="p-2 bg-green-100 text-green-800">{{produk.status}}</span></li>
                </ul>

            </div>
            <button type="button" v-if="produk.status == 'SELESAI' && produk.review == null" @click="openModal(produk.produk_id.id, produk.id)"
                    class="flex items-center rounded-md bg-slate-900 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                    <font-awesome-icon :icon="['fas','star']"/>
                    Beri Rating</button>
            <div class="" v-if="produk.review != null">
                <font-awesome-icon  :icon="['fas', 'star']" v-for="star in produk.review.rating" :key="star" class="h-8 w-8 cursor-pointer text-yellow-400"
                    />
            </div>
        </div>
    </div>
</template>
