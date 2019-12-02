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
                    <div class="col-6">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input disabled type="text" class="form-control" v-model="teacherData.person.firstname">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input disabled type="text" class="form-control" v-model="teacherData.person.lastname">
                        </div>
                    </div>
                    <!-- col-12 -->
                </form>
            </div>      
        </div>
	</div>
</template>
<script>
import {en, es} from 'vuejs-datepicker/dist/locale'
export default {
	mounted()
    {
        this.verifyDni();
	},
	data()
    {
		return {
            // data required
            dni:null,
            teacherData:{
                id:0,
                postgraduate:null,
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
                ascents:[]
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
        blankExtras()
        {
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
        teacherDataBlack()
        {
            this.teacherData={
                id:0,
                postgraduate:null,
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
                ascents:[]
            }
        },
        reduceData()
        {
            this.teacherData.headquarter.areas = []
            this.teacherData.area.programs = []
            this.teacherData.area.cores = []
            this.teacherData.area.extensions = []
            this.teacherData.area.territorial_classrooms = []
        },
    }
}
</script>