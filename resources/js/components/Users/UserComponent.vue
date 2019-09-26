<template>
	<div class="container">
		<div class="block">
			<div class="block-header bg-primary-dark">
				<h3 class="block-title text-white text-center">USUARIOS</h3>
    			<button type="button" @click="showModal('UserModal',null,'Nuevo Usuario','store')" class="btn btn-success">
                    <i class="fa fa-plus"></i>
                </button>
			</div>
			<div class="block-content">
				<div class="row mb-4">
					<div class="col-2">
		                <div class="input-group input-group-primary">
			                <select v-model="sort_selected" @change="getData()" class="form-control" >
			                    <option  v-text="option" v-for="option in sort_table"></option>
			                </select>
			            </div>
		    		</div>
		    		<div class="col-4 offset-6">
		    			<div class="input-group input-group-primary">
		    				<div class="input-group-prepend">
                                <button @click="getData()" type="button" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
		                	<input @keyup.enter="getData()" type="text" class="form-control" v-model="search_table" placeholder="Buscar">
		                </div>
		    		</div>
				</div>
			    <div class="table-responsive">
			    	<table class="table table-hover table-vcenter">
			            <thead>
			                <tr>
			                    <th>#</th>
			                    <th>Nombre</th>
			                    <th>Correo Electronico</th>
			                    <th>Tipo</th>
			                    <th class="text-center" style="width: 100px;">Acciones</th>
			                </tr>
			            </thead>
			            <tbody>
			            	<tr v-if="!table_data.length > 0">
			                    <td colspan="5" class="bg-secondary text-center text-light">No se encontraron datos.</td>
			                </tr>
			                <tr v-else v-for="(item_table,index_for_table) in table_data" :key="index_for_table">
			                    <td v-text="index_for_table + 1"></td>
			                    <td class="font-w600 font-size-sm">
			                        <a href="#" v-text="item_table.username"></a>
			                    </td>
			                    <td class="font-w600 font-size-sm" v-text="item_table.email"></td>
			                    <td class="d-none d-sm-table-cell">
			                        <span class="badge badge-info">Business</span>
			                    </td>
			                    <td class="text-center">
			                        <div class="btn-group">
			                            <button type="button" @click="showModal('UserModal',item_table,'Editar Usuario','edit')" class="btn btn-sm btn-light" data-toggle="tooltip" title="Edit Client">
			                                <i class="fa fa-fw fa-pencil-alt"></i>
			                            </button>
			                            <button type="button" @click="deleteData(item_table.id)" class="btn btn-sm btn-light" data-toggle="tooltip" title="Remove Client">
			                                <i class="fa fa-fw fa-times"></i>
			                            </button>
			                        </div>
			                    </td>
			                </tr>
			            </tbody>
			        </table>
			    </div>
			    <pagination
			    	v-if="table_data.length > 0" 
			    	:table_pagination='table_pagination' 
			    	@changePage="changePage">
			    </pagination>
			</div>
		</div>

        <div class="modal fade" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="UserModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popout modal-xl" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title" v-text="modal_option"></h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <form class="row">
                                <!-- col-12 -->
                                <div class="form-group col-6">
                                    <label for="example-text-input">Nombres</label>
                                    <input type="text" v-model="personData.firstname" class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label for="example-email-input">Apellidos</label>
                                    <input type="text" v-model="personData.lastname" class="form-control">
                                </div>
                                <!-- col-12 -->
                                <div class="form-group col-4">
                                    <label>Tipo de Documento</label>
                                    <v-select label="name" v-model="personData.document" :options="list_documents"></v-select>
                                </div>
                                <div class="form-group col-4">
                                    <label>Nro de Documento</label>
                                    <input type="number" v-model="personData.nro_document" class="form-control">
                                </div>
                                <div class="form-group col-4">
                                    <label>Foto del Documento</label>
                                    <input type="file" @change="onFileChanged" class="form-control">
                                    <figure v-show="personData.img_document">
                                        <img align="center" :src="miniatura" class="img" width="300" height="200" alt="Foto del Documento">
                                    </figure>
                                </div>
                                <!-- col-12 -->
                                <div class="form-group col-4">
                                    <label>Fecha de Nacimiento</label>
                                    <datepicker :disabled-dates="no_dates" v-model="personData.birthday" input-class="bg-white form-control"></datepicker>
                                </div>
                                <div class="form-group col-8">
                                    <label>Direccion</label>
                                    <textarea v-model="personData.direction" class="form-control"></textarea>
                                </div>
                                <!-- col-12 -->
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
                                <!-- col-12 -->
                            </form>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Cerrar</button>

                            <button v-if="modal_type=='store'" @click="storeData()" type="button" class="btn btn-sm btn-success" data-dismiss="modal"><i class="fa fa-check mr-1"></i>Guardar</button>

                            <button v-if="modal_type=='edit'" @click="updateData()" type="button" class="btn btn-sm btn-success" data-dismiss="modal"><i class="fa fa-check mr-1"></i>Actualizar</button>
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
        this.getData();
        this.getDocuments();
        this.getTypes();
    },
    data() {
		return {
            // AUXILIARES
            no_dates:{to: new Date('1919-01-01')},
            mini_img: '',
            // DATOS BASICOS
            list_documents:[],
            list_types:[],
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
                birthday:new Date(),
                direction:null,
                local_phone:null,
                movil_phone:null,
                mail_contact:null
            },

            // DATOS DEL DATATABLE 
            table_data:[],
            sort_table:['10','25','50','100','250','500'],
            sort_selected:10,
            search_table:'',
            table_pagination:{
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
            },
            // DATOS MODAL
            modal_option:'',
            modal_type:'',
        }
	},
	methods:{
		userDataBlank(){
			this.userData={
            	id: 0,
                username: null,
                email: null,
                password:null
            }
		},
        personDataBlank(){
            this.personData={
                id: 0,
                firstname:null,
                lastname:null,
                nro_document:null,
                document:{
                    id:null,
                    name:null,
                },
                img_document:null,
                birthday:null,
                direction:null,
                local_phone:null,
                movil_phone:null,
                mail_contact:null
            }
        },
        getDocuments()
        {
            let url = "get-documents"
            axios.get(url).then(response => {
                this.list_documents = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        getTypes()
        {
            let url = "get-types"
            axios.get(url).then(response => {
                this.list_types = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
		getData(page)
        {
            let url =  "/get-users" 
            axios.post(url,{
                page   : page, 
                sort   : this.sort_selected, 
                search : this.search_table,
            }).then(response =>{
                this.table_pagination	= response.data.pagination
                this.table_data			= response.data.table.data
            	this.search_table		= ''
                this.$alertify.success('Usuarios Cargados')
            }).catch(errors =>{
                console.log(errors)
            })
        },
        storeData()
        {
            this.$root.loading('Verificando y guardando','Espere mientras se verifican los datos para registrar el nuevo Usuario')
            let url = '/store-user'
            axios.post(url,{
                userData:this.userData,
                personData:this.personData
            }).then(response => {
                swal.close()
                $("#UserModal").modal('hide')
        		this.$alertify.success('El usuario se registro con exito')
                this.getData()
            }).catch(errors => {
                swal.close()
                if (status = 204)
				{
					Object.values(errors.response.data.errors).forEach((element,indx) => {
                        this.$alertify.error(element.toString())
                    });
				}
            })
        },
        updateData()
        {
        	this.$root.loading('Verificando y actualizando','Espere mientras se verifican los datos para actualizar Usuario')
            let url = '/update-user'
            axios.post(url,{
                userData:this.userData,
                personData:this.personData
            }).then(response => {
                swal.close()
                $("#UserModal").modal('hide')
        		this.$alertify.success('El usuario fue actualizado con exito')
                this.getData()
            }).catch(errors => {
                swal.close()
                if (status = 204)
				{
					Object.values(errors.response.data.errors).forEach(element => {
                        this.$alertify.error(element.toString())
                    });
				}
            })
        },
        deleteData(idUser)
        {
        	swal({
                text: "Esta seguro que quiere eliminar este usuario?",
                icon: "warning",
                buttons: ['Cancelar','Eliminar'],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
        			this.$root.loading('Evaluando','Espere mientras se verifican los datos para eliminar Usuario')
		            let url = '/delete-user'
		            axios.post(url,{
		                id:idUser
		            }).then(response => {
		                swal.close()
		                this.getData()
		        		this.$alertify.success('El usuario fue eliminado con exito')
		            }).catch(errors => {
		                swal.close()
		            })
                }
            })
        },
        changePage: function (page) 
        {
            this.table_pagination.current_page = page;
            this.getData(page);
        },
        showModal(modal_id, model,option, type){
        	this.modal_option	= option
        	this.modal_type		= type
        	if (type == 'edit' && model !== null) {
        		this.userData = {
        			id:model.id,
        			username:model.username,
        			email:model.email,
        		}
                this.personData = {
                    id:model.person_id,
                    firstname:model.person.firstname,
                    lastname:model.person.lastname,
                    nro_document:model.person.nro_document,
                    document:{
                        id:model.person.document.id,
                        name:model.person.document.name,
                    },
                    img_document:model.person.img_document,
                    birthday:model.person.birthday,
                    direction:model.person.direction,
                    local_phone:model.person.local_phone,
                    movil_phone:model.person.movil_phone,
                    mail_contact:model.person.mail_contact
                }
        	}else{
                this.userDataBlank()
                this.personDataBlank()
            }
            $("#"+modal_id).modal('show')
        },
        onFileChanged(event){
            let file = event.target.files[0]
            let fileReader = new FileReader()
            fileReader.readAsDataURL(file)

            fileReader.onload = (e) => {
                this.mini_img = e.target.result
                this.personData.img_document = e.target.result
            }
        },
	},
    computed:{
        miniatura()
        {
            return this.mini_img
        }
    }
}
</script>