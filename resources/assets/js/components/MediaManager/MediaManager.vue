<template src="./MediaManager.html"></template>
<script>
  import {
    getMedia, mediaUpload, metaDataSave
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
      window.eventBus.$on('bulmaModalClose', () => {
        this.currentImage = this.setCurrentImage()
      })
    },
    data () {
      return {
        showUploader: false,
        csrfHeaders: null,
        images: [],
        mediaUpload: mediaUpload,
        currentImage: this.setCurrentImage()
      }
    },
    methods: {
      setCurrentImage () {
        return {
          directory: '',
          filename: '',
          extension: '',
          meta_data: {
            alt: '',
            caption: '',
            currentImageId: null
          }
        }
      },
      showSuccess (file, response) {
        console.log('response', response)
        var imageData = response.data
        imageData.meta_data = {
          alt: '',
          caption: '',
          currentImageId: imageData.id
        }
        this.images.unshift(imageData)
      },
      onError (file, error) {
        console.log('file error', file, error)
      },
      handleImageDetails(image) {
        window.eventBus.$emit('bulmaModalOpen', image)
        this.currentImage = image
        if (image.meta_data == null) {
          // console.log('need to add meta_data')
          image.meta_data = {
            alt: '',
            caption: '',
            currentImageId: image.id
          }
        } else {
          // console.log('has meta_data');
          (typeof image.meta_data === 'object') ? this.currentImage.meta_data = image.meta_data : this.currentImage.meta_data = JSON.parse(image.meta_data);
        }
      },
      handleImageMetaDataSave() {
        this.currentImage.meta_data.currentImageId = this.currentImage.id
        this.$http.post(metaDataSave, this.currentImage.meta_data)
          .then(response => {
            console.log('response', response)
          }).catch(error => {
            console.log('error', error)
        })
      }
    }
  }
</script>

<style lang="scss">
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
  .media-manager-details {
    .modal-content {
      width: 80%;
      .big-image {
        img {
          max-width: 660px;
        }
      }
    }
  }
</style>
