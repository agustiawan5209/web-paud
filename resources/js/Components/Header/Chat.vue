<script setup>
import { ref, onMounted, defineProps, inject } from 'vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage,useForm } from '@inertiajs/vue3';
import axios from 'axios';
const user = usePage().props.auth.user;

const swal = inject('$swal')
const props = defineProps(['messages', 'userid', 'recipientuser']);
let NewMessage = ref([])
async function getMessage() {
    try {
        const res = await axios.get('/chat/' + props.recipientuser.id);
        NewMessage.value = res.data;
        return res.data;  // Return data dari request
    } catch (err) {
        console.log(err);
        return null;  // Jika ada error, return null atau pesan error
    }
}


const sendMessage = async () => {
    if (newMessage.value !== '') {
        await sendChat(newMessage.value, props.recipientuser.id);
        newMessage.value = '';
    }
};

async function sendChat(message, recipientid) {
    await axios.post('chat', {
        recipient_id: recipientid,
        message: message,
    }).then((res) => {
        if (res.status == 200) {
            swal({
                icon: "info",
                title: 'Berhasil',
                text: "Pesan Dikirim",
                showConfirmButton: true,
                timer: 2000
            })
            getMessage()
        }
    }).catch((err) => console.log(err))
}

const newMessage = ref('');

</script>

<template>
    <div class="flex flex-col w-full bg-gray-50 h-96">
        <h3 class="text-sm font-semibold uppercase text-gray-600 p-1.5">{{ recipientuser.name }}</h3>

        <!-- Chat Messages Display -->
        <div class="flex-1 p-4 overflow-y-auto" v-if="NewMessage.length < 1">
            <div v-for="(message, index) in messages" :key="index" class="mb-4">
                <div :class="['flex', message.user_id == recipientuser.id ? 'justify-start' : 'justify-end']">
                    <div
                        :class="['max-w-xs p-3 rounded-lg', message.is_read ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-900']">
                        <p class="text-sm">{{ message.message }}</p>
                        <span :class="['text-xs', message.is_read ? 'text-white' : 'text-gray-400']">{{ message.human_format }}</span>

                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 p-4 overflow-y-auto" v-else>
            <div v-for="(message, index) in NewMessage" :key="index" class="mb-4">
                <div :class="['flex', message.user_id == recipientuser.id ? 'justify-start' : 'justify-end']">
                    <div
                        :class="['max-w-xs p-3 rounded-lg', message.is_read ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-900']">
                        <p class="text-sm">{{ message.message }}</p>
                        <span :class="['text-xs', message.is_read ? 'text-white' : 'text-gray-400']">{{ message.human_format }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Input Area -->
        <div class="p-4 bg-white border-t border-gray-200">
            <form @submit.prevent="sendMessage" class="flex items-center space-x-4">
                <input v-model="newMessage" type="text" placeholder="Type your message"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none">
                    Send
                </button>
            </form>
        </div>
    </div>
</template>
