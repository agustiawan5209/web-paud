<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, defineProps } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        default: () => ({})
    }
})
const Form = useForm({
    slug: props.user.id,
    username: props.user.name,
    email: props.user.email,
    password: props.user.password,
    password_confirmation: ''
})

function submit() {
    Form.post(route('OrangTua.reset.password'), {
        onError: (err) => {
            console.log(err)
        }
    });
}


</script>

<template>

    <Head title="Ornag Tua" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Form Reset Password {{ user.name }} </h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action=""
                    class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Data Informasi Pengguna</p>
                        <p class="text-xs"> Reset Password {{ user.name }} </p>
                    </div>
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">

                            <div class="col-span-full sm:col-span-3">
                                <label for="username" class="text-sm">username</label>
                                <TextInput id="username" type="text" readonly v-model="Form.username"
                                    placeholder="@username" class="w-full text-gray-900" />
                                <InputError :message="Form.errors.username" />

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="email" class="text-sm">Email</label>
                                <TextInput id="email" type="email" readonly placeholder="" v-model="Form.email"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.email" />

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="state" class="text-sm">Password</label>
                                <TextInput id="state" type="text" placeholder="" v-model="Form.password"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.password" />

                            </div>

                            <div class="col-span-full sm:col-span-3">
                                <InputLabel for="password_confirmation" value="Confirm Password" />

                                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                                    v-model="Form.password_confirmation" required autocomplete="new-password" />

                                <InputError class="mt-2" :message="Form.errors.password_confirmation" />
                            </div>
                        </div>
                        <PrimaryButton type="submit" class="col-span-full text-center">Simpan</PrimaryButton>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
