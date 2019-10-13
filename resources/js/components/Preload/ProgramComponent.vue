<template>
    <div class="container">
        <div class="block">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title text-white text-center">PROGRAMAS</h3>
                <button data-toggle="tooltip" title="Crear" type="button" @click="showModal('ProgramModal',null,'Nuevo Programa','store')" class="btn btn-success">
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
                                <th>Area</th>
                                <th class="text-center" style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="!table_data.length > 0">
                                <td colspan="5" class="bg-secondary text-center text-light">No se encontraron datos.</td>
                            </tr>
                            <tr v-else v-for="(item_table,index_for_table) in table_data" :key="index_for_table">
                                <td v-text="index_for_table + 1"></td>
                                <td class="font-w600 font-size-sm" v-text="item_table.name"></td>
                                <td class="font-w600 font-size-sm" v-text="item_table.area.name"></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" @click="showModal('ProgramModal',item_table,'Editar Carrera','edit')" class="btn btn-sm btn-light" data-toggle="tooltip" title="Edit Client">
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

        <div class="modal fade" id="ProgramModal" tabindex="-1" role="dialog" aria-labelledby="ProgramModal" aria-hidden="true">
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
                            <form class="row" @keydown.enter.prevent="storeData()">
                                <!-- col-12 -->
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Nombre</label>
                                        <input type="text" class="form-control" v-model="ProgramData.name">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Sedes</label>
                                        <v-select label="name" v-model="ProgramData.headquarter" :options="list_headquarters" @input="getAreas"></v-select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Areas</label>
                                        <v-select label="name" :disabled="ProgramData.headquarter.id == 0 || list_areas.length == 0" v-model="ProgramData.area" :options="list_areas"></v-select>
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
        this.getHeadquarters();
    },
    data() {
        return {
            // AUXILIARES
            list_headquarters:[],
            list_areas:[],
            ProgramData:{
                id: 0,
                name: null,
                headquarter:{
                    id:0,
                    name:null
                },
                area:{
                    id:0,
                    name:null
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
            let url = '/get-areas/'+this.ProgramData.headquarter.id
            axios.get(url).then(response => {
                this.list_areas = response.data
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        ProgramDataBlank(){
            this.ProgramData={
                id: 0,
                name: null,
                headquarter:{
                    id:0,
                    name:null
                },
                area:{
                    id:0,
                    name:null
                }
            }
        },
        getData(page)
        {
            let url =  "/precarga/get-programs" 
            axios.post(url,{
                page   : page, 
                sort   : this.sort_selected, 
                search : this.search_table,
            }).then(response =>{
                this.table_pagination   = response.data.pagination
                this.table_data         = response.data.table.data
                this.search_table       = ''
                this.$alertify.success('Programas Cargadas')
            }).catch(errors =>{
                console.log(errors)
            })
        },
        storeData()
        {
            this.$root.loading('Verificando y guardando','Espere mientras se verifican los datos para registrar El programa')
            let url = '/precarga/store-program'
            axios.post(url,
                this.ProgramData
            ).then(response => {
                swal.close()
                $("#ProgramModal").modal('hide')
                this.$alertify.success('El programa se registro con exito')
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
            this.$root.loading('Verificando y actualizando','Espere mientras se verifican los datos para actualizar el programa')
            let url = '/precarga/update-program'
            axios.post(url,
                this.ProgramData
            ).then(response => {
                swal.close()
                $("#ProgramModal").modal('hide')
                this.$alertify.success('El programa fue actualizado con exito')
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
        deleteData(idCore)
        {
            swal({
                text: "Esta seguro que quiere eliminar este programa?",
                icon: "warning",
                buttons: ['Cancelar','Eliminar'],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    this.$root.loading('Evaluando','Espere mientras se verifican los datos para eliminar este programa')
                    let url = '/precarga/delete-program'
                    axios.post(url,{
                        id:idCore
                    }).then(response => {
                        swal.close()
                        this.getData()
                        this.$alertify.success('El programa fue eliminado con exito')
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
            console.log(model)
            this.modal_option   = option
            this.modal_type     = type
            if (type == 'edit' && model !== null) {
                this.ProgramData = {
                    id:model.id,
                    name:model.name,
                    headquarter:{
                        id:model.headquarter.id,
                        name:model.headquarter.name
                    },
                    area:{
                        id:model.area.id,
                        name:model.area.name
                    }
                }
            }else{
                this.ProgramDataBlank()
            }
            $("#"+modal_id).modal('show')
        }
    }
}
</script>