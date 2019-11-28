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
		</div>
		<ul class="timeline timeline-alt">

            <li class="timeline-event">
                <div class="timeline-event-icon bg-success">
                    <i class="fa fa-address-card"></i>
                </div>
                <div class="timeline-event-block block invisible" data-toggle="appear">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Datos Personales</h3>
                        <div class="block-options">
                            <div class="timeline-event-time block-options-item font-size-sm font-w600">
                                <span v-if="teacherData.person.id !== 0" v-text="momentDate(teacherData.person.updated_at)"></span>
                            </div>
                        </div>
                    </div>
                    <div v-if="teacherData.person.id !== 0" class="block-content">
						<div class="row">
                            <!-- col-12 -->
                            <div class="col-3">
                            	<div class="form-group">
                            		<label>Nro de Documento</label>
                                    <input disabled type="number" v-model="teacherData.person.nro_document" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                            	<div class="form-group">
                            		<label>Tipo de Documento</label>
                                	<input disabled tipe="text" v-model="teacherData.person.document.name" class="form-control">
                            	</div>
                            </div>
                            <div class="col-6 mb-2">
                                <center>
                                    <img width="350" height="200" :src="img_url">
                                </center>
                            </div>
                            <!-- col-12 -->
                            <div class="col-6">
                            	<div class="form-group">
                            		<label for="">Nombres</label>
                            		<input disabled type="text" class="form-control" v-model="teacherData.person.firstname">
                            	</div>
                            </div>
                            <div class="col-6">
                            	<div class="form-group">
                            		<label for="">Apellidos</label>
                            		<input disabled type="text" class="form-control" v-model="teacherData.person.lastname">
                            	</div>
                            </div>
                            <!-- col-12 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Fecha de Nacimiento</label>
                                    <datepicker
                                    disabled
                                    v-model="teacherData.person.birthday"
                                    input-class="form-control"></datepicker>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Direccion</label>
                                    <textarea disabled v-model="teacherData.person.direction" class="form-control"></textarea>
                                </div>
                            </div>
                            <!-- col-12 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Telefono Local</label>
                                    <input disabled v-model="teacherData.person.local_phone" class="form-control"></input>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Telefono Movil</label>
                                    <input disabled v-model="teacherData.person.movil_phone" class="form-control"></input>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Correo Electronico</label>
                                    <input disabled v-model="teacherData.person.mail_contact" class="form-control"></input>
                                </div>
                            </div>
                            <!-- col-12 -->
                        </div>
                    </div>
                    <div v-else class="block-content">
						<h4 class="text-center">Sin Resultados!</h4>
                    </div>
                </div>
            </li>

            <li class="timeline-event">
                <div class="timeline-event-icon bg-info">
                    <i class="far fa-flag"></i>
                </div>
                <div class="timeline-event-block block invisible" data-toggle="appear">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Estudios</h3>
                        <div class="block-options">
                            <div class="timeline-event-time block-options-item font-size-sm font-w600">
                                actualizado hace 10 min
                            </div>
                        </div>
                    </div>
                    <div v-if="teacherData.postgraduates.length > 0 || teacherData.undergraduates.length > 0" class="block-content">
						<div class="row">
                            <div class="block col-12">
                                <div class="block-title">
                                    Pregrado
                                </div>
                                <div class="block-content">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Universidad</th>
                                                <th>Titulo</th>
                                                <th>Año</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="teacherData.undergraduates.length == 0">
                                                <td class="text-center text-white bg-primary-dark" colspan="3">No hay registros...</td>
                                            </tr>
                                            <tr class="text-center" v-else v-for="pregrado in teacherData.undergraduates">
                                                <td v-text="pregrado.university.name"></td>
                                                <td v-text="pregrado.title.title"></td>
                                                <td v-text="pregrado.date"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="block col-12">
                                <div class="block-title">
                                    Posgrado
                                </div>
                                <div class="block-content">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Universidad</th>
                                                <th>Titulo</th>
                                                <th>Nivel</th>
                                                <th>Año</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="teacherData.postgraduates.length == 0">
                                                <td class="text-center text-white bg-primary-dark" colspan="3">No hay registros...</td>
                                            </tr>
                                            <tr class="text-center" v-else v-for="posgrado in teacherData.postgraduates">
                                                <td v-text="posgrado.university.name"></td>
                                                <td v-text="posgrado.title.title"></td>
                                                <td v-text="posgrado.title.level"></td>
                                                <td v-text="posgrado.date"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="block-content">
						<h4 class="text-center">Sin Resultados!</h4>
                    </div>
                </div>
            </li>

			<li class="timeline-event">
                <div class="timeline-event-icon bg-warning">
                    <i class="far fa-thumbs-up"></i>
                </div>
                <div class="timeline-event-block block invisible" data-toggle="appear">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Convalidacion de Ascensos</h3>
                        <div class="block-options">
                            <div class="timeline-event-time block-options-item font-size-sm font-w600">
                                actualizado hace 10 min
                            </div>
                        </div>
                    </div>
                    <div v-if="teacherData.ascents.length > 0" class="block-content">
                        <div class="row">
                            <div class="block col-12">
                                <div class="block-content">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Categoria Actual</th>
                                                <th>Modalidad de Ascenso</th>
                                                <th>Fecha de Ascenso</th>
                                                <th>Categoria proxima a Ascender</th>
                                                <th>Fecha de proximo Ascenso</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="teacherData.ascents.length == 0">
                                                <td class="text-center text-white bg-primary-dark" colspan="5">No hay registros...</td>
                                            </tr>
                                            <tr class="text-center" v-else v-for="ascent in teacherData.ascents">
                                                <td v-text="ascent.current_category.name"></td>
                                                <td v-text="ascent.modality"></td>
                                                <td v-text="formD(ascent.date)"></td>
                                                <td v-text="(ascent.next_category===null)?'No Aplica':ascent.next_category.name"></td>
                                                <td v-text="(ascent.date_next===null)?'No Aplica':formD(ascent.date_next)"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="block-content">
                        <h4 class="text-center">Sin Resultados!</h4>
                    </div>
                </div>
            </li>

            <li class="timeline-event">
                <div class="timeline-event-icon bg-modern-lighter">
                    <i class="far fa-handshake"></i>
                </div>
                <div class="timeline-event-block block invisible" data-toggle="appear">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Consursos de Oposicion</h3>
                        <div class="block-options">
                            <div class="timeline-event-time block-options-item font-size-sm font-w600">
                                actualizado hace 10 min
                            </div>
                        </div>
                    </div>
                    <div class="block-content">

                    </div>
                </div>
            </li>

            <li class="timeline-event">
                <div class="timeline-event-icon bg-amethyst-op">
                    <i class="far fa-paper-plane"></i>
                </div>
                <div class="timeline-event-block block invisible" data-toggle="appear">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Comision de Servicios</h3>
                        <div class="block-options">
                            <div class="timeline-event-time block-options-item font-size-sm font-w600">
                                actualizado hace 10 min
                            </div>
                        </div>
                    </div>
                    <div class="block-content">

                    </div>
                </div>
            </li>

            <li class="timeline-event">
                <div class="timeline-event-icon bg-city">
                    <i class="fa fa-diagnoses"></i>
                </div>
                <div class="timeline-event-block block invisible" data-toggle="appear">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Permisos (Remunerados y/o No Remunerados)</h3>
                        <div class="block-options">
                            <div class="timeline-event-time block-options-item font-size-sm font-w600">
                                actualizado hace 10 min
                            </div>
                        </div>
                    </div>
                    <div class="block-content">

                    </div>
                </div>
            </li>

            <li class="timeline-event">
                <div class="timeline-event-icon bg-flat">
                    <i class="far fa-calendar-alt"></i>
                </div>
                <div class="timeline-event-block block invisible" data-toggle="appear">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Traslados</h3>
                        <div class="block-options">
                            <div class="timeline-event-time block-options-item font-size-sm font-w600">
                                actualizado hace 10 min
                            </div>
                        </div>
                    </div>
                    <div class="block-content">

                    </div>
                </div>
            </li>

            <li class="timeline-event">
                <div class="timeline-event-icon bg-modern-lighter">
                    <i class="far fa-id-badge"></i>
                </div>
                <div class="timeline-event-block block invisible" data-toggle="appear">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Disfrute de Año Sabatico</h3>
                        <div class="block-options">
                            <div class="timeline-event-time block-options-item font-size-sm font-w600">
                                actualizado hace 10 min
                            </div>
                        </div>
                    </div>
                    <div class="block-content">

                    </div>
                </div>
            </li>

            <li class="timeline-event">
                <div class="timeline-event-icon bg-gray-light">
                    <i class="far fa-check-circle"></i>
                </div>
                <div class="timeline-event-block block invisible" data-toggle="appear">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Reincorporaciones</h3>
                        <div class="block-options">
                            <div class="timeline-event-time block-options-item font-size-sm font-w600">
                                actualizado hace 10 min
                            </div>
                        </div>
                    </div>
                    <div class="block-content">

                    </div>
                </div>
            </li>

            <li class="timeline-event">
                <div class="timeline-event-icon bg-city-lighter">
                    <i class="far fa-user-circle"></i>
                </div>
                <div class="timeline-event-block block invisible" data-toggle="appear">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Jubilaciones</h3>
                        <div class="block-options">
                            <div class="timeline-event-time block-options-item font-size-sm font-w600">
                                actualizado hace 10 min
                            </div>
                        </div>
                    </div>
                    <div class="block-content">

                    </div>
                </div>
            </li>

        </ul>
	</div>
</template>
<script>
export default {
	mounted(){
		this.verifyDni();
	},
	data(){
		return {
            img_url:null,
			dni:null,
			teacherData:{
                id:0,
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
	        	},
	        	postgraduates:[],
                undergraduates:[],
                ascents:[],
            }
		}
	},
	methods:{
        baseUrl(){
            this.img_url = location.origin+'/storage/'+this.teacherData.person.img_document
        },
		momentDate(date){
			let moment = require('moment');
			moment.locale('es');
			return 'actualizado '+moment(date).toNow();
		},
        formD(date)
        {
            let d = date.split(' ')[0].split('-')
            return d[2]+'/'+d[1]+'/'+d[0]
        },
		verifyDni()
        {
        	let dni = location.pathname.split('/')[3]
        	if (dni !== undefined && dni !== null) {
        		this.dni = dni
        		this.searchTeacher()
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
                        this.baseUrl()
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
	        	},
	        	postgraduates:[],
                undergraduates:[],
                ascents:[],
            }
		}
	}
}
</script>