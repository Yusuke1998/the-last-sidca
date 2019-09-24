require('./bootstrap');

window.Vue = require('vue');

// DECLARANDO COMPONENTES
Vue.component('pagination', require('./components/Utilities/PaginationComponent.vue').default);
Vue.component('chart-component', require('./components/Charts/ChartComponent.vue').default);
Vue.component('user-component', require('./components/Users/UserComponent.vue').default);

/* PLUGINS */
import swal from 'sweetalert';

import PictureInput from 'vue-picture-input';
    Vue.component('picture-input', PictureInput)

import VueAlertify from 'vue-alertify';
    Vue.use(VueAlertify,{
        notifier: {
            delay: 5,
            position: 'top-right',
            closeButton: true,
        }
    });

import Multiselect from 'vue-multiselect';
    Vue.component('multiselect', Multiselect)

import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
    Vue.component('v-select', vSelect)

import Datepicker from 'vuejs-datepicker';
    Vue.component('datepicker', Datepicker)
/* FIN DE PLUGINS */

const app = new Vue({
    el: '#app',
    methods:{
        /* REUTILIZABLESS */
        loading(name, content){
            swal({
                title:name,
                text:content,
                button:{
                    text: "Ok!",
                    closeModal: false,
                },
                icon:'/img/spin.gif',
                closeOnClickOutside: false,
                timer: 3500
            })
        },
        alert(name, content, img){
            swal({
                title:name,
                text:content,
                button:{
                    text:'Ok'
                },
                icon:img,
            })
        },
    }
});
