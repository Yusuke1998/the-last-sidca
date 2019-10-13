<template>
	<div class="container">
		<div class="block">
			<div class="block-header bg-primary-dark">
				<h3 class="block-title text-white text-center">PERSONAL DOCENTE <span v-show="type_contract.type" v-text="type_contract.type"></span></h3>
    			<button type="button" data-toggle="tooltip" title="Nuevo" @click="showModal('TeacherModal',null,'Nuevo','store')" class="btn btn-success">
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
                                <button data-toggle="tooltip" title="Buscar" @click="getData()" type="button" class="btn btn-primary">
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
			                    <th>Condicion</th>
			                    <th class="text-center" style="width: 100px;">Acciones</th>
			                </tr>
			            </thead>
			            <tbody>
			            	<tr v-if="!table_data.length > 0">
			                    <td colspan="6" class="bg-secondary text-center text-light">No se encontraron datos.</td>
			                </tr>
			                <tr v-else v-for="(item_table,index_for_table) in table_data" :key="index_for_table">
			                    <td v-text="index_for_table + 1"></td>
			                    <td class="font-w600 font-size-sm" v-text="item_table.person.firstname"></td>
			                    <td class="font-w600 font-size-sm" v-text="item_table.person.lastname"></td>
                                <td class="font-w600 font-size-sm" v-text="item_table.person.document.name+' '+item_table.person.nro_document"></td>
			                    <td class="font-w600 font-size-sm text-uppercase" v-text="item_table.condition.name"></td>
			                    <td class="text-center">
			                        <div class="btn-group">
                                        <button type="button" @click="showModal('ProModal',item_table,'Sintesis Curricular','sintCu')" class="btn btn-sm btn-light" data-toggle="tooltip" title="Sintesis Curricular">
                                            <i class="fa fa-fw fa-address-card"></i>
                                        </button>
			                            <button type="button" @click="showModal('TeacherModal',item_table,'Editar','edit')" class="btn btn-sm btn-light" data-toggle="tooltip" title="Editar">
			                                <i class="fa fa-fw fa-pencil-alt"></i>
			                            </button>
			                            <button type="button" @click="deleteData(item_table.id)" class="btn btn-sm btn-light" data-toggle="tooltip" title="Eliminar">
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

                                <div class="col-12 text-center">
                                    <h4>Informacion Personal</h4>
                                </div>

                                <!-- col-12 -->
                                <div class="col-6">
                                	<div class="form-group">
                                		<label>Nro de Documento</label>
                                        <div class="input-group">
                                            <div :hidden="exist_document" class="input-group-prepend">
                                                <button @click="checkDocument" type="button" class="btn btn-primary"data-toggle="tooltip" title="Buscar">
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
	                                    <datepicker
                                        :full-month-name="true"
                                        :language="es" 
                                        :disabled="!exist_document" 
                                        :disabled-dates="no_dates" 
                                        v-model="teacherData.person.birthday"
                                        :input-class="(exist_document)?'bg-white form-control':'form-control'"></datepicker>
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

                                <div class="col-12 text-center">
                                    <h4>Lugar donde está Adscrito</h4>
                                </div>

                                <!-- col-12 -->
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Sede</label>
                                        <v-select 
                                        :disabled="!exist_document" 
                                        @input="getAreas" 
                                        label="name" 
                                        v-model="teacherData.headquarter" 
                                        :options="list_headquarters"></v-select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Area</label>
                                        <v-select 
                                        :disabled="teacherData.headquarter.id == 0" 
                                        @input="getPrograms" 
                                        label="name" 
                                        v-model="teacherData.area" 
                                        :options="list_areas"></v-select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Programa</label>
                                        <v-select 
                                        :disabled="teacherData.area.id == 0" 
                                        @input="setExtras" 
                                        label="name" 
                                        v-model="teacherData.program" 
                                        :options="list_programs"></v-select>
                                    </div>
                                </div>
                                <!-- col-12 -->
                                <template v-if="teacherData.headquarter.id > 0 && teacherData.area.id > 0 && teacherData.program.id > 0">
                                    <div class="col-4" v-if="list_cores.length > 0">
                                        <div class="form-group">
                                            <label>Nucleo</label>
                                            <v-select 
                                            :disabled="teacherData.extension.id > 0 || teacherData.t_classroom.id > 0" 
                                            label="name" 
                                            v-model="teacherData.core" 
                                            :options="list_cores"></v-select>
                                        </div>
                                    </div>
                                    <div class="col-4" v-if="list_extensions.length > 0">
                                        <div class="form-group">
                                            <label>Extension</label>
                                            <v-select 
                                            :disabled="teacherData.core.id > 0 || teacherData.t_classroom.id > 0" 
                                            label="name" 
                                            v-model="teacherData.extension" 
                                            :options="list_extensions"></v-select>
                                        </div>
                                    </div>
                                    <div class="col-4" v-if="list_t_classrooms.length > 0">
                                        <div class="form-group">
                                            <label>Aula Territorial</label>
                                            <v-select 
                                            :disabled="teacherData.extension.id > 0 || teacherData.core.id > 0" 
                                            label="name" 
                                            v-model="teacherData.t_classroom" 
                                            :options="list_t_classrooms"></v-select>
                                        </div>
                                    </div>
                                </template>
                                <!-- col-12 -->

                                <div class="col-12 text-center">
                                    <h4>Otros</h4>
                                </div>

                                <!-- col-12 -->
                                <div class="col-12" v-if="type_contract.type=='contratado'">
                                    <div class="form-group">
                                        <label>Condicion</label>
                                        <v-select 
                                        :disabled="!exist_document" 
                                        @input="getAreas" 
                                        v-model="type_contract.condition" 
                                        :options="['contratado','honorario profesional','auxiliar docente']"></v-select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Asignatura</label>
                                        <v-select 
                                        :disabled="teacherData.headquarter.id == 0" 
                                        @input="getPrograms" 
                                        label="name" 
                                        v-model="teacherData.area" 
                                        :options="list_areas"></v-select>
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

        <div class="modal fade" id="ProModal" tabindex="-1" role="dialog" aria-labelledby="modal-block-extra-large" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
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
                            <div class="row">
                                <div class="block col-12">
                                    <div class="block-title">
                                        Pregrado
                                    </div>
                                    <div class="block-content">
                                        <form class="row">
                                            <!-- col-12 -->
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Universidad</label>
                                                    <v-select 
                                                    @input="getTitles(preGData.university)" 
                                                    label="name"
                                                    v-model="preGData.university" 
                                                    :options="list_universities"></v-select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Titulo Obtenido</label>
                                                    <v-select 
                                                    :disabled="preGData.university.id == 0"
                                                    placeholder="Titulo" 
                                                    label="title"
                                                    v-model="preGData.title" 
                                                    :options="list_titles"></v-select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Año de Obtención</label>
                                                    <datepicker
                                                    :language="es"
                                                    :minimum-view="'year'"
                                                    :format="'yyyy'" 
                                                    :disabled="preGData.title.id == 0"
                                                    placeholder="Año" 
                                                    :disabled-dates="no_dates" 
                                                    v-model="preGData.date" 
                                                    :input-class="(preGData.title.id == !0)?'bg-white form-control':'form-control'"></datepicker>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <button @click.prevent="preGDataSave" class="btn btn-outline-primary">
                                                    <i class="fa fa-check-circle"></i>
                                                </button>
                                            </div>
                                            <!-- col-12 -->
                                            <div class="col-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Universidad</th>
                                                            <th>Titulo</th>
                                                            <th>Año</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-if="list_preGTeacher.length == 0">
                                                            <td class="text-center text-white bg-primary-dark" colspan="3">No hay registros...</td>
                                                        </tr>
                                                        <tr v-else v-for="pregrado in list_preGTeacher">
                                                            <td v-text="pregrado.university.name"></td>
                                                            <td v-text="pregrado.title.title"></td>
                                                            <td v-text="pregrado.date"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="block col-12">
                                    <div class="block-title">
                                        Posgrado
                                    </div>
                                    <div class="block-content">
                                        <form class="row">
                                            <!-- col-12 -->
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Universidad</label>
                                                    <v-select 
                                                    @input="getTitles(postGData.university)" 
                                                    label="name"
                                                    v-model="postGData.university" 
                                                    :options="list_universities"></v-select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Titulo Obtenido</label>
                                                    <v-select
                                                    :disabled="postGData.university.id == 0" 
                                                    placeholder="Titulo" 
                                                    label="title"
                                                    v-model="postGData.title" 
                                                    :options="list_titles"></v-select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Año de Obtención</label>
                                                    <datepicker
                                                    :language="es"
                                                    :minimum-view="'year'"
                                                    :format="'yyyy'" 
                                                    :disabled="postGData.title.id == 0"
                                                    placeholder="Año" 
                                                    :disabled-dates="no_dates" 
                                                    v-model="postGData.date" 
                                                    :input-class="(postGData.title.id == !0)?'bg-white form-control':'form-control'"></datepicker>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <button @click.prevent="postGDataSave" class="btn btn-outline-primary">
                                                    <i class="fa fa-check-circle"></i>
                                                </button>
                                            </div>
                                            <!-- col-12 -->
                                            <div class="col-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Universidad</th>
                                                            <th>Titulo</th>
                                                            <th>Año</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-if="list_postGTeacher.length == 0">
                                                            <td class="text-center text-white bg-primary-dark" colspan="3">No hay registros...</td>
                                                        </tr>
                                                        <tr v-else v-for="posgrado in list_postGTeacher">
                                                            <td v-text="posgrado.university.name"></td>
                                                            <td v-text="posgrado.title.title"></td>
                                                            <td v-text="posgrado.date"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" @click="showModal('ConditionModal',null,'Condición','condition')" class="btn btn-sm btn-light" data-toggle="tooltip" title="Condicion">
                                <i class="fa fa-fw fa-object-group"></i>
                            </button>
                            <button type="button" @click="showModal('CategoryModal',null,'Categoria','category')" class="btn btn-sm btn-light" data-toggle="tooltip" title="Categoria">
                                <i class="fa fa-fw fa-newspaper"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ConditionModal" tabindex="-1" role="dialog" aria-labelledby="modal-block-extra-large" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
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
                            
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Cerrar</button>
                            <button v-if="modal_type=='sintCu'" @click="alert('Hola Mundo')" type="button" class="btn btn-sm btn-success" data-dismiss="modal"><i class="fa fa-check mr-1"></i>Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="CategoryModal" tabindex="-1" role="dialog" aria-labelledby="modal-block-extra-large" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
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
                            
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Cerrar</button>
                            <button v-if="modal_type=='sintCu'" @click="alert('Hola Mundo')" type="button" class="btn btn-sm btn-success" data-dismiss="modal"><i class="fa fa-check mr-1"></i>Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</template>
<script>
import {en, es} from 'vuejs-datepicker/dist/locale'
export default {
    mounted(){
        this.getDocuments();
        this.typeContract();
    	this.getData();
        this.getHeadquarters();
    },
    data() {
		return {
            en: en,
            es: es,
            // AUXILIARES
            type_contract:{
                type:null,
                condition:null
            },
            document:{
            	nro:null,
            	type:null
            },
            postGData:{
                id:0,
                teacher_id:0,
                title:{
                    id:0,
                    title:null
                },
                university:{
                    id:0,
                    name:null
                },
                date:null
            },
            preGData:{
                id:0,
                teacher_id:0,
                title:{
                    id:0,
                    title:null
                },
                university:{
                    id:0,
                    name:null
                },
                date:null
            },
            exist_document:false,
            no_dates:{to: new Date('1919-01-01')},
            list_titles:[],
            list_universities:[],
            list_documents:[],
            list_headquarters:[],
            list_areas:[],
            list_programs:[],
            list_cores:[],
            list_t_classrooms:[],
            list_extensions:[],
            list_preGTeacher:[],
            list_postGTeacher:[],
            teacherData:{
                id_teacher:0,
            	headquarter:{
                    id:0,
                    name:null
                },
                area:{
                    id:0,
                    name:null
                },
                program:{
                    id:0,
                    name:null
                },
                core:{
                    id:0,
                    name:null
                },
                extension:{
                    id:0,
                    name:null
                },
                t_classroom:{
                    id:0,
                    name:null
                },
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
                headquarter:{
                    id:0,
                    name:null
                },
                area:{
                    id:0,
                    name:null
                },
                program:{
                    id:0,
                    name:null
                },
                core:{
                    id:0,
                    name:null
                },
                extension:{
                    id:0,
                    name:null
                },
                t_classroom:{
                    id:0,
                    name:null
                },
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
        getPreG(){
            let url = location.origin+"/get-pre-teacher/"+this.teacherData.id_teacher
            axios.get(url).then(response => {
                this.list_preGTeacher = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        blankPreG(){
            preGData={
                id:0,
                teacher_id:0,
                title:{
                    id:0,
                    title:null
                },
                university:{
                    id:0,
                    name:null
                },
                date:null
            }
        },
        preGDataSave(){
            this.$root.loading('Verificando y guardando','Espere mientras se verifican los datos para registrar este pregrado')
            let url = '/save-preG-title'
            axios.post(url,{
                preGData : this.preGData,
            }).then(response => {
                swal.close()
                this.$alertify.success('Registro exitoso')
                this.blankPreG()
                this.getPreG()
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
        getPostG(){
            let url = location.origin+"/get-post-teacher/"+this.teacherData.id_teacher
            axios.get(url).then(response => {
                this.list_postGTeacher = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        blankPostG(){
            postGData={
                id:0,
                teacher_id:0,
                title:{
                    id:0,
                    title:null
                },
                university:{
                    id:0,
                    name:null
                },
                date:null
            }
        },
        postGDataSave(){
            this.$root.loading('Verificando y guardando','Espere mientras se verifican los datos para registrar este posgrado')
            let url = '/save-postG-title'
            axios.post(url,{
                postGData : this.postGData,
            }).then(response => {
                swal.close()
                this.$alertify.success('Registro exitoso')
                this.blankPostG()
                this.getPostG()
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
        getUniversities(){
            let url = location.origin+"/get-universities"
            axios.get(url).then(response => {
                this.list_universities = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        getTitles(Uni){
            if (Uni.id !== null) {
                this.list_titles = Uni.titles
            }
        },
        getHeadquarters()
        {
            let url = location.origin+"/get-headquarters"
            axios.get(url).then(response => {
                this.list_headquarters = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        getAreas()
        {
            let idH = this.teacherData.headquarter.id 
            let url = location.origin+"/get-areas/"+idH
            axios.get(url).then(response => {
                this.list_areas = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
            if (this.list_areas.length == 0) {
                this.teacherData.area={
                    id:0,
                    name:null
                }
            }
        },
        getPrograms()
        {
            let idA = this.teacherData.area.id 
            let url = location.origin+"/get-programs/"+idA
            axios.get(url).then(response => {
                this.list_programs = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
            if (this.list_programs.length == 0) {
                this.teacherData.program={
                    id:0,
                    name:null
                }
            }
        },
        getCores()
        {
            let idA = this.teacherData.area.id 
            let idP = this.teacherData.program.id
            let url = location.origin+'/get-cores/'+idA+'/'+idP
            axios.get(url).then(response => {
                this.list_cores = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        getExtensions()
        {
            let idA = this.teacherData.area.id 
            let idP = this.teacherData.program.id
            let url = location.origin+'/get-extensions/'+idA+'/'+idP
            axios.get(url).then(response => {
                this.list_extensions = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        getTClassrooms()
        {
            let idA = this.teacherData.area.id 
            let idP = this.teacherData.program.id
            let url = location.origin+'/get-tclassrooms/'+idA+'/'+idP
            axios.get(url).then(response => {
                this.list_t_classrooms = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        setExtras()
        {
            this.getCores();
            this.getExtensions();
            this.getTClassrooms();
        },
		getDocuments()
        {
            let url = location.origin+"/get-documents"
            axios.get(url).then(response => {
                this.list_documents = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        typeContract(){
            switch (location.pathname){
                case "/profesores/ordinarios":
                {
                    this.type_contract.type = 'ordinario';
                    break;  
                }
                case "/profesores/contratados":
                {
                    this.type_contract.type = 'contratado';
                    break;  
                }
            }
        },
        checkDocument()
        {
        	if (this.teacherData.person.nro_document !== null) {
	        	this.document.nro 	= this.teacherData.person.nro_document
        		let url = location.origin+'/check-document'
	        	axios.post(url,
	        		this.document
	        	).then(response => {
	        		if (response.data !== 0) {
	        			if (response.data.types.length > 0) {
	        				response.data.types.forEach(data=>{
	        					if (data.name == 'teacher') {
                					$("#TeacherModal").modal('hide')
	        						this.$alertify.warning('Esta persona ya esta registrada como docente!')
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
                type   : this.type_contract
            }).then(response =>{
                this.table_pagination	= response.data.pagination
                this.table_data			= response.data.table.data
                this.search_table       = ''
            	if (this.table_data.length > 0) {
                	this.$alertify.success('Exito al cargar docentes')
            	}else{
                	this.$alertify.warning('No se encontraron coincidencias')
            	}
            }).catch(errors =>{
                console.log(errors)
            })
        },
        storeData()
        {
            this.$root.loading('Verificando y guardando','Espere mientras se verifican los datos para registrar este docente')
            let url = '/store-teacher'
            axios.post(url,{
                teacherData : this.teacherData,
                type : this.type_contract
            }).then(response => {
                swal.close()
                $("#TeacherModal").modal('hide')
        		this.$alertify.success('El docente se registro con exito')
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
        	this.$root.loading('Verificando y actualizando','Espere mientras se verifican los datos para actualizar este docente')
            let url = '/update-teacher'
            axios.post(url,{
                teacherData :this.teacherData,
                type : this.type_contract
            }).then(response => {
                swal.close()
                $("#TeacherModal").modal('hide')
        		this.$alertify.success('El docente se actualizo con exito')
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
                text: "Esta seguro que quiere eliminar este docente?",
                icon: "warning",
                buttons: ['Cancelar','Eliminar'],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
        			this.$root.loading('Evaluando','Espere mientras se verifican los datos para eliminar este docente')
		            let url = '/delete-teacher'
		            axios.post(url,{
		                id:idProf
		            }).then(response => {
		                swal.close()
		                this.getData()
		        		this.$alertify.success('El docente fue eliminado con exito')
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
                    headquarter:{
                        id:model.headquarter.id,
                        name:model.headquarter.name
                    },
                    area:{
                        id:model.area.id,
                        name:model.area.name
                    },
                    program:{
                        id:model.program.id,
                        name:model.program.name
                    },
                    core:{
                        id:0,
                        name:null
                    },
                    extension:{
                        id:0,
                        name:null
                    },
                    t_classroom:{
                        id:0,
                        name:null
                    },
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
                if (model.condition !== undefined && model.condition !== null) {
                    this.type_contract.condition = model.condition.name
                    this.type_contract.type = model.contract
                }
                if (model.core !== undefined && model.core !== null) {
                    this.teacherData.core={
                        id:model.core.id,
                        name:model.core.name
                    }
                }
                if (model.extension !== undefined && model.extension !== null) {
                    this.teacherData.extension={
                        id:model.extension.id,
                        name:model.extension.name
                    }
                }
                if (model.territorial_classroom !== undefined && model.territorial_classroom !== null) {
                    this.teacherData.t_classroom={
                        id:model.territorial_classroom.id,
                        name:model.territorial_classroom.name
                    }
                }
        	}else{
                this.TeacherDataBlank()
                this.exist_document = false
            }

            if (this.modal_type == 'sintCu') {
                this.teacherData.id_teacher=model.id
                this.postGData.teacher_id=model.id
                this.preGData.teacher_id=model.id
                this.getPreG();
                this.getPostG();
                this.getUniversities();
            }

            $("#"+modal_id).modal('show')
        }
	}
}
</script>