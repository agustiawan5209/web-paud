<script setup>
import { ref, defineProps, inject,defineEmits } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

const page = usePage();
const swal = inject('$swal');

const props = defineProps(['produk', 'jenis','penyewaan'])
const form = useForm({
    penyewaan_id: props.penyewaan,
    rating: '',
    comment: '',
    name: '',
    email: '',
    produk_id: props.produk,
    jenis: props.jenis,
})

const rating = ref(0)
const emit = defineEmits(['reviewSubmitted'])

const setRating = (star) => {
  rating.value = star
}
const submitReview = () => {
    form.rating = rating.value
    form.post(route('Review.store'), {
        onSuccess: () => {
            form.rating = ''
            form.comment = ''
            form.name = ''
            form.email = '';
            swal({
                icon: "info",
                title: 'Berhasil',
                text: page.props.message,
                showConfirmButton: true,
                timer: 2000
            });
           // Emit event to close the modal
           emit('reviewSubmitted');
        },
        onError:(err)=>{
            console.log(err)
        }
    })
}

</script>


<template>
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Masukkan Review</h2>
        <form @submit.prevent="submitReview">
            <div class="mb-4">
                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                <font-awesome-icon :icon="['fas', 'star']" v-for="star in 5" :key="star" class="h-8 w-8 cursor-pointer"
                    :class="rating >= star ? 'text-yellow-400' : 'text-gray-300'" @click="setRating(star)" />

            </div>
            <div class="mb-4">
                <label for="Komentar" class="block text-sm font-medium text-gray-700">Comment</label>
                <textarea v-model="form.comment" id="Komentar" rows="4"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Write your Komentar here..." required></textarea>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input v-model="form.name" id="name" type="text"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Your name" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input v-model="form.email" id="email" type="email"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Your email" required>
            </div>
            <button type="submit"
                class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Submit
                Review</button>
        </form>
    </div>
</template>
