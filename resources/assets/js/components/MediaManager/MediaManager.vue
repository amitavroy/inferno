<template src="./MediaManager.html"></template>
<script>
  import Dropzone from 'vue2-dropzone'

  export default {
    components: {
      Dropzone
    },
    created () {
      this.csrfHeaders = {
        'X-CSRF-TOKEN': window.Laravel.csrfToken
      }
    },
    data () {
      return {
        showUploader: false,
        csrfHeaders: null
      }
    },
    methods: {
      showSuccess (file) {
        console.log('file', file)
      }
    }
  }
</script>