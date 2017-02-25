<!--suppress JSUnresolvedVariable -->
<template src="./UserActivation.html"></template>
<script type="text/babel">
  import _ from 'lodash'
  import ConfirmModal from './../ConfirmModal'
  import {
    activateUser, deleteUser
  } from './../../config'
  export default {
    components: {
      'confirm-modal': ConfirmModal
    },
    props: ['users'],
    mounted () {
      this.userList = this.users
    },
    data () {
      return {
        activateUser: activateUser,
        deleteUser: deleteUser,
        userList: []
      }
    },
    methods: {
      removeUserFromList (userToRemove) {
        this.userList = _.remove(this.userList, user => {
          return user.id !== userToRemove.id
        })
      }
    }
  }
</script>