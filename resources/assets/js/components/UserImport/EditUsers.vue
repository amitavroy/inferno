<script>
  import {editErrorUserData} from './../../config'
  import { TableComponent, TableColumn } from 'vue-table-component'

  export default {
    props: ['uuid'],

    components: {
      'table-component': TableComponent,
      'table-column': TableColumn
    },

    data () {
      return {
        tableData: null
      }
    },

    methods: {
      loadTableData () {
        var url = editErrorUserData + this.uuid
        this.$http.get(url)
          .then(response => this.tableData = response.data)
          .catch(error => console.log(error.message()))
      },

      showRowData (data) {
        console.log('data', data)
      }
    }
  }
</script>

<template>
  <div class="EditUsers__wrapper">
    <pre>{{tableData}}</pre>
    <div class="margin-bottom-10">
      <button class="btn btn-primary" v-on:click="loadTableData">
        <i class="fa fa-edit"></i> Live edit users
      </button>
    </div>

    <div class="margin-bottom-10" v-if="tableData">
      <table-component :data="tableData" sort-by="name" sort-order="asc">
        <table-column show="name" label="Name"></table-column>
        <table-column show="email" label="Email address"></table-column>
        <table-column show="message" label="Error message"></table-column>
      </table-component>
    </div>
  </div>
</template>

<style>

</style>