require('./bootstrap');

window.Vue = require('vue');

// DECLARANDO COMPONENTES
Vue.component('pagination', require('./components/Utilities/PaginationComponent.vue').default);
Vue.component('chart-component', require('./components/Charts/ChartComponent.vue').default);
Vue.component('user-component', require('./components/Users/UserComponent.vue').default);
Vue.component('profile-component', require('./components/Users/ProfileComponent.vue').default);
Vue.component('teacher-component', require('./components/Teachers/TeacherComponent.vue').default);
Vue.component('history-component', require('./components/Teachers/HistoryComponent.vue').default);
Vue.component('notification-component', require('./components/Notifications/NotificationComponent.vue').default);
// PRECARGA
Vue.component('university-component', require('./components/Preload/UniversityComponent.vue').default);
Vue.component('title-component', require('./components/Preload/TitleComponent.vue').default);
Vue.component('period-component', require('./components/Preload/PeriodComponent.vue').default);
Vue.component('headquarter-component', require('./components/Preload/HeadquarterComponent.vue').default);
Vue.component('area-component', require('./components/Preload/AreaComponent.vue').default);
Vue.component('core-component', require('./components/Preload/CoreComponent.vue').default);
Vue.component('extension-component', require('./components/Preload/ExtensionComponent.vue').default);
Vue.component('tclassroom-component', require('./components/Preload/TclassroomComponent.vue').default);
Vue.component('program-component', require('./components/Preload/ProgramComponent.vue').default);
Vue.component('subject-component', require('./components/Preload/SubjectComponent.vue').default);
Vue.component('authority-component', require('./components/Preload/AuthorityComponent.vue').default);

/* PLUGINS */
import swal from 'sweetalert';

import VueAlertify from 'vue-alertify';
    Vue.use(VueAlertify,{
        notifier: {
            delay: 5,
            position: 'top-right',
            closeButton: true,
        }
    });

import PictureInput from 'vue-picture-input'
    Vue.component('picture-input', PictureInput);

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
