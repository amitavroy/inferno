<template src="./UserActivation.html"></template>
<script type="text/babel">
  import _ from 'lodash'
  import {
    activateUser, deleteUser
  } from './../../config'
  export default {
    props: ['users'],
    mounted () {
      this.userList = this.users
    },
    data () {
      return {
        userList: []
      }
    },
    methods: {
      deleteInactiveUser (user) {
        this.axios.post(deleteUser, {userId: user.id}).then(response => {
          this.userList = _.remove(this.userList, user => {return user.id !== response.data.data.id})
        })
      },
      activateInactiveUser (user) {
        this.axios.post(activateUser, {userId: user.id}).then(response => {
          this.userList = _.remove(this.userList, user => {return user.id !== response.data.data.id})
        })
      }
    }
  }
</script>