<template>
  <div class="FieldField__wrapper">
    <img v-bind:src="imagePreview" class="preview-image" v-on:click="openUpload">

    <div class="form-group">
      <input
        name="image"
        type="file"
        id="file-field"
        v-on:change="updatePreview"
        style="display:none;">
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        imagePreview: '/adminlte/upload_image.png'
      }
    },

    methods: {
      openUpload () {
        document.getElementById('file-field').click()
      },
      updatePreview (e) {
        console.log('e', e)
        var reader, files = e.target.files

        if (files.length === 0) {
          console.log('Empty')
        }

        reader = new FileReader();

        reader.onload = (e) => {
          this.imagePreview = e.target.result
        }

        reader.readAsDataURL(files[0])
      }
    }
  }
</script>

<style>
  .preview-image {
    width: 327px;
    height: 184px;
  }
</style>