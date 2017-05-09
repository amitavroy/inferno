<script>
  export default {
    props: {
      modalClass: {
        type: String,
        default: 'bulma-modal'
      }
    },
    created () {
      window.eventBus.$on('bulmaModalOpen', (data) => {
        this.modalData = data
        this.modalStatus = true
      })
    },
    data () {
      return {
        modalStatus: false,
        modalData: null
      }
    },
    methods: {
      close () {
        this.modalStatus = false
        this.modalData = null
        window.eventBus.$emit('bulmaModalClose')
      }
    }
  }
</script>

<template>
  <div class="modal" v-bind:class="[(modalStatus) ? 'is-active' : '', modalClass]">
    <div class="modal-background" v-on:click="close"></div>
    <div class="modal-content">
      <slot></slot>
    </div>
    <button class="modal-close" v-on:click="close"></button>
  </div>
</template>

<style lang="scss">
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
    -webkit-transform: translateX(-50%) translateY(-50%) rotate(45deg);
    transform: translateX(-50%) translateY(-50%) rotate(45deg);
    -webkit-transform-origin: center center;
    transform-origin: center center;
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
    height: 16px;
    width: 16px;
  }

  .modal-close.is-medium {
    height: 24px;
    width: 24px;
  }

  .modal-close.is-large {
    height: 32px;
    width: 32px;
  }

  .modal-card {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    max-height: calc(100vh - 40px);
    overflow: hidden;
  }

  .modal-card-head,
  .modal-card-foot {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    background-color: whitesmoke;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-negative: 0;
    flex-shrink: 0;
    -webkit-box-pack: start;
    -ms-flex-pack: start;
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
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    -ms-flex-negative: 0;
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
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    -ms-flex-negative: 1;
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
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    display: none;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    overflow: hidden;
    position: fixed;
    z-index: 1986;
  }

  .modal.is-active {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
  }
</style>
