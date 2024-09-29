<script setup>
import { ref, onMounted } from 'vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
const user = usePage().props.auth.user;
import Chat from './Chat.vue';

let messages = ref([])
let roomChat = ref([]);
let recipientid = ref(null)
let recipientuser = ref([])
const chatModal = ref(false);
const ModalChatRoom = ref(false)
let chatNotRead = ref(0);

onMounted(async () => {

    roomChat.value = await getChatRoom();

    await axios.get('/chat/not/read').then((res) => {
        if (res.status == 200) {
            chatNotRead.value = res.data;
            console.log(res.data)
        }
    }).catch((err) => {
        console.log(err);
        chatNotRead.value = 0;  // Jika ada error, return null atau pesan error
    })

})


async function readChat(recipient) {
    try {
        const res = await axios.put('/chat/' + recipient);

    } catch (err) {
        console.log(err);
        return null;  // Jika ada error, return null atau pesan error
    }
}

async function getMessage(recipient) {
    try {
        const res = await axios.get('/chat/' + recipient.id);

        readChat(recipient.id); //  Tandai Pesan Sudah Dibaca
        messages.value = res.data;  // Simpan hasil di messages
        chatModal.value = true;
        recipientid.value = recipient.id;
        recipientuser.value = recipient;
        NewChat.value = true;
        return res.data;  // Return data dari request
    } catch (err) {
        console.log(err);
        return null;  // Jika ada error, return null atau pesan error
    }
}

async function getChatRoom() {
    try {
        const res = await axios.get('/chat/chatroom/' + user.id);
        if (res.status === 200) {
            roomChat.value = res.data;  // Simpan hasil di roomChat
            return res.data;  // Return data dari request
        }
    } catch (err) {
        console.log(err);
        return null;  // Jika ada error, return null atau pesan error
    }
}

async function findChat() {
    try {
        NewChat.value = false;
        const res = await axios.get('/chat/search/room');
        if (res.status === 200) {
            roomChat.value = res.data;  // Simpan hasil di roomChat
            return res.data;  // Return data dari request
        }
    } catch (err) {
        console.log(err);
        return null;  // Jika ada error, return null atau pesan error
    }
}

const newMessage = ref('')
const restModal = () => {
    getChatRoom();
    NewChat.value = true;
    roomChat.value = [];
    chatModal.value = false;
    recipientid.value = null;
    messages.value = [];

}


const NewChat = ref(true);

</script>

<template>
    <!-- Snippet -->
    <div>

        <button type="button" @click="ModalChatRoom = !ModalChatRoom"
            class="relative inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 16">
                <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                <path
                    d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
            </svg>
            <span class="sr-only">Notifications</span>
            Pesan
            <div v-if="chatNotRead > 0"
                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
               {{ chatNotRead }} </div>
        </button>

    </div>
    <div class=" absolute left-0" v-if="ModalChatRoom">
        <section class=" antialiased bg-gray-50 text-gray-600 min-h-screen p-4 relative">
            <button>
                <button type="button" class="px-2 py-1" @click="ModalChatRoom = false">
                    <font-awesome-icon class="text-2xl text-primary" :icon="['fas', 'square-xmark']" /> Tutup
                </button>
            </button>
            <div class="h-full overflow-x-hidden">
                <!-- Card -->
                <div class="relative max-w-[340px] mx-auto bg-white shadow-lg rounded-lg">
                    <!-- Card header -->
                    <header class="pt-6 pb-4 px-5 border-b border-gray-200">
                        <div class="flex justify-between items-center mb-3">
                            <!-- Image + name -->
                            <div class="flex items-center">
                                <a class="inline-flex items-start mr-3" href="#0">
                                    <img class="rounded-full" v-if="user.profile_photo" :src="user.profile_photo_path"
                                        width="48" height="48" :alt="user.name" />
                                    <img v-else class="rounded-full"
                                        :src="'/images/vecteezy_profile-icon-design-vector_5544718.jpg'" width="48"
                                        height="48" alt="">
                                </a>
                                <div class="pr-1">
                                    <a class="inline-flex text-gray-800 hover:text-gray-900" href="#0">
                                        <h2 class="text-xl leading-snug font-bold">{{ user.name }}</h2>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </header>
                    <button type="button" class="px-2 py-1" v-if="chatModal || NewChat == false" @click="restModal()">
                        <font-awesome-icon class="text-2xl text-primary" :icon="['far', 'square-caret-left']" /> Kembali
                    </button>
                    <!-- Card body -->
                    <transition name="slide-left">
                        <div class="py-3 px-5" v-if="chatModal == false">
                            <h3 class="text-xs font-semibold uppercase text-gray-400 mb-1">Chats</h3>
                            <!-- Chat list -->
                            <div class="divide-y divide-gray-200 h-60 overflow-y-auto">
                                <!-- User -->
                                <button v-for="item in roomChat"
                                    class="w-full text-left py-2 focus:outline-none focus-visible:bg-indigo-50">
                                    <div class="flex items-center" @click="getMessage(item)">
                                        <img v-if="item.profile_photo == null"
                                            class="rounded-full items-start flex-shrink-0 mr-3"
                                            src="/images/vecteezy_profile-icon-design-vector_5544718.jpg" width="32"
                                            height="32" :alt="item.name" />
                                        <img v-else class="rounded-full items-start flex-shrink-0 mr-3"
                                            :src="item.profile_photo_path" width="32" height="32" :alt="item.name" />
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-900">{{ item.name }}</h4>
                                            <div class="text-[13px]">The video chat ended · 2hrs</div>
                                        </div>
                                    </div>
                                </button>
                                <!-- User -->
                            </div>
                            <!-- Bottom right button -->
                            <button @click="findChat()" v-if="NewChat"
                                class="absolute bottom-5 right-5 inline-flex items-center text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded-full text-center px-3 py-2 shadow-lg focus:outline-none focus-visible:ring-2">
                                <svg class="w-3 h-3 fill-current text-indigo-300 flex-shrink-0 mr-2"
                                    viewBox="0 0 12 12">
                                    <path
                                        d="M11.866.146a.5.5 0 0 0-.437-.139c-.26.044-6.393 1.1-8.2 2.913a4.145 4.145 0 0 0-.617 5.062L.305 10.293a1 1 0 1 0 1.414 1.414L7.426 6l-2 3.923c.242.048.487.074.733.077a4.122 4.122 0 0 0 2.933-1.215c1.81-1.809 2.87-7.94 2.913-8.2a.5.5 0 0 0-.139-.439Z" />
                                </svg>
                                <span>New Chat</span>
                            </button>
                        </div>
                        <div class="py-3 px-5" v-else-if="chatModal">
                            <Chat :messages="messages" :userid="user" :recipientuser="recipientuser"></Chat>
                        </div>
                    </transition>

                </div>
            </div>

        </section>

        <!-- Modal Find Chat -->



    </div>
</template>


<style scoped>
/* Transisi saat elemen masuk */
.slide-left-enter-active,
.slide-left-leave-active {
    transition: transform 0.3s ease;
}

/* Posisi elemen sebelum muncul */
.slide-left-enter {
    transform: translateX(-100%);
    /* Mulai dari luar layar sebelah kiri */
}

/* Posisi elemen ketika menghilang */
.slide-left-leave-to {
    transform: translateX(100%);
    /* Menghilang ke kanan layar */
}
</style>
