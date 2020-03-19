<template>

   <div>

      <loading v-if="loading" :progress="progress"></loading>

      <scan-header :result="result" :total="total"></scan-header>

      <template v-if="!loading">

        <section v-if="!result" class="ask">

          <div class="container">

            <div class="row">

              <div class="col-md-12">

                <form @submit="scan">

                  <div class="row mb-5">

                    <div class="col-md-6">

                      <label class="sr-only" for="inlineFormInputName2"></label>
                      <input type="email" class="form-control form-control-lg mb-2 mr-sm-2" v-model="email" placeholder="Entrez votre email">

                    </div>

                    <div class="col-md-6">

                      <label class="sr-only" for="inlineFormInputName2"></label>
                      <input type="url" class="form-control form-control-lg mb-2 mr-sm-2" v-model="url" required placeholder="Entrez l'URL de votre site">

                    </div>

                  </div>

                  <div class="row">

                    <div class="col-md-12 d-flex justify-content-center">

                      <button class="btn btn-lg btn-submit" type="submit">Testez maintenant</button>

                    </div>

                  </div>

                </form>

              </div>

            </div>

          </div>

        </section>


        <div v-if="result" class="container text-dark">

            <div class="results row text-center">

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
                interval: 0,
                email: '',
                ip: ''
            }
        },

        mounted() {

        },

        methods: {

            scan(e) {

                e.preventDefault();

                this.loading = true;
                this.getProgress();

                axios.post('/api/scan', {url:this.url, email:this.email}).then(response => {
                    this.clearProgress();
                    this.result = response.data;
                    this.loading = false;
                    this.calculate();
                });
            },

            calculate() {

              var carbon = (this.result.carbon.c > 1) ? 0 : (100 - (this.result.carbon.c * 100));
              var host = (this.result.hosting.green) ? 100 : 25;
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
