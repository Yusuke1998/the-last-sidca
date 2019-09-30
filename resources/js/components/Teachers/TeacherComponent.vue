<template>
	<div class="container">
		<div class="block">
			<div class="block-header bg-primary-dark">
				<h3 class="block-title text-white text-center">PROFESORES</h3>
    			<button type="button" data-toggle="tooltip" title="Nuevo Profesor" @click="showModal('TeacherModal',null,'Nuevo Profesor','store')" class="btn btn-success">
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
			                    <th>Nombres</th>
			                    <th>Apellidos</th>
			                    <th>Documento</th>
			                    <th class="text-center" style="width: 100px;">Acciones</th>
			                </tr>
			            </thead>
			            <tbody>
			            	<tr v-if="!table_data.length > 0">
			                    <td colspan="5" class="bg-secondary text-center text-light">No se encontraron datos.</td>
			                </tr>
			                <tr v-else v-for="(item_table,index_for_table) in table_data" :key="index_for_table">
			                    <td v-text="index_for_table + 1"></td>
			                    <td class="font-w600 font-size-sm" v-text="item_table.person.firstname"></td>
			                    <td class="font-w600 font-size-sm" v-text="item_table.person.lastname"></td>
			                    <td class="font-w600 font-size-sm" v-text="item_table.person.document.name+' '+item_table.person.nro_document"></td>
			                    <td class="text-center">
			                        <div class="btn-group">
			                            <button type="button" @click="showModal('TeacherModal',item_table,'Editar datos del Profesor','edit')" class="btn btn-sm btn-light" data-toggle="tooltip" title="Editar datos del Profesor">
			                                <i class="fa fa-fw fa-pencil-alt"></i>
			                            </button>
			                            <button type="button" @click="deleteData(item_table.id)" class="btn btn-sm btn-light" data-toggle="tooltip" title="Eliminar Profesor">
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

        <div class="modal fade" id="TeacherModal" tabindex="-1" role="dialog" aria-labelledby="TeacherModal" aria-hidden="true">
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
                                <div class="col-6">
                                	<div class="form-group">
                                		<label>Nro de Documento</label>
                                        <div class="input-group">
                                            <div :hidden="exist_document" class="input-group-prepend">
                                                <button @click="checkDocument" type="button" class="btn btn-primary">
                                                    <i class="fa fa-search mr-1"></i>
                                                </button>
                                            </div>
                                            <input type="number" @keyup.enter="checkDocument" v-model="teacherData.person.nro_document" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                	<div class="form-group">
                                		<label>Tipo de Documento</label>
                                    	<v-select :disabled="!exist_document" label="name" v-model="teacherData.person.document" :options="list_documents"></v-select>
                                	</div>
                                </div>
                                <!-- col-12 -->
                                <div class="col-6">
                                	<div class="form-group">
                                		<label for="">Nombres</label>
                                		<input :disabled="!exist_document" type="text" class="form-control" v-model="teacherData.person.firstname">
                                	</div>
                                </div>
                                <div class="col-6">
                                	<div class="form-group">
                                		<label for="">Apellidos</label>
                                		<input :disabled="!exist_document" type="text" class="form-control" v-model="teacherData.person.lastname">
                                	</div>
                                </div>
                                <!-- col-12 -->
                                <div class="col-4">
	                                <div class="form-group">
	                                    <label>Fecha de Nacimiento</label>
	                                    <datepicker :disabled="!exist_document" :disabled-dates="no_dates" v-model="teacherData.person.birthday" input-class="bg-white form-control"></datepicker>
	                                </div>
                                </div>
                                <div class="col-8">
	                                <div class="form-group">
	                                    <label>Direccion</label>
	                                    <textarea :disabled="!exist_document" v-model="teacherData.person.direction" class="form-control"></textarea>
	                                </div>
                                </div>
                                <!-- col-12 -->
                                <div class="col-4">
	                                <div class="form-group">
	                                    <label>Telefono Local</label>
	                                    <input :disabled="!exist_document" v-model="teacherData.person.local_phone" class="form-control"></input>
	                                </div>
                                </div>
                                <div class="col-4">
	                                <div class="form-group">
	                                    <label>Telefono Movil</label>
	                                    <input :disabled="!exist_document" v-model="teacherData.person.movil_phone" class="form-control"></input>
	                                </div>
                                </div>
                                <div class="col-4">
	                                <div class="form-group">
	                                    <label>Correo Electronico</label>
	                                    <input :disabled="!exist_document" v-model="teacherData.person.mail_contact" class="form-control"></input>
	                                </div>
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
    },
    data() {
		return {
            // AUXILIARES
            document:{
            	nro:null,
            	type:null
            },
            exist_document:false,
            no_dates:{to: new Date('1919-01-01')},
            list_documents:[],
            teacherData:{
            	id_teacher:0,
                person:{
                	id: 0,
	                firstname:null,
	                lastname:null,
	                nro_document:null,
	                document:{
                        id:0,
	                    name:null,
	                },
	                img_document:null,
	                birthday:new Date(),
	                direction:null,
	                local_phone:null,
	                movil_phone:null,
	                mail_contact:null
	        	}
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
		TeacherDataBlank(){
			this.teacherData={
            	id_teacher: 0,
                person:{
            		id: 0,
                	firstname:null,
	                lastname:null,
	                nro_document:null,
	                document:{
                        id:0,
	                    name:null,
	                },
	                img_document:null,
	                birthday:null,
	                direction:null,
	                local_phone:null,
	                movil_phone:null,
	                mail_contact:null
                }
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
        checkDocument()
        {
        	if (this.teacherData.person.nro_document !== null) {
	        	this.document.nro 	= this.teacherData.person.nro_document
        		let url = '/check-document'
	        	axios.post(url,
	        		this.document
	        	).then(response => {
	        		if (response.data !== 0) {
	        			if (response.data.types.length > 0) {
	        				response.data.types.forEach(data=>{
	        					if (data.name == 'teacher') {
                					$("#TeacherModal").modal('hide')
	        						this.$alertify.warning('Esta persona ya esta registrada como profesor!')
	        						return;
	        					}else{
					        		this.exist_document = true
					        		this.teacherData={
					        			id_teacher:0,
						                person:{
						                	id:response.data.id,
						                	firstname:response.data.firstname,
						                	lastname:response.data.lastname,
							                nro_document:response.data.nro_document,
							                document:{
                                                id:response.data.document.id,
							                    name:response.data.document.name,
							                },
							                img_document:response.data.img_document,
							                birthday:response.data.birthday,
							                direction:response.data.direction,
							                local_phone:response.data.local_phone,
							                movil_phone:response.data.movil_phone,
							                mail_contact:response.data.mail_contact
							            }
						            }
	        					}
	        				});
	        			}
	        		}else{
		        		this.exist_document = true
	        			this.$alertify.warning('No se encontraron coincidencias con el documento')
	        			this.$alertify.success('Puedes registrar todos los datos y guardarlos')
	        		}
	            }).catch(errors =>{
	                if (status = 204)
					{
						Object.values(errors.response.data.errors).forEach((element,indx) => {
	                        this.$alertify.error(element.toString())
	                    });
					}
	            })
        	}else{
        		this.$alertify.error('El número de documento es requerido!')
        	}
        },
		getData(page)
        {
            let url =  "/get-teachers" 
            axios.post(url,{
                page   : page, 
                sort   : this.sort_selected, 
                search : this.search_table,
            }).then(response =>{
                this.table_pagination	= response.data.pagination
                this.table_data			= response.data.table.data
            	this.search_table		= ''

            	if (this.table_data.length > 0) {
                	this.$alertify.success('Exito al cargar Profesores')
            	}else{
                	this.$alertify.warning('No se encontraron coincidencias')
            	}
            }).catch(errors =>{
                console.log(errors)
            })
        },
        storeData()
        {
            this.$root.loading('Verificando y guardando','Espere mientras se verifican los datos para registrar est@ profesor@')
            let url = '/store-teacher'
            axios.post(url,{
                teacherData :this.teacherData
            }).then(response => {
                swal.close()
                $("#TeacherModal").modal('hide')
        		this.$alertify.success('El profesor se registro con exito')
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
        	this.$root.loading('Verificando y actualizando','Espere mientras se verifican los datos para actualizar est@ profesor@')
            let url = '/update-teacher'
            axios.post(url,{
                teacherData :this.teacherData
            }).then(response => {
                swal.close()
                $("#TeacherModal").modal('hide')
        		this.$alertify.success('El profesor se actualizo con exito')
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
        deleteData(idProf)
        {
        	swal({
                text: "Esta seguro que quiere eliminar este profesor?",
                icon: "warning",
                buttons: ['Cancelar','Eliminar'],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
        			this.$root.loading('Evaluando','Espere mientras se verifican los datos para eliminar este profesor')
		            let url = '/delete-teacher'
		            axios.post(url,{
		                id:idProf
		            }).then(response => {
		                swal.close()
		                this.getData()
		        		this.$alertify.success('El profesor fue eliminado con exito')
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
                this.exist_document = true
        		this.teacherData={
	            	id_teacher:model.id,
	                person:{
	                	id:model.person.id,
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
	            }
        	}else{
                this.TeacherDataBlank()
                this.exist_document = false
            }
            $("#"+modal_id).modal('show')
        }
	}
}
</script>