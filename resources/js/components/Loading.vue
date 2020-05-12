<template>

  <div class="container-fluid">

    <div class="d-none d-lg-block spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>

    <div class="row mb-4 d-flex justify-content-center">
      <div class="col-6 text-center">
        <h2 class="mb-3">Nos petits robots verts<br>inspectent votre site...</h2>
        <div class="progress-bar">
          <div class="loaded"></div>
        </div>
      </div>
    </div>

  </div>

</template>

<script>

    export default {

        name: 'loading',

        props: ['progress'],

        data: function () {
            return {

            }
        },

        mounted() {
            
        },

        methods: {

        }

    };

</script>


<style>

  .progress-bar {
    height: 4px;
    width: 100%;
    background: white;
    border-radius: 2px;
  }

  .loaded {
    height: 100%;
    width: 0;
    background: #4E483C;
    transform-origin: 0%;
    transition: all .5s ease;
  }

</style>