<template>
	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
            	<form class="form-group" @submit.prevent>
                    <div class="input-group">
                        <input type="number" @keyup.enter="searchTeacher" v-model="dni" class="form-control" placeholder="Numero de Documento">
                        <div class="input-group-prepend">
                            <button @click.prevent="searchTeacher" type="button" class="btn btn-primary">
                                <i class="fa fa-search mr-1"></i> Buscar
                            </button>
                        </div>
                    </div>
            	</form>
			</div>
            <div class="col-12">
                <form class="row" @submit.prevent>
                    <!-- col-12 -->
                    <div class="col-3">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input disabled type="text" class="form-control" v-model="teacherData.person.firstname">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input disabled type="text" class="form-control" v-model="teacherData.person.lastname">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Categoria Actual</label>
                            <input disabled type="text" class="form-control" v-model="teacherData.category.name">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Modalidad de Acenso</label>
                            <v-select 
                            class="text-uppercase bg-white" 
                            :disabled="teacherData.id == 0" 
                            label="name" 
                            v-model="ascent.modality" 
                            @input="getCategories" 
                            :options="modalities"></v-select>
                        </div>
                    </div>
                    <div class="col-2">
                        <label>Categoria a Acender</label>
                        <v-select 
                        class="text-uppercase" 
                        :disabled="ascent.modality == null"
                        label="name"
                        @input="verifyRequeriments" 
                        v-model="ascent.category" 
                        :options="list_categories"><div slot="no-options">No hay coincidencias</div></v-select>
                    </div>
                    <!-- col-12 -->
                    <template v-if="ascent.modality!==null">
                        <div class="col-12 text-uppercase">
                            <h3 class="text-center" v-text="ascent.modality"></h3>
                        </div>

                    <!-- ACENSO POR ARTICULO 61 -->

                        <template v-if="ascent.modality == 'art. 61'">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Titulo de Trabajo</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Titulo de Postgrado</label>
                                    <input type="text" class="form-control">
                                    <!-- <v-select 
                                    class="text-uppercase bg-white"
                                    label="title" 
                                    :options="teacherData.postgraduates"><div slot="no-options">No hay coincidencias</div></v-select> -->
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Publicación</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </template>
                    
                    <!-- ACENSO POR ARTICULO 64 -->
                    
                        <template v-if="ascent.modality == 'art. 64'">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Titulo de Trabajo</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Naturaleza del Trabajo</label>
                                    <v-select class="text-uppercase bg-white" :disabled="dni == null" label="name" :options="list_works"></v-select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Titulo de Postgrado</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <!-- col-12 -->
                            <div class="col-12">
                                <h5 class="text-center">Jurado Evaluador</h5>
                            </div>
                            <!-- col-12 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Cordinador</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Principal</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Principal</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <!-- col-12 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Cordinador (Suplente)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Principal (Suplente)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Principal (Suplente)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <!-- col-12 -->
                            <div class="col-12">
                                <h5 class="text-center">Presentacion</h5>
                            </div>
                            <!-- col-12 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Lugar</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Hora</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <!-- col-12 -->
                        </template>
                    
                    <!-- ACENSO POR PUBLICACION -->

                        <template v-if="ascent.modality == 'publicación'">
                            <h4 class="text-center">data incompleta publicacion</h4>
                        </template>

                        <!-- col-12 -->
                        <div class="col-12">
                            <h5 class="text-center">Adscrito</h5>
                        </div>
                        <!-- col-12 -->
                        <div class="col-4">
                            <div class="form-group">
                                <label>Sede</label>
                                <v-select 
                                class="text-uppercase bg-white"
                                :disabled="teacherData.id == 0" 
                                @input="getAreas" 
                                label="name" 
                                v-model="teacherData.headquarter" 
                                :options="list_headquarters"><div slot="no-options">No hay coincidencias</div></v-select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Area</label>
                                <v-select 
                                class="text-uppercase bg-white"
                                :disabled="teacherData.headquarter.id == 0" 
                                @input="getPrograms" 
                                label="name" 
                                v-model="teacherData.area" 
                                :options="list_areas"><div slot="no-options">No hay coincidencias</div></v-select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Programa</label>
                                <v-select 
                                class="text-uppercase bg-white"
                                :disabled="teacherData.area.id == 0" 
                                @input="setExtras" 
                                label="name" 
                                v-model="teacherData.program" 
                                :options="list_programs"><div slot="no-options">No hay coincidencias</div></v-select>
                            </div>
                        </div>
                        <!-- col-12 -->
                        <template v-if="teacherData.headquarter.id > 0 && teacherData.area.id > 0 && teacherData.program.id > 0">
                            <div class="col-4" v-if="list_cores.length > 0">
                                <div class="form-group">
                                    <label>Nucleo</label>
                                    <v-select 
                                    class="text-uppercase bg-white"
                                    :disabled="teacherData.extension.id > 0 || teacherData.territorial_classroom.id > 0" 
                                    label="name" 
                                    v-model="teacherData.core" 
                                    :options="list_cores"><div slot="no-options">No hay coincidencias</div></v-select>
                                </div>
                            </div>
                            <div class="col-4" v-if="list_extensions.length > 0">
                                <div class="form-group">
                                    <label>Extension</label>
                                    <v-select 
                                    class="text-uppercase bg-white"
                                    :disabled="teacherData.core.id > 0 || teacherData.territorial_classroom.id > 0" 
                                    label="name" 
                                    v-model="teacherData.extension" 
                                    :options="list_extensions"><div slot="no-options">No hay coincidencias</div></v-select>
                                </div>
                            </div>
                            <div class="col-4" v-if="list_t_classrooms.length > 0">
                                <div class="form-group">
                                    <label>Aula Territorial</label>
                                    <v-select 
                                    class="text-uppercase bg-white"
                                    :disabled="teacherData.extension.id > 0 || teacherData.core.id > 0" 
                                    label="name" 
                                    v-model="teacherData.territorial_classroom" 
                                    :options="list_t_classrooms"><div slot="no-options">No hay coincidencias</div></v-select>
                                </div>
                            </div>
                        </template>
                        <!-- col-12 -->
                    </template>
                    <!-- col-12 -->
                </form>
            </div>
		</div>
	</div>
</template>
<script>
export default {
	mounted(){
		this.verifyDni();
	},
	data(){
		return {
			dni:null,
            modalities:['art. 61','art. 64','publicación'],
            list_works:['libro','trabajo de investigacion','publicacion'],
            list_headquarters:[],
            list_areas:[],
            list_programs:[],
            list_cores:[],
            list_t_classrooms:[],
            list_extensions:[],
            list_categories:[],
            ascent:{
                id:0,
                time:null,
                modality:null,
                teacher_id:0,
                next_category_id:0,
                current_category_id:0
            },
            publication:{
                title:null,
                ascent_id:0,
                teacher_id:0,
                postgraduate_id:0
            },
			teacherData:{
                id:0,
                category:{
                    id:0,
                    name:null
                },
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
                territorial_classroom:{
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
	        	},
	        	postgraduates:[],
                undergraduates:[]
            }
		}
	},
	methods:{
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
            let H = this.teacherData.headquarter
            if (H.id !== null) {
                this.list_areas = H.areas
            }
            if (this.list_areas.length == 0) {
                this.teacherData.area={
                    id:0,
                    name:null
                }
            }
        },
        getPrograms()
        {
            let A = this.teacherData.area
            if (A.id !== null) {
                this.list_programs = A.programs
            }
            if (this.list_programs.length == 0 || this.list_programs.length == undefined) {
                this.teacherData.program={
                    id:0,
                    name:null
                }
            }
            this.blankExtras();
        },
        setExtras()
        {
            this.blankExtras();
            this.getCores();
            this.getExtensions();
            this.getTClassrooms();
        },
        getCores()
        {
            let A = this.teacherData.area
            if (A.id !== null) {
                this.list_cores = A.cores
            }
            if (this.list_cores.length == 0 || this.list_cores.length == undefined) {
                this.teacherData.core={
                    id:0,
                    name:null
                }
            }
        },
        getExtensions()
        {
            let A = this.teacherData.area
            if (A.id !== null) {
                this.list_extensions = A.extensions
            }
            if (this.list_extensions.length == 0 || this.list_extensions.length == undefined) {
                this.teacherData.extension={
                    id:0,
                    name:null
                }
            }
        },
        getTClassrooms()
        {
            let A = this.teacherData.area
            if (A.id !== null) {
                this.list_t_classrooms = A.territorial_classrooms
            }
            if (this.list_t_classrooms.length == 0 || this.list_t_classrooms.length == undefined) {
                this.teacherData.territorial_classroom={
                    id:0,
                    name:null
                }
            }
        },
        blankExtras(){
            this.teacherData.territorial_classroom={
                id:0,
                name:null
            }
            this.teacherData.extension={
                id:0,
                name:null
            }
            this.teacherData.core={
                id:0,
                name:null
            }
        },
        getCategories(){
            let url = location.origin+"/get-categories"
            axios.get(url).then(response => {
                this.list_categories = response.data.filter((cat,ind,arr)=>{
                    return (cat.name.toLowerCase().indexOf('instructor') == -1)
                });
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
		formatDate(date){
			let moment = require('moment');
			moment.locale('es');
			return 'actualizado '+moment(date).startOf('hour').fromNow();
		},
		verifyDni()
        {
        	let dni = location.pathname.split('/')[3]
        	if (dni !== undefined && dni !== null) {
        		this.dni = dni
        		this.searchTeacher()
        	}
        },
        verifyRequeriments()
        {
            if (this.ascent.modality == 'art. 61') {
                if (this.teacherData.ascents.length == 0) {
                    this.$alertify.warning('No tienes acensos registrados!')
                }else{
                    console.log(this.teacherData.ascents)

                    // this.list_conditions = response.data.filter((cond,ind,arr)=>{
                    //     if (this.type_contract.type=='contratado') {
                    //         return (cond.name.toLowerCase().indexOf('fijo') == -1)
                    //     }else{
                    //         return (cond.name.toLowerCase().indexOf('fijo') !== -1)
                    //     }
                    // });

                    // this.$alertify.warning('Tienes !')
                }
            }

            if (this.ascent.modality == 'art. 64') {

            }
        },
		searchTeacher()
		{
		    let url = location.origin+"/get-teacher/"+this.dni
		    axios.get(url).then(response => {
		        if (response.data !== 0 && response.data !== null && response.data !== undefined && response.data !== '') {
		        	if (response.data.id > 0) {
                		this.$alertify.success('Busqueda exitosa')
		        		this.teacherData = response.data
                        this.getHeadquarters();
                        this.getAreas();
                        this.getPrograms();
                        this.setExtras();
		        	}
		        }else{
		        	this.teacherDataBlack()
                	this.$alertify.error('Busqueda sin resultado')
		        }
		    }).catch(errors =>{
		        console.log(errors.response)
		    })
		},
		teacherDataBlack(){
			this.teacherData={
                id:0,
                ascent:{
                    id:0,
                    time:null,
                    modality:null,
                    teacher_id:0,
                    next_category_id:0,
                    current_category_id:0
                },
                category:{
                    id:0,
                    name:null
                },
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
                territorial_classroom:{
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
	        	},
	        	postgraduates:[],
                undergraduates:[],
            }
            this.ascent={
                id:0,
                time:null,
                modality:null,
                teacher_id:0,
                next_category_id:0,
                current_category_id:0
            }
            this.publication={
                title:null,
                ascent_id:0,
                teacher_id:0,
                postgraduate_id:0
            }
		}
	}
}
</script>