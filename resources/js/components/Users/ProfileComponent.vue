<template>
	<div class="bg-image" style="background-image: url('/img/P6265793.JPG');">
        <div class="bg-black-50">
            <div class="content content-full text-center text-uppercase">
                <h1 class="h2 text-white mb-0" v-text="userData.username"></h1>
            </div>
        </div>
        <div class="bg-white border-bottom">
            <div class="content content-boxed">
                <div class="card mb-3">
                    <div class="card-header">Datos Personales</div>
                    <div class="card-body row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Nombres</label>
                                <input class="form-control" type="text" v-model="personData.firstname">
                            </div>
                            <div class="form-group">
                                <label>Apellidos</label>
                                <input class="form-control" type="text" v-model="personData.lastname">
                            </div>
                            <div class="form-group">
                                <label>Fecha de Nacimiento</label>
                                <datepicker v-model="personData.birthday" input-class="bg-white form-control"></datepicker>
                            </div>
                            <div class="form-group">
                                <label>Direccion</label>
                                <textarea v-model="personData.direction" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Tipo de Documento</label>
                                <v-select label="name" v-model="personData.document" :options="list_documents"></v-select>
                            </div>
                            <div class="form-group">
                                <label>Nro de Documento</label>
                                <input type="number" v-model="personData.nro_document" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Foto de Documento</label>
                                <picture-input
                                  :prefill="'/storage/'+prefill_img"
                                  @change="onChange"
                                  :crop="false"
                                  size="10" 
                                  buttonClass="btn btn-sm"
                                  :hideChangeButton="true"
                                  :customStrings="{
                                    upload: '<h5>Excelente!</h5>',
                                    drag: '<h5>Foto de Documento!<h5>',
                                    change: 'Cambiar',
                                    remove: 'Eliminar',
                                    select: 'Selecciona',
                                    fileType: 'Este archivo no esta soportado.',
                                  }">
                                </picture-input>
                            </div>
                        </div>
                        <div class="col-12">
                            <button @click="updatePerson" type="button" class="btn btn-primary float-right">Actualizar</button>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">Datos de Usuario</div>
                    <div class="card-body row">
                        <div class="col-12 row">
                            <div class="form-group col-4">
                                <label for="example-text-input">Nombre de Usuario</label>
                                <input type="text" v-model="userData.username" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label for="example-email-input">Correo Electronico</label>
                                <input type="email" v-model="userData.email" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Contraseña</label>
                                <input type="password" v-model="userData.password" class="form-control">
                            </div>
                            <div class="col-12">
                                <button @click="updateUser" type="button" class="btn btn-primary float-right">Actualizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    mounted(){
        this.getID();
        this.getUser();
        this.getDoc();
    },
    data() {
		return {
            prefill_img:null,
            no_dates:{to: new Date('1919-01-01')},
            list_documents:[],
            userID:null,
            userData: {
                id: 0,
                username: null,
                email: null,
                password:null,
            },
            personData:{
                id: 0,
                firstname:null,
                lastname:null,
                nro_document:null,
                document:{
                    name:null,
                },
                img_document:null,
                birthday:null,
                direction:null,
                local_phone:null,
                movil_phone:null,
                mail_contact:null
            },
        }
	},
    methods:{
        onChange(image) {
          if (image) {
            this.personData.img_document = image
          }
        },
        getDoc()
        {
            let url = location.origin+"/get-documents"
            axios.get(url).then(response => {
                this.list_documents = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        getID()
        {
            this.username = location.href.split('/')[4]
        },
        getUser()
        {
            let url = "/profile-user/"+this.username
            axios.get(url).then(response => {
                let moment = require('moment')
                this.prefill_img = response.data.person.img_document
                this.userData = {
                    id:response.data.id,
                    username:response.data.username,
                    email:response.data.email,
                }
                this.personData = {
                    id:response.data.person_id,
                    firstname:response.data.person.firstname,
                    lastname:response.data.person.lastname,
                    nro_document:response.data.person.nro_document,
                    document:{
                        id:response.data.person.document.id,
                        name:response.data.person.document.name,
                    },
                    img_document:response.data.person.img_document,
                    birthday:moment(response.data.person.birthday).toDate(),
                    direction:response.data.person.direction,
                    local_phone:response.data.person.local_phone,
                    movil_phone:response.data.person.movil_phone,
                    mail_contact:response.data.person.mail_contact
                }
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        updateUser()
        {
            let url = '/update-user'
            axios.post(url,{
                userData:this.userData
            }).then(response => {
                this.$alertify.success('Usuario actualizado con exito')
                this.getUser()
            }).catch(errors => {
                if (status = 204)
                {
                    Object.values(errors.response.data.errors).forEach(element => {
                        this.$alertify.error(element.toString())
                    });
                }
            })
        },
        updatePerson()
        {
            let url = '/update-user'
            axios.post(url,{
                personData:this.personData
            }).then(response => {
                this.$alertify.success('Persona actualizada con exito')
                this.getUser()
            }).catch(errors => {
                if (status = 204)
                {
                    Object.values(errors.response.data.errors).forEach(element => {
                        this.$alertify.error(element.toString())
                    });
                }
            })
        }
    }
}
</script>