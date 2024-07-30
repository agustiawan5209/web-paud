<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';


const user = usePage().props.auth.user;

const form = useForm({
    profile_photo: user.profile_photo_path,
});
const previewImage = ref(null);
const onFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.profile_photo = file;
        previewImage.value = URL.createObjectURL(file);
    }
}

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Foto profil</h2>

            <p class="mt-1 text-sm text-gray-600">
                Perbarui Foto Profil.
            </p>
        </header>

        <form @submit.prevent="form.post(route('profile.updatePhoto'))" enctype="multipart/form-data" class="mt-6 space-y-6">
            <!-- Cover Image -->
            <div class="w-full rounded-sm bg-white bg-cover bg-center bg-no-repeat items-center">
                <!-- Profile Image -->
                <div
                    class="mx-auto relative overflow-hidden flex justify-center w-[141px] h-[141px] bg-blue-300/20 rounded-full  border">
                    <img v-if="previewImage" :src="previewImage" alt="" class="absolute w-full h-full object-fill">
                    <img v-else-if="form.profile_photo" :src="form.profile_photo" alt="" class="absolute w-full h-full object-fill">
                    <img v-else src="/images/vecteezy_profile-icon-design-vector_5544718.jpg" alt="" class="absolute w-full h-full object-fill">

                </div>
            </div>
            <div>
                <InputLabel for="profile_photo" value="Profile Photo" />

                <input id="profile_photo" @change="onFileChange" type="file" accept="image/*">
                <InputError class="mt-2" :message="form.errors.profile_photo" />

            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
