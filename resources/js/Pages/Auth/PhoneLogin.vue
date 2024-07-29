<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    no_telpon: '',
});

const submit = () => {
    form.post(route('phone-login'), {
        onFinish: () => form.reset('no_telpon'),
        onError:(err)=>{
            console.log(err)
        }
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="no_telpon" value="Nomor HandPhone" />

                <TextInput id="no_telpon" type="tel" class="mt-1 block w-full" v-model="form.no_telpon" required autofocus
                    autocomplete="no_telpon" />

                <InputError class="mt-2" :message="form.errors.no_telpon" />
            </div>
            <PrimaryButton class="mt-4 w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Masuk
            </PrimaryButton>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Masuk Menggunakan Email Dan Password
                </Link>


            </div>
        </form>
    </GuestLayout>
</template>
