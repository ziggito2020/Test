import { createApp } from 'vue'
//import HelloWorld from './components/HelloWorld.vue';
import Exercise from './components/Exercise.vue';

import Toaster from '@meforma/vue-toaster';

const app = createApp({});
app.component('exercise', Exercise).use(Toaster, { position: 'top', dismissible: true }).mount('#app');

require('./bootstrap');
