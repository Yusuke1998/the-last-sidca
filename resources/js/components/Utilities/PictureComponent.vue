<template>
  <div class="hello">    
    <picture-input 
      ref="pictureInput" 
      @change="onChange" 
      width="600" 
      height="600" 
      margin="16" 
      accept="image/jpeg,image/png" 
      size="10" 
      buttonClass="btn"
      :customStrings="{
        upload: '<h5>Excelente!</h5>',
        drag: '<h5>Agrega la Imagen Aqui!<h5>',
        change: 'Cambiar',
        remove: 'Eliminar',
        select: 'Selecciona',
        fileType: 'Este archivo no esta soportado.',
        aspect: 'Landscape/Portrait'
      }">
    </picture-input>
  </div>
</template>
<script>
  
import PictureInput from 'vue-picture-input'
 
export default {
  name: 'hello',
  data () {
    return {
    }
  },
  components: {
    PictureInput
  },
  methods: {
    onChange (image) {
      console.log('New picture selected!')
      if (image) {
        console.log('Picture loaded.')
        this.image = image
      } else {
        console.log('FileReader API not supported: use the <form>, Luke!')
      }
    }
  }
}
</script>