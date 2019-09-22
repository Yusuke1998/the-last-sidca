<template>
<div class="container">
    <div class="row mt-4 mb-4">
        <div class="col-lg-3">
            <span>Pagina {{table_pagination.current_page}} De {{table_pagination.last_page}}.</span>
        </div>
        <div class="col-lg-6 text-center">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button  
                    type="button" 
                    class="btn btn-outline-primary"
                    v-if="table_pagination.current_page > 1"
                    @click.prevent="$emit('changePage',table_pagination.current_page - 1)">
                    Anterior   
                </button>
                <button 
                    v-else
                    type="button" 
                    class="btn btn-outline-primary disabled">
                    Anterior   
                </button>
                <button 
                    type="button" 
                    class="btn btn-outline-primary"
                    v-for="page in pagesNumber" v-bind:class="[ page == isActived ? 'active' : '']"
                    @click.prevent="$emit('changePage',page)">
                    {{ page }}
                </button>

                <button 
                    type="button" 
                    class="btn btn-outline-primary"
                    v-if="table_pagination.current_page < table_pagination.last_page"
                    @click.prevent="$emit('changePage',table_pagination.current_page + 1)">
                    Siguiente
                </button>
                <button 
                    v-else
                    type="button" 
                    class="btn btn-outline-primary disabled">
                    Siguiente
                </button>
            </div>
        </div>
        <div class="col-lg-3 text-right">
            {{table_pagination.total}} Registros Encontrados.
        </div>

    </div>
</div>        
</template>

<script>
export default {
    props:['table_pagination'],
    data() {
		return {
            offset: 1,
        }
	},
    computed: {
        isActived: function () {
            return this.table_pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.table_pagination.to) {
                return [];
            }

            var from = this.table_pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }

            var to = from + (this.offset * 2);
            if (to >= this.table_pagination.last_page) {
                to = this.table_pagination.last_page;
            }

            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
    },
}
</script>

<style>
    .actived {
        background: pink !important;
    }
</style>
