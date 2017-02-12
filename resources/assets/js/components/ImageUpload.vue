<script>
  import Croppie from 'croppie'
  import $ from 'jquery'
  export default {
    props: ['imgUrl', 'alt'],
    mounted () {
      let el = document.getElementById('croppie')
      let opts = {
        enableExif: true,
        viewport: {
          width: 100,
          height: 100,
          type: 'circle'
        }
      }
      this.croppie = new Croppie(el, {
        viewport: { width: 200, height: 200 },
        boundary: { width: 220, height: 220 },
        showZoomer: true,
        enableOrientation: true
      })
      this.croppie.bind({
        url: this.imgUrl
      })
    },
    data () {
      return {
        croppie: null
      }
    }
  }
</script>

<template>
  <div class="Image-upload-wrapper Image-upload">
    <p>Image</p>
    <!-- <img v-bind:src="imgUrl" v-bind:alt="alt" id="croppie"> -->
    <div id="croppie"></div>
    <!-- <img v-src="imgUrl" alt="{{ alt }}" id="croppie"> -->
  </div>
</template>