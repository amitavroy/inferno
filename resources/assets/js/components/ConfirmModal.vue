<script type="text/babel">
  export default {
    props: ['url', 'postData', 'message', 'btnClass', 'btnText', 'json', 'refresh'],
    created () {
      if (this.json === true) {
        this.dataToSend = JSON.parse(this.postData)
        console.log('dataToSend', this.dataToSend)
      }

      if (this.refresh === true) {
        this.$on('onConfirm', function () {
          window.location.reload()
        })
      }

      this.dataToSend = this.postData
    },
    data () {
      return {
        dataToSend: null,
        modalState: false
      }
    },
    methods: {
      handleCloseButton () {
        this.modalState = false
        window.eventBus.$emit('closed-modal-popup')
      },
      handleActionButton () {
        this.modalState = true
      },
      handleConfirmButton () {
        this.$http.post(this.url, this.dataToSend).then(response => {
          console.log('response', response)
          this.$emit('onConfirm')
          this.handleCloseButton()
        })
      }
    }
  }
</script>

<template>
  <div class="ConfirmModalWrapper">
    <button class="btn btn-xs" 
      @click="handleActionButton"
      v-bind:class="btnClass">
      <div v-html="btnText"></div>
    </button>
    <div class="modal" v-bind:class="{'is-active': modalState}">
      <div class="modal-background"></div>
      <div class="modal-content">
        <h4>{{message}}</h4>
        <button class="btn btn-success" @click="handleConfirmButton">Ok</button>
        <button class="btn btn-warning" @click="handleCloseButton">Cancel</button>
      </div>
      <button class="modal-close" @click="handleCloseButton"></button>
    </div>
  </div>
</template>

<style>
  .modal-background {
    bottom: 0;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    background-color: rgba(10, 10, 10, 0.86);
  }

  .modal-content,
  .modal-card {
    margin: 0 20px;
    max-height: calc(100vh - 160px);
    overflow: auto;
    position: relative;
    width: 100%;
    padding: 20px;
  }

  .modal-content h4 {
    padding-bottom: 20px;
    text-align: left;
  }

  @media screen and (min-width: 769px) {
    .modal-content,
    .modal-card {
      margin: 0 auto;
      max-height: calc(100vh - 40px);
      width: 640px;
    }
  }

  .modal-close {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -moz-appearance: none;
    -webkit-appearance: none;
    background-color: rgba(10, 10, 10, 0.2);
    border: none;
    border-radius: 290486px;
    cursor: pointer;
    display: inline-block;
    font-size: 1rem;
    height: 20px;
    outline: none;
    position: relative;
    transform: rotate(45deg);
    transform-origin: center center;
    vertical-align: top;
    width: 20px;
    background: none;
    height: 40px;
    position: fixed;
    right: 20px;
    top: 20px;
    width: 40px;
  }

  .modal-close:before, .modal-close:after {
    background-color: white;
    content: "";
    display: block;
    left: 50%;
    position: absolute;
    top: 50%;
    transform: translateX(-50%) translateY(-50%);
  }

  .modal-close:before {
    height: 2px;
    width: 50%;
  }

  .modal-close:after {
    height: 50%;
    width: 2px;
  }

  .modal-close:hover, .modal-close:focus {
    background-color: rgba(10, 10, 10, 0.3);
  }

  .modal-close:active {
    background-color: rgba(10, 10, 10, 0.4);
  }

  .modal-close.is-small {
    height: 14px;
    width: 14px;
  }

  .modal-close.is-medium {
    height: 26px;
    width: 26px;
  }

  .modal-close.is-large {
    height: 30px;
    width: 30px;
  }

  .modal-card {
    display: flex;
    flex-direction: column;
    max-height: calc(100vh - 40px);
    overflow: hidden;
  }

  .modal-card-head,
  .modal-card-foot {
    align-items: center;
    background-color: whitesmoke;
    display: flex;
    flex-shrink: 0;
    justify-content: flex-start;
    padding: 20px;
    position: relative;
  }

  .modal-card-head {
    border-bottom: 1px solid #dbdbdb;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
  }

  .modal-card-title {
    color: #363636;
    flex-grow: 1;
    flex-shrink: 0;
    font-size: 1.5rem;
    line-height: 1;
  }

  .modal-card-foot {
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    border-top: 1px solid #dbdbdb;
  }

  .modal-card-foot .button:not(:last-child) {
    margin-right: 10px;
  }

  .modal-card-body {
    -webkit-overflow-scrolling: touch;
    background-color: white;
    flex-grow: 1;
    flex-shrink: 1;
    overflow: auto;
    padding: 20px;
  }

  .modal {
    bottom: 0;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    align-items: center;
    display: none;
    justify-content: center;
    overflow: hidden;
    position: fixed;
    z-index: 1986;
  }

  .modal.is-active {
    display: flex;
  }
</style>