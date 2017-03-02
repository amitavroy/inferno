<script>
  export default {
    mounted () {
      window.eventBus.$on('closed-modal-popup', data => {
        console.log('closed-modal-popup')
      })
    },
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
    },
    sockets: {
      message () {
        console.log('sidebar collapsed')
      },
      connect (status) {
        console.log('connected')
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