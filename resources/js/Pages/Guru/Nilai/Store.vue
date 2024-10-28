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
import { ref, defineProps, watch, onMounted, inject } from 'vue';
import axios from 'axios';
import { FwbRadio } from 'flowbite-vue'
import { text } from '@fortawesome/fontawesome-svg-core';

import { FwbFileInput } from 'flowbite-vue'

const swal = inject('$swal')

const props = defineProps({
    kelas: {
        type: Object,
        default: () => ({}),
    },
    siswa: {
        type: Object,
        default: () => ({}),
    },
})
const Form = useForm({
    kelas_id: props.kelas.id,
    siswa_id: props.siswa.id,
    siswa: props.siswa,
    kode: props.kelas.kode,
    nama: props.siswa.nama,
    tanggal: '',
    text1: 'Alhamdulillah  perkembangan ananda pada semester Genap  memperlihatkan perkembangan yang sangat berarti,  berperan aktif dalam pelaksanaan berbagai kegiatan dengan  sikap percaya dirinya. Ananda dapat menunjukkan perilaku baik sesuai dengan agamanya dalam kehidupan sehari-hari melalui ucapan dan perilakunya seperti santun, jujur, suka menolong teman. Semoga sikap baik ini dapat berkelanjutan sehingga menjadi suatu  kebanggaan buat kita semua. ',
    text1_image: '',
    text2: `Alhamdulillah ananda anak yang ceria dan mau berteman dengan siapa saja. Pada semester genap ini ananda sudah mampu mengenali dan mempraktikkan nilai-nilai dalam agama Islam. Ananda sudah mampu melaksanakan praktik wudhu dan konsentrasi saat mengikuti kegiatan praktik shalat di kelas. Ananda sudah fasih dalam mengucapkan doa sehari-hari maupun menghafal surah-surah pendek  mulai surah Al Fatihah sampai surah Al Ma’un serta ayat kursi. Terlihat dengan  terpilihnya menjadi juara dua dalam lomba hafalan surah-surah pendek.
Ananda juga sudah mampu berperilaku baik, dan menujukkan budi pekerti yang luhur dengan sikap empati mau memaafkan teman,  selalu menyapa, salam dan salim kepada guru saat datang dan pulang sekolah.
Semoga perilaku baik ananda kedepannya bisa tetap ananda laksanakan di jenjang pendidikan selanjutnya.
`,
    text2_image: '',
    text3: `
Alhamdulillah ananda sudah mampu menunjukkan keseimbangan badan dan kelincahan pada kegiatan menari,  ananda mampu mengikuti gerakan dan irama tarian dengan baik,  dapat menggunakan alat permainan yang ada di outdoor playland maupun  indoor playland sekolah. Hal itu menunjukkan  kemampuan  terampil dalam menggunakan tangan kanan dan kiri dalam berkegiatan bermain begitu pula dalam kegiatan  menulis. Perilaku hidup sehat terlihat ketika ananda mampu menjaga kebersihan diri  dan berpakaian rapi, membuang kemasan makanan ke tempat sampah, dan membersihkan meja tempatnya makannya. Selain itu dapat menunjukkan sikap peduli kesehatan diri saat menyebutkan jenis makanan sehat dan yang tidak sehat untuk dirinya
`,
    text3_image: '',
    text4: `Budaya antri ananda telah  tertanam dalam diri ananda, hal ini terlihat pada kebiasaan ananda untuk antri saat ingin melakukan kegiatan. Ananda juga sudah terbiasa mengucapkan kata minta tolong saat ingin meminta tolong kepada guru dan temannya, juga berterima kasih saat diberikan sesuatu. Memiliki sikap empati mau memaafkan bila merasa kesal, marah ataupun kecewa.  Ananda adalah anak yang ekspresif, mampu menunjukkan emosinya, saat marah dan bahagia. Ananda merupakan anak yang murah senyum kepada siapa saja.
Semoga kedepannya sikap baik ananda senantiasa ananda perlihatkan dalam kesehariannya
`,
    text4_image: '',
    text5: `Mampu mengenal dan menyusun kartu huruf yang disiapkan, begitu pula dalam menuliskan kalimat tanpa diberikan contoh.
Tak hanya itu ananda selalu antusias ketika waktunya memilih dan membaca buku pada kegiatan membaca di perpustakaan.” Ananda juga terlihat senang dan antusias mendengar guru dan temannya menceritakan buku atau ceritanya. Mengungkapkan keinginan, perasaan, dan pendapat dengan kalimat sederhana dalam berkomunikasi dengan teman maupun bunda. Semoga perkembangan Bahasa ananda Andi Nurul lebih meningkat di jenjang berikutnya.

`,
    text5_image: '',
    text6: `Menyusun lego dan balok membentuk suatu bentuk sudah mampu ananda lakukan, dan ini menunjukkan ananda mampu mengatasi masalah sederhana dengan nalar kritisnya. Kemampuan ananda juga dalam mengenal angka dan konsep angka sudah terlihat pada kegiatan mencari benda sesuai kartu angka yang ananda pilih. dapat mengklasifikasikan bentuk geometri (lingkaran, oval, segiempat, persegi panjang, dan  segitiga), semua ini merupakan perkembangan Kognitif ananda yang dapat dibanggakan. `,
    text6_image: '',
    text7: `Ananda menunjukkan keaktifannya dalam kegiatan kesenian, saat berlatih tari ananda sangat antusias menunjukkan kesediannya untuk berlatih, menggambar bebas  sesuai pengamatanya kemudian menceritakan ada apa saja digambarnya. Ananda dapat membuat aneka hasil karya selama  semester ini secara mandiri. Dapat  menjaga kerapian dan kebersihan diri dan merawat kerapihan kebersihan dan keutuhan benda mainan/ milik pribadinya merupakan sikap estetis yang ananda miliki. `,
    text7_image: '',
})

const AbsensSiswa = ref([]);

// Post
function submit() {
    Form.post(route('NilaiSiswa.store.form'), {
        preserveState:true,
        preserveScroll:true,
        onError: (err) => {
            var txt = "<ul>"
            Object.keys(err).forEach((item, val) => {
                txt += `<li>${err[item]}</li>`
            });
            txt += "</ul>";
            console.log(txt)
            swal({
                title: "Peringatan",
                icon: "error",
                html: txt,
                showCloseButton: true,
                showCancelButton: true,
            });
        },
        onFinish: ()=>{
            window.location.href = route('NilaiSiswa.index')
        }
    });
}

const editorOptions = {
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'script': 'sub' }, { 'script': 'super' }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'font': [] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            ['clean'],
            ['image',]
        ],
        syntax: {
            highlight: text => hljs.highlightAuto(text).value
        }
    }
}

</script>
<template>

    <Head title="Kelas" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Buku Penghubung Siswa Kelas</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" enctype="multipart/form-data"
                    class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Buat Buku Penghubung Siswa Kelas</p>
                    </div>
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50 relative box-content">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">

                            <div class="col-span-full">
                                <table>
                                    <tr>
                                        <td>Nama</td>
                                        <td> : {{ siswa.nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td> : {{ kelas.kode }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tahun Ajaran</td>
                                        <td>: {{ kelas.tahun_ajaran }}</td>
                                    </tr>
                                </table>


                            </div>
                            <div class="col-span-full">
                                <label for="tanggal" class="text-sm">Tanggal Laporan</label>
                                <TextInput id="tanggal" type="date" required placeholder="..............." v-model="Form.tanggal"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.tanggal" />

                            </div>
                            <div class="col-span-full">


                                <div class="relative overflow-x-auto border shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-2 py-3">
                                                    Teks
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Konten
                                                </th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td class="px-6 py-4 border bg-white" >Pendahuluan</td>
                                            <td class="px-6 py-4 border bg-white" >
                                                <quill-editor id="deskripsi" :options="editorOptions" required contentType="html" theme="snow"
                                                    placeholder="@deskripsi" v-model:content="Form.text1" class="w-full text-gray-900" />
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 border bg-white" >PERKEMBANGAN NILAI AGAMA DAN MORAL</td>
                                            <td class="px-6 py-4 border bg-white" >
                                                <quill-editor id="deskripsi" :options="editorOptions" required contentType="html" theme="snow"
                                                    placeholder="@deskripsi" v-model:content="Form.text2" class="w-full text-gray-900" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 border bg-white" >PERKEMBANGAN FISIK MOTORIK</td>
                                            <td class="px-6 py-4 border bg-white" >
                                                <quill-editor id="deskripsi" :options="editorOptions" required contentType="html" theme="snow"
                                                    placeholder="@deskripsi" v-model:content="Form.text3" class="w-full text-gray-900" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 border bg-white" >PERKEMBANGAN SOSIAL EMOSIONAL</td>
                                            <td class="px-6 py-4 border bg-white" >
                                                <quill-editor id="deskripsi" :options="editorOptions" required contentType="html" theme="snow"
                                                    placeholder="@deskripsi" v-model:content="Form.text4" class="w-full text-gray-900" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 border bg-white" >PERKEMBANGAN BAHASA</td>
                                            <td class="px-6 py-4 border bg-white" >
                                                <quill-editor id="deskripsi" :options="editorOptions" required contentType="html" theme="snow"
                                                    placeholder="@deskripsi" v-model:content="Form.text5" class="w-full text-gray-900" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 border bg-white" >PERKEMBANGAN KOGNITIF</td>
                                            <td class="px-6 py-4 border bg-white" >
                                                <quill-editor id="deskripsi" :options="editorOptions" required contentType="html" theme="snow"
                                                    placeholder="@deskripsi" v-model:content="Form.text6" class="w-full text-gray-900" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 border bg-white" >PERKEMBANGAN SENI </td>
                                            <td class="px-6 py-4 border bg-white" >
                                                <quill-editor id="deskripsi" :options="editorOptions" required contentType="html" theme="snow"
                                                    placeholder="@deskripsi" v-model:content="Form.text7" class="w-full text-gray-900" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                            <PrimaryButton type="submit">Simpan</PrimaryButton>
                        </div>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
