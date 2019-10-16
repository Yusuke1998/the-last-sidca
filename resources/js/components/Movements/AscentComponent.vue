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
                    <div class="col-3">
                        <div class="form-group">
                            <label>Categoria</label>
                            <input disabled type="text" class="form-control" v-model="teacherData.category.name">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Modalidad de Acenso</label>
                            <v-select class="text-uppercase" :disabled="dni == null" label="name" v-model="ascent.modality" @input="getCategories" :options="modalities"></v-select>
                        </div>
                    </div>
                    <!-- col-12 -->

                    <!-- col-12 -->
                    <template v-if="ascent.modality!==null">
                        <div class="col-12 text-uppercase">
                            <h3 class="text-center" v-text="ascent.modality"></h3>
                        </div>
                        <div class="col-3">
                            <label>Categoria a Acender</label>
                            <v-select 
                            class="text-uppercase" 
                            :disabled="dni == null" 
                            label="name" 
                            v-model="ascent.category" 
                            :options="list_categories"><div slot="no-options">No hay coincidencias</div></v-select>
                        </div>
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
            modalities:['art.61','art.64','publicacion'],
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
                undergraduates:[]
            }
		}
	},
	methods:{
        getCategories(){
            let url = location.origin+"/get-categories"
            axios.get(url).then(response => {
                // this.list_categories = response.data.filter((cate,ind,arr)=>{
                //     if (this.type_contract.type=='ordinario') {
                //         return (cate.name.toLowerCase().indexOf('todos') == -1)
                //     }else{
                //         return (cate.name.toLowerCase().indexOf('instructor') !== -1)
                //     }
                // });
                this.list_categories = response.data
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
		searchTeacher()
		{
		    let url = location.origin+"/get-teacher/"+this.dni
		    axios.get(url).then(response => {
		        if (response.data !== 0 && response.data !== null && response.data !== undefined && response.data !== '') {
		        	if (response.data.id > 0) {
                		this.$alertify.success('Busqueda exitosa')
		        		this.teacherData = response.data
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