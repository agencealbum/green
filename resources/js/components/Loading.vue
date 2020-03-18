<template>

  <div class="container-fluid">

    <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>

    <div class="row mb-4 d-flex justify-content-center">
      <div class="col-6">
        <div class="progress" style="height: 2rem;">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style="'width:' + progress + '%'" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div id="carouselExampleSlidesOnly" class="carousel slide text-center" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              Saisissez l'adresse d'un site web si vous la connaissez plutôt que de passer par un moteur de recherche.
            </div>
            <div class="carousel-item">
              Désinscrivez-vous des bulletins d'information que vous ne lisez pas.
            </div>
            <div class="carousel-item">
              Supprimez régulièrement les courriels qui ont été traités, et n'oubliez pas de vider la corbeille.
            </div>
          </div>
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

    }

</script>