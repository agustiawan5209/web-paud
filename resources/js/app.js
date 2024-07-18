import './bootstrap';
import '../css/app.css';

// Flowbite

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import '@vueup/vue-quill/dist/vue-quill.bubble.css';

/* import the fontawesome core */
import {
    library
} from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import {
    FontAwesomeIcon
} from '@fortawesome/vue-fontawesome'

import {
    fas
} from '@fortawesome/free-solid-svg-icons'
import {
    far
} from '@fortawesome/free-regular-svg-icons'
import {
    fab
} from '@fortawesome/free-brands-svg-icons'
/* add icons to the library */
library.add(fas, far, fab)


import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const appName = import.meta.env.VITE_APP_NAME || 'PAUD';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
        .component('font-awesome-icon', FontAwesomeIcon)
        .use(plugin)
        .use(ZiggyVue)
        .use(VueSweetalert2)
        .mixin({components:{QuillEditor}})
            .mount(el);
    },
    progress: {
        color: '#4B5563',
        type: 'bar',
        delay: 200,
        showSpinner: true,
    },
});
