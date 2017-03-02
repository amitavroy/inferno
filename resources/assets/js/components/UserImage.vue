<script type="text/babel">
  export default {
    props: ['src', 'alt', 'imgClass'],
    created () {
        this.imageSrc = this.src
    },
    data () {
      return {
          imageSrc: ''
      }
    },
    methods: {
      userImageChanged (imageSrc) {
        this.imageSrc = imageSrc
        console.log('image src changed to ', imageSrc)
      }
    },
    sockets: {
      usr_image_uploaded (imageSrc) {
        console.log(imageSrc)
        this.userImageChanged(imageSrc)
      }
    }
  }
</script>
<template>
  <img v-bind:src="imageSrc" v-bind:alt="alt" v-bind:class="imgClass">
</template>