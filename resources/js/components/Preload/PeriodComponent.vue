<template>
	<div class="container">
		<div class="block">
			<div class="block-header bg-primary-dark">
				<h3 class="block-title text-white text-center">PERIODOS</h3>
    			<button data-toggle="tooltip" title="Nuevo" type="button" @click="showModal('PeriodModal',null,'Nuevo Periodo','store')" class="btn btn-success">
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
			                    <th>Periodo</th>
			                    <th class="text-center" style="width: 100px;">Acciones</th>
			                </tr>
			            </thead>
			            <tbody>
			            	<tr v-if="!table_data.length > 0">
			                    <td colspan="3" class="bg-secondary text-center text-light">No se encontraron datos.</td>
			                </tr>
			                <tr v-else v-for="(item_table,index_for_table) in table_data" :key="index_for_table">
			                    <td v-text="index_for_table + 1"></td>
			                    <td class="font-w600 font-size-sm" v-text="item_table.period"></td>
			                    <td class="text-center">
			                        <div class="btn-group">
			                            <button type="button" @click="deleteData(item_table.id,item_table.period)" class="btn btn-sm btn-light" data-toggle="tooltip" title="Eliminar">
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

        <div class="modal fade" id="PeriodModal" tabindex="-1" role="dialog" aria-labelledby="PeriodModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popout modal-md" role="document">
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
                            <form class="row" @keydown.enter.prevent="storeData">
                                <div class="col-12">
                                	<div class="form-group">
                                        <label>Periodo(s)</label>
                                        <v-select label="name" v-model="PeriodData.period" :options="list_periods.sort()"></v-select>
                                    </div>
                                </div>
                                <!-- col-12 -->
                            </form>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Cerrar</button>
                            <button v-if="modal_type=='store'" @click="storeData()" type="button" class="btn btn-sm btn-success" data-dismiss="modal"><i class="fa fa-check mr-1"></i>Guardar</button>
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
    	this.getListPeriods();
    },
    data() {
		return {
            list_periods:[],
            year_now:new Date().getFullYear(),
            // AUXILIARES
            PeriodData:{
            	id: 0,
                period: null
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
		PeriodDataBlank(){
			this.PeriodData={
            	id: 0,
                period: null
            }
		},
        changePage: function (page) 
        {
            this.table_pagination.current_page = page;
            this.getData(page);
        },
        showModal(modal_id, model,option, type){
        	this.modal_option	= option
        	this.modal_type		= type
        	this.PeriodDataBlank()
            $("#"+modal_id).modal('show')
        },
		getData(page)
        {
            let url =  "/precarga/get-periods" 
            axios.post(url,{
                page   : page, 
                sort   : this.sort_selected, 
                search : this.search_table,
            }).then(response =>{
                this.table_pagination	= response.data.pagination
                this.table_data			= response.data.table.data
            	this.search_table		= ''
                this.setListPeriods()
                this.$alertify.success('Periodos Cargados')
            }).catch(errors =>{
                console.log(errors)
            })
        },
        storeData()
        {
            this.$root.loading('Verificando y guardando','Espere mientras se verifican los datos para registrar el periodo')
            let url = '/precarga/store-period'
            axios.post(url,
                this.PeriodData
            ).then(response => {
                swal.close()
                $("#PeriodModal").modal('hide')
        		this.$alertify.success('El periodo se registro con exito')
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
        deleteData(idSede,period)
        {
        	swal({
                text: "Esta seguro que quiere eliminar esta sede?",
                icon: "warning",
                buttons: ['Cancelar','Eliminar'],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
        			this.$root.loading('Evaluando','Espere mientras se verifican los datos para eliminar este periodo')
		            let url = '/precarga/delete-period'
		            axios.post(url,{
		                id:idSede
		            }).then(response => {
                        this.list_periods.push(period)
		                swal.close()
		                this.getData()
		        		this.$alertify.success('El periodo fue eliminado con exito')
		            }).catch(errors => {
		                swal.close()
		            })
                }
            })
        },
        getListPeriods(){
            for (var i = 1; i <= 5; i++) {
                this.list_periods.push(this.year_now+'-'+i)
            }
        },
        setListPeriods(){
            axios.get('/get-periods').then(response =>{
                response.data.forEach(p=>{
                    this.deletePeriod(this.list_periods,p.period)
                });
            }).catch(errors =>{
                console.log(errors)
            })
        },
        deletePeriod(array,item){
            let i = array.indexOf(item);
            if (i !== -1) {
                array.splice(i,1);
            }
        }
	}
}
</script>