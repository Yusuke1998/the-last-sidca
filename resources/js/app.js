require('./bootstrap');

window.Vue = require('vue');

// Componentes
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    methods:{
        /* REUTILIZADAS */
        loading(name, content, img){
            swal({
                title:name,
                text:content,
                button:{
                    text: "Ok!",
                    closeModal: false,
                },
                icon:img,
                closeOnClickOutside: false,
                timer: 3000
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
