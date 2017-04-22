<template src="./MediaManager.html"></template>
<script>
  import {
    getMedia, mediaUpload
  } from './../../config'
  import Dropzone from 'vue2-dropzone'

  export default {
    components: {
      Dropzone
    },
    created () {
      this.$http.get(getMedia)
        .then(response => {
          this.images = response.data.data
        })

      this.csrfHeaders = {
        'X-CSRF-TOKEN': window.Laravel.csrfToken
      }
    },
    data () {
      return {
        showUploader: false,
        csrfHeaders: null,
        images: [],
        mediaUpload: mediaUpload
      }
    },
    methods: {
      showSuccess (file, response) {
        console.log('response', response)
        this.images.unshift(response.data)
      },
      onError (file, error) {
        console.log('file error', file, error)
      }
    }
  }
</script>

<style lang="scss" scoped>
  .galleryWrapper {
    li {
      list-style: none;
      float: left;
      padding: 8px;
      margin: 0;
      .thumbnail {
        position: relative;
        width: 150px;
        height: 150px;
        overflow: hidden;
        img {
          position: absolute;
          left: 50%;
          top: 50%;
          height: 100%;
          width: auto;
          -webkit-transform: translate(-50%,-50%);
          -ms-transform: translate(-50%,-50%);
          transform: translate(-50%,-50%);
        }
      }
    }
  }
</style>