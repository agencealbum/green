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


        <div v-if="result" class="container text-center">

            <div class="results row mb-5">

              <div class="col h-100 result result-1 justify-content-center align-self-center">
                <img src="/img/results/hosting-0.svg">
                <h4>Hébergement</h4>
                <animated-number :formatValue="formatNumber" :value="result.hosting"></animated-number> %
              </div>

              <div class="col h-100 result result-2 justify-content-center align-self-center">
                <img src="/img/results/performances-0.svg">
                <h4>Performances</h4>
                <animated-number :formatValue="formatNumber" :value="result.performance"></animated-number> %
              </div>

              <div class="col h-100 result result-3 justify-content-center align-self-center">
                <img src="/img/results/adaptability-0.svg">
                <h4>Adaptabilité</h4>
                <animated-number :formatValue="formatNumber" :value="result.usability"></animated-number> %
              </div>

              <div class="col h-100 result result-4 justify-content-center align-self-center">
                <img src="/img/results/carbon-0.svg">
                <h4>Bilan carbone</h4>
                <animated-number :formatValue="formatNumber" :value="result.carbon"></animated-number> %
              </div>

            </div>

            <div class="row">

              <div class="col-md-12">

                <p>Pour améliorer votre score</p>

                <router-link to="/contact" class="btn btn-lg btn-submit">Contactez nous</router-link>

              </div>

            </div>


          </div>

        </template>

    </div>

</template>

<script>

    import AnimatedNumber from "animated-number-vue";

    export default {

        name: 'scan',

        components: {
          AnimatedNumber
        },

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

            formatNumber(value) {
              return `${value.toFixed()}`;
            },

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

              var sum = this.result.performance + this.result.usability + this.result.carbon + this.result.hosting;
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
