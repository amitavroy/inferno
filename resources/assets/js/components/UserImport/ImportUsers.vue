<script>
  import swal from 'sweetalert2'
  export default {
    props: ['url'],

    created () {
      console.log('url', this.url)
    },

    methods: {
      importUser () {
        this.message = null
        this.$http.get(this.url)
          .then(response => {
            swal('Success', response.data, 'success')
          })
          .catch(error => console.log('error', error))
      }
    }
  }
</script>

<template>
  <div class="ImportUsers__wrapper">
    <a v:bind-href="url" class="btn btn-success" v-on:click="importUser">Import valid users</a>
  </div>
</template>

<style>

</style>