<template>

   <div class="d-flex align-items-center flex-column justify-content-center w-100 h-100 text-white">


      <template v-if="loading">

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

      <template v-if="!loading">

        <template v-if="!result">
        
          <h2>Estimez l'empreinte carbone de votre site web.</h2>
          
          <form @submit.prevent="scan" class="form-inline">
              <div class="form-group">
                  <input class="form-control form-control-lg" v-model="url" placeholder="https://" type="url" required>
              </div>
              <div class="form-group">
                  <button class="btn btn-primary btn-lg ml-4" type="submit">Calculer</button>
              </div>
          </form>

        </template>

        <div v-if="result" class="container text-dark">

            <div class="alert alert-warning">

              <h1>{{ result.title }}</h1>

              <p>{{ result.tags.description }}</p>

            </div>

            <div class="my-5 alert alert-info">
              <h1>Score total : {{ total }} %</h1>
            </div>

            <div class="results row text-center">

              <div class="card-deck d-flex">

                <div class="col card h-100 justify-content-center align-self-center">
                  <h4>Hébergement vert</h4>
                  <span v-if="result.hosting.green">OUI</span>
                  <template v-else>
                    <span v-if="result.hosting.hostedby">NON</span>
                    <span v-else>INCONNU</span>
                  </template>
                </div>

                <div class="col card h-100 justify-content-center align-self-center">
                  <h4>Performance</h4>
                  {{ result.pagespeed.original.speedScore }} %
                </div>

                <div class="col card h-100 justify-content-center align-self-center">
                  <h4>Émission</h4>
                  <p><strong>{{ result.carbon.c }}g</strong><br> de CO2 par visite</p>
                </div>

                <div class="col card h-100 justify-content-center align-self-center">
                  <h4>Adaptabilité</h4>
                  {{ result.pagespeed.original.usabilityScore }} %
                </div>

                <div class="col card h-100 justify-content-center align-self-center">
                  <img class="img-fluid" :src="'data:image/jpeg;base64,'+result.pagespeed.original.thumbnail">
                </div>

              </div>

            </div>

          </div>

        </template>

    </div>

</template>

<script>

    export default {

        name: 'scan',

        data: function () {
            return {
                result: null,
                url: 'https://www.agencealbum.com',
                loading: false,
                total: 0,
                progress: 0,
                lastprogress: 0,
                interval: 0
            }
        },

        mounted() {
            //console.log('Component mounted.')
        },

        methods: {

            scan() {

                this.loading = true;
                this.getProgress();

                axios.get('/scan?url=' + this.url).then(response => {
                    this.clearProgress();
                    this.result = response.data;
                    this.loading = false;
                    this.calculate();
                });
            },

            calculate() {

              var carbon = (this.result.carbon.c > 1) ? 0 : (100 - (this.result.carbon.c * 100));
              var host = (this.result.hosting.green) ? 75 : 25;
              var sum = this.result.pagespeed.original.speedScore + this.result.pagespeed.original.usabilityScore + carbon + host;

              this.total = Math.round(sum / 4);

            },

            getProgress() {
              this.progress = 0;
              let vm = this;
              this.interval = setInterval(function(){
                  axios.get('/progress').then(response => {
                      console.log(response.data);
                      if (vm.lastprogress == response.data) {
                        vm.progress = vm.progress + 0.5;
                      } else {
                        vm.lastprogress = response.data;
                        vm.progress = response.data;
                      }
                  });
              }, 1000);

            },

            clearProgress() {
              this.progress = 100;
              clearInterval(this.interval);
              this.interval = 0;
            }

        }
    }

</script>
