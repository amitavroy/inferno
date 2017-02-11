<script>
  export default {
    data () {
      return {
        clickable: true
      }
    },
    methods: {
      handleSidebarToggle () {
        if (this.clickable) {
          this.clickable = false
          this.$http.post('/api/v1/sidebar-toggle').then(response => {
            this.clickable = true
          })
        }
      }
    }
  }
</script>

<template>
  <a href="javascript:void(0);" 
    class="sidebar-toggle" 
    data-toggle="offcanvas" 
    role="button"
    v-on:click="handleSidebarToggle"
  >
    <span class="sr-only">Toggle navigation</span>
  </a>
</template>