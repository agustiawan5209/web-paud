<script setup>
import { ref, defineProps } from 'vue';

const props = defineProps(['pdfUrl'])
import VuePdfEmbed from 'vue-pdf-embed'

// essential styles
import 'vue-pdf-embed/dist/style/index.css'

// optional styles
import 'vue-pdf-embed/dist/style/annotationLayer.css'
import 'vue-pdf-embed/dist/style/textLayer.css'

// either URL, Base64, binary, or document proxy
const pdfSource = ref(props.pdfUrl);
</script>

<template>
    <VuePdfEmbed annotation-layer text-layer :source="pdfSource" />
</template>
