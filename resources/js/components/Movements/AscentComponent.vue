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
                    <div class="col-4">
                        <div class="form-group">
                            <label title="Categoria que desempeña actualmente">Categoria Actual</label>
                            <input disabled type="text" class="form-control" v-model="teacherData.category.name">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label title="Fecha de Obtencion de la categoria actual">Fecha de Obtencion</label>
                            <datepicker
                            :language="es"
                            disabled
                            :value="formDate(current_category.date)"
                            :full-month-name="true"
                            :disabled-dates="no_dates" 
                            :input-class="'form-control'"></datepicker>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label title="Tiempo en la Categoria Actual">Tiempo</label>
                            <input disabled type="text" class="form-control" v-model="current_category.time">
                        </div>
                    </div>
                    <!-- col 12 -->
                    <div class="col-4">
                        <div class="form-group">
                            <label>Categoria a Acender</label>
                            <v-select 
                            class="text-uppercase bg-white" 
                            :disabled="teacherData.id == 0" 
                            label="name"
                            @input="validationAsc" 
                            v-model="ascent.category" 
                            :options="list_categories_b"><div slot="no-options">No hay coincidencias</div></v-select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Modalidad de Ascenso</label>
                            <v-select 
                            class="text-uppercase"
                            :class="ascent.category!==null?'bg-white':''" 
                            :disabled="ascent.category == null"
                            @input="showPublications"
                            label="name" 
                            v-model="ascent.modality"
                            :options="modalities"></v-select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Fecha de Ascenso</label>
                            <datepicker
                            :language="es"
                            v-model="ascent.date"
                            :disabled="ascent.modality==null"
                            :full-month-name="true"
                            :disabled-dates="no_dates" 
                            :input-class="ascent.modality!==null?'bg-white form-control':'form-control'"></datepicker>
                        </div>
                    </div>
                    <!-- col-12 -->
                    <div class="col-12 bg-white py-3 mb-2">
                        <h3 class="text-center">Requisitos Consignados para Ascenso</h3>
                        <ul>
                            <li>algo1</li>
                            <li>algo2</li>
                            <li>algo3</li>
                            <li>algo4</li>
                            <li>algo5</li>
                            <li>algo6</li>
                            <li>algo7</li>
                        </ul>
                    </div>
                    <!-- col-12 -->
                    
                    <template v-if="ascent.modality!==null">
                    <!-- ASCENSO POR ARTICULO 61 O 62 -->

                        <template v-if="ascent.modality == 'art. 61' || ascent.modality == 'art. 62'">
                            <!-- col-12 -->
                            <div class="col-12">
                                <h4 class="text-center">Publicación</h4>
                            </div>
                            <!-- col-12 -->
                            <div class="col-12 card mb-3" v-for="(publication, index_publication) in publications" :key="index_publication">
                                <div class="row card-body">
                                    <div v-if="ascent.modality == 'art. 62'" class="col-1">
                                        <div class="form-group">
                                            <h3>#{{index_publication+1}}</h3>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label :for="'title'+index_publication">Titulo</label>
                                            <input :id="'title'+index_publication" v-model="publication.title" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label :for="'rev'+index_publication">Revista</label>
                                            <input :id="'rev'+index_publication" v-model="publication.rev" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div :class="ascent.modality == 'art. 62'?'col-5':'col-6'">
                                        <div class="form-group">
                                            <label :for="'post'+index_publication">Postgrado</label>
                                            <v-select
                                            :id="'post'+index_publication" 
                                            class="bg-white text-uppercase"
                                            label="title"
                                            v-model="publication.postgraduate"
                                            :options="teacherData.postgraduates"
                                            :getOptionLabel="obj=>obj.title.level+' / '+obj.title.title"
                                            :reduce="title=>title.title"><div slot="no-options">No hay coincidencias</div></v-select>
                                        </div>
                                    </div>
                                    <!-- col 12 -->
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label :for="'issn'+index_publication">Código ISSN</label>
                                            <input :id="'issn'+index_publication" v-model="publication.code_issn" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label :for="'isbn'+index_publication">Número ISBN</label>
                                            <input :id="'isbn'+index_publication" v-model="publication.nro_isbn" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label :for="'edit'+index_publication">Número de Edición</label>
                                            <input :id="'edit'+index_publication" v-model="publication.nro_edit" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label :for="'vol'+index_publication">Vólumen</label>
                                            <input :id="'vol'+index_publication" v-model="publication.vol" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label :for="'url'+index_publication">URL</label>
                                            <input :id="'url'+index_publication" v-model="publication.url" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label :for="'date'+index_publication">Fecha</label>
                                            <datepicker
                                            :language="es"
                                            :id="'date'+index_publication" 
                                            v-model="publication.date"
                                            :full-month-name="true"
                                            :disabled-dates="no_dates" 
                                            :input-class="'bg-white form-control'"></datepicker>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    
                    <!-- ASCENSO POR ARTICULO 64 -->
                    
                        <template v-if="ascent.modality == 'art. 64'">
                            <div class="col-12">
                                <h4 class="text-center">Trabajo de Investigación</h4>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Titulo</label>
                                    <input v-model="job.title" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Postgrado</label>
                                    <v-select
                                    :disabled="job.title == ''" 
                                    class="bg-white text-uppercase"
                                    label="title"
                                    v-model="teacherData.postgraduate"
                                    :options="teacherData.postgraduates"
                                    :getOptionLabel="obj=>obj.title.level+' / '+obj.title.title"><div slot="no-options">No hay coincidencias</div></v-select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <datepicker
                                    :language="es"
                                        :disabled="teacherData.postgraduate == null"
                                        placeholder="Fecha" 
                                        v-model="job.date"
                                        :full-month-name="true"
                                        :disabled-dates="no_dates" 
                                        :input-class="job.title !== ''?'bg-white form-control':'form-control'"></datepicker>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Trabajo (URL)</label>
                                    <input :disabled="job.date == ''" v-model="job.url" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <form enctype="multipart/form-data">
                                    <label title="Solo archivos '.pdf'">Trabajo (PDF)</label>
                                    <input :disabled="job.date == ''" type="file" v-on:change="onFileChange" class="form-control">
                                </form>
                            </div>
                            <!-- col-12 -->
                            <div class="col-12">
                                <h4 class="text-center">Jurado Evaluador</h4>
                            </div>
                            <!-- col-12 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Coordinador</label>
                                    <input placeholder="Nombres y Apellidos" v-model="job.jury.coordinator" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Principal</label>
                                    <input placeholder="Nombres y Apellidos" v-model="job.jury.principal1" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Principal</label>
                                    <input placeholder="Nombres y Apellidos" v-model="job.jury.principal2" type="text" class="form-control">
                                </div>
                            </div>
                            <!-- col-12 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Suplente</label>
                                    <input placeholder="Nombres y Apellidos" v-model="job.jury.alternate1" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Suplente</label>
                                    <input placeholder="Nombres y Apellidos" v-model="job.jury.alternate2" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Suplente</label>
                                    <input placeholder="Nombres y Apellidos" v-model="job.jury.alternate3" type="text" class="form-control">
                                </div>
                            </div>
                            <!-- col-12 -->
                            <div class="col-12">
                                <h4 class="text-center">Presentacion</h4>
                            </div>
                            <!-- col-12 -->
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <datepicker
                                    :language="es"
                                        :disabled="job.title == ''"
                                        placeholder="Fecha" 
                                        v-model="job.presentation.date"
                                        :input-class="'form-control'"
                                        :full-month-name="true"
                                        :disabled-dates="no_dates"></datepicker>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Hora</label>
                                    <v-datetime 
                                        :input-class="'form-control'"
                                        format="h:i:s"
                                        v-model="job.presentation.hour"
                                        placeholder="Hora"></v-datetime>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Lugar</label>
                                    <textarea 
                                        :input-class="'form-control'"
                                        v-model="job.presentation.location"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                            <!-- col-12 -->
                        </template>

                    <!-- ASCENSO POR UBICACION -->

                        <template v-if="ascent.modality == 'ubicacion'">
                            <!-- col-12 -->
                            <div class="col-12">
                                <h4 class="text-center">Baremo</h4>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Postgrado</label>
                                    <v-select
                                    :disabled="ascent.modality !== 'ubicacion'" 
                                    class="bg-white text-uppercase"
                                    label="title"
                                    v-model="teacherData.postgraduate"
                                    :options="teacherData.postgraduates"
                                    :getOptionLabel="obj=>obj.title.level+' / '+obj.title.title"><div slot="no-options">No hay coincidencias</div></v-select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <datepicker
                                    :language="es"
                                        :disabled="teacherData.postgraduate == null"
                                        placeholder="Fecha" 
                                        v-model="scale.date"
                                        :full-month-name="true"
                                        :disabled-dates="no_dates" 
                                        :input-class="teacherData.postgraduate !== null?'bg-white form-control':'form-control'"></datepicker>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <form enctype="multipart/form-data">
                                        <label title="Solo archivos '.pdf'">Baremo (PDF)</label>
                                        <input :disabled="scale.date == ''" type="file" v-on:change="onFileChange" class="form-control">
                                    </form>
                                </div>
                            </div>
                            <!-- col-12 -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <textarea :disabled="scale.file == null" class="form-control" v-model="scale.description"></textarea>
                                </div>
                            </div>
                            <!-- col-12 -->
                        </template>

                    <!-- INFORMACION GENERAL Y REQUERIDA -->

                        <!-- col-12 -->
                        <div class="col-12">
                            <h4 class="text-center">Adscrito</h4>
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
                        <div class="col-12">
                            <h4 class="text-center">Memorandos</h4>
                        </div>
                         <!-- col-12 -->
                        <div class="col-12 card mb-3">
                            <div class="card-body row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label title="Memorando del Consejo Universitario">Comunicacion del Docente</label>
                                        <input placeholder="Código" type="text" class="form-control" v-model="memo.cd.code">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label title="Fecha de Entrega al Area">Fecha</label>
                                        <datepicker
                                        :language="es"
                                        :disabled="memo.cd.code == ''"
                                        placeholder="Fecha de Entrega al Area" 
                                        v-model="memo.cd.date"
                                        :full-month-name="true"
                                        :disabled-dates="no_dates" 
                                        :input-class="memo.cd.code !== ''?'bg-white form-control':'form-control'"></datepicker>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label title="Fecha de Recepción al Area">Fecha</label>
                                        <datepicker
                                        :language="es"
                                        :disabled="memo.cd.code == ''"
                                        placeholder="Fecha de Recepción al Area" 
                                        v-model="memo.cd.date_r"
                                        :full-month-name="true"
                                        :disabled-dates="no_dates" 
                                        :input-class="memo.cd.code !== ''?'bg-white form-control':'form-control'"></datepicker>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- col-12 -->
                        <div class="col-12 card mb-3">
                            <div class="card-body row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label title="Memorando del Area">Area</label>
                                        <input placeholder="Código" type="text" class="form-control" v-model="memo.area.code">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label title="Fecha de Emisión">Fecha</label>
                                        <datepicker
                                        :language="es"
                                        :disabled="memo.area.code == ''"
                                        placeholder="Emisión" 
                                        v-model="memo.area.date"
                                        :full-month-name="true"
                                        :disabled-dates="no_dates" 
                                        :input-class="memo.area.code !== ''?'bg-white form-control':'form-control'"></datepicker>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label title="Fecha de Recepcion">Fecha</label>
                                        <datepicker
                                        :language="es"
                                        :disabled="memo.area.code == ''"
                                        placeholder="Recepcion" 
                                        v-model="memo.area.date_r"
                                        :full-month-name="true"
                                        :disabled-dates="no_dates" 
                                        :input-class="memo.area.code !== ''?'bg-white form-control':'form-control'"></datepicker>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- col-12 -->
                        <div class="col-12 card mb-3">
                            <div class="card-body row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label title="Memorando de Vicerectorado Academico">Vrac</label>
                                        <input placeholder="Código" type="text" class="form-control" v-model="memo.vrac.code">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label title="Fecha de Emisión">Fecha</label>
                                        <datepicker
                                        :language="es"
                                        :disabled="memo.vrac.code == ''"
                                        placeholder="Emisión" 
                                        v-model="memo.vrac.date"
                                        :full-month-name="true"
                                        :disabled-dates="no_dates" 
                                        :input-class="memo.vrac.code !== ''?'bg-white form-control':'form-control'"></datepicker>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label title="Fecha de Recepcion">Fecha</label>
                                        <datepicker
                                        :language="es"
                                        :disabled="memo.vrac.code == ''"
                                        placeholder="Recepcion" 
                                        v-model="memo.vrac.date_r"
                                        :full-month-name="true"
                                        :disabled-dates="no_dates" 
                                        :input-class="memo.vrac.code !== ''?'bg-white form-control':'form-control'"></datepicker>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- col-12 -->
                        <div class="col-12 card mb-3">
                            <div class="card-body row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label title="Memorando del Consejo Universitario">Consejo Universitario</label>
                                        <input placeholder="Código" type="text" class="form-control" v-model="memo.cu.code">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label title="Fecha de Emisión">Fecha</label>
                                        <datepicker
                                        :language="es"
                                        :disabled="memo.cu.code == ''"
                                        placeholder="Emisión" 
                                        v-model="memo.cu.date"
                                        :full-month-name="true"
                                        :disabled-dates="no_dates" 
                                        :input-class="memo.cu.code !== ''?'bg-white form-control':'form-control'"></datepicker>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label title="Fecha de Recepcion">Fecha</label>
                                        <datepicker
                                        :language="es"
                                        :disabled="memo.cu.code == ''"
                                        placeholder="Recepcion" 
                                        v-model="memo.cu.date_r"
                                        :full-month-name="true"
                                        :disabled-dates="no_dates" 
                                        :input-class="memo.cu.code !== ''?'bg-white form-control':'form-control'"></datepicker>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- col-12 -->
                        <div class="col-12">
                            <button @click="saveAscent" class="col-2 offset-10 btn btn-success btn-block">Guardar</button>
                        </div>
                        <!-- col-12 -->
                    </template>
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
        this.getCategories();
	},
	data()
    {
		return {
            // data required
			dni:null,
            file:null,
            no_dates:{to: new Date('1919-01-01')},
            modalities:['art. 61','art. 62','art. 64','ubicacion'],
            list_works:['libro','trabajo de investigacion','publicacion'],
            list_headquarters:[],
            list_areas:[],
            list_programs:[],
            list_cores:[],
            list_t_classrooms:[],
            list_extensions:[],
            list_categories:[],
            list_categories_b:[],
            en: en,
            es: es,

            // data new
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
                ascents:[],
            },
            current_category:{
                time:'',
                date:'',
                category:null
            },
            job:{
                title:'',
                url:'',
                date:'',
                file:null,
                jury:{
                    coordinator:'',
                    principal1:'',
                    principal2:'',
                    alternate1:'',
                    alternate2:'',
                    alternate3:'',
                },
                presentation:{
                    date:'',
                    location:'',
                    hour:''
                }
            },
            scale:{
                date:'',
                description:'',
                file:null,
            },
            ascent:{
                id:0,
                date:null,
                category:null,
                modality:null,
                status:'espera'
            },
            memo:{
                cd:{
                    code:'',
                    date:'',
                    date_r:''
                },
                area:{
                    code:'',
                    date:'',
                    date_r:''
                },
                vrac:{
                    code:'',
                    date:'',
                    date_r:''
                },
                cu:{
                    code:'',
                    date:'',
                    date_r:''
                }
            },
            publication:{
                title:'',
                rev:'',
                code_issn:'',
                nro_isbn:'',
                nro_edit:'',
                vol:'',
                date:'',
                url:'',
                postgraduate:null
            },
            publications:[],
        }
    },
    methods:{
        onFileChange(e) {
            let file = event.target.files[0]
            let fileReader = new FileReader()
            fileReader.readAsDataURL(file)
            fileReader.onload = (e) => {
                this.job.file = e.target.result
                this.scale.file = e.target.result
            }
        },
        validationAsc()
        {
            this.resetPublications()
            if (this.ascent.modality!==null) {
                this.showPublications()
            }
        },
        addPublications(n)
        {
            if(n>1){
                for (var i = 1; i <= n; i++) {
                    this.publications.push(Vue.util.extend({}, this.publication))
                }
            }else{
                this.publications = [Vue.util.extend({}, this.publication)]
            }
        },
        resetPublications()
        {
            this.publications.length=0
        },
        showPublications()
        {
            if (this.ascent.modality == 'art. 61') 
            {
                this.resetPublications()
                this.addPublications(1)
            }else if(this.ascent.modality == 'art. 62')
            {
                this.resetPublications()
                switch (this.ascent.category.name)
                {
                    case "asistente":
                    {
                        this.addPublications(1)
                        break;  
                    }
                    case "agregado":
                    {
                        this.addPublications(3)
                        break;  
                    }
                    case "asociado":
                    {
                        this.addPublications(4)
                        break;  
                    }
                    case "titular":
                    {
                        this.addPublications(4)
                        break;  
                    }
                }
            }else if(this.ascent.modality == 'ubicacion')
            {
                this.ascent.date = new Date()
                this.teacherData.postgraduate = null
            }
        },
        diffYears(data)
        {
            let moment = require('moment')
            let cc = null //fecha de categoria actual
            let nc = null //fecha para categoria siguiente
            let dc = new Date() //fecha actual
            let cd = null //fecha de ascenso
            moment.locale('es');
            data.ascents.forEach(asc=>{
                cc = asc.date
                nc = asc.date_next
            })
            this.ascent.date = (nc !== null)?new moment(nc)._d:null
            this.current_category.date = cc
            this.current_category.time = new moment(cc).toNow(true)
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
        getCategories()
        {
            let url = location.origin+"/get-categories"
            axios.get(url).then(response => {
                this.list_categories = response.data
                this.setCategories()
            }).catch(errors =>{
                console.log(errors.response)
            })
        },
        setCategories()
        {
            let categories = this.list_categories
            let ascents = this.teacherData.ascents
            let category = this.teacherData.category.name

            if (category == 'titular') {
                this.list_categories_b = [];
            }else if(category == 'asociado'){
                this.list_categories_b=categories.filter((cat) => {
                    return cat.name.toLowerCase().indexOf('asociado') == -1 &&
                        cat.name.toLowerCase().indexOf('agregado') == -1 &&
                        cat.name.toLowerCase().indexOf('asistente') == -1 &&
                        cat.name.toLowerCase().indexOf('instructor') == -1
                });
            }else if(category == 'agregado'){
                this.list_categories_b=categories.filter((cat) => {
                    return cat.name.toLowerCase().indexOf('agregado') == -1 &&
                        cat.name.toLowerCase().indexOf('asistente') == -1 &&
                        cat.name.toLowerCase().indexOf('instructor') == -1
                });
            }else if(category == 'asistente'){
                this.list_categories_b=categories.filter((cat) => {
                    return cat.name.toLowerCase().indexOf('asistente') == -1 &&
                        cat.name.toLowerCase().indexOf('instructor') == -1
                });
            }else{
                for (var i = 0; i < categories.length; i++) {
                    for (var j = 0; j < ascents.length; j++) {
                        let idx = categories[i].name.indexOf(ascents[j].current_category.name)
                        if (idx > -1) {
                            categories.splice(idx,1)
                        }
                    }
                }
                this. list_categories_b = categories
            }
        },
		momentDate(date){
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
                        this.getCategories()
                        this.diffYears(response.data)
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
            }
            this.current_category={
                time:'',
                date:'',
                category:null
            }
            this.ascent={
                id:0,
                date:null,
                category:null,
                modality:null,
                status:'espera'            
            }
            this.job={
                title:'',
                date:'',
                url:'',
                file:null,
                jury:{
                    cordinator:'',
                    principal1:'',
                    principal2:'',
                    alternate1:'',
                    alternate2:'',
                    alternate3:''
                },
                presentation:{
                    date:'',
                    location:'',
                    hour:''
                }
            }
            this.scale={
                date:'',
                description:'',
                file:null
            }
            this.memo={
                area:{
                    cod:'',
                    date:''
                },
                vrac:{
                    cod:'',
                    date:''
                },
                cu:{
                    cod:'',
                    date:''
                }
            }
            this.publication={
                title:'',
                rev:'',
                code_issn:'',
                nro_isbn:'',
                nro_edit:'',
                vol:'',
                date:'',
                url:'',
                postgraduate:null
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
        formDate(date)
        {
            let moment = require('moment')
            moment.locale('es');
            if (date!==null && date!=='') {
                return new moment(date)._d
            }
        },
        saveAscent()
        {
            this.$root.loading('Verificando y guardando','Espere mientras se verifican los datos para registrar este ascenso')
            this.reduceData()
            let url = location.origin+'/movimiento/store-ascent'
            axios.post(url,{
                teacherData : this.teacherData,
                publications : this.publications,
                current_category : this.current_category,
                jury : this.jury,
                memo : this.memo,
                ascent : this.ascent,
                job : this.job,
                scale : this.scale
            }).then(response => {
                this.teacherDataBlack()
                this.searchTeacher()
                swal.close()
                this.$alertify.success('El ascenso se registro con exito')
            }).catch(errors => {
                swal.close()
                if (status = 204)
                {
                    Object.values(errors.response.data.errors).forEach((element,indx) => {
                        this.$alertify.error(element.toString())
                    });
                }
            })
        }
	}
}
</script>