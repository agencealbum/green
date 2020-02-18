<template>

   <div class="d-flex align-items-center flex-column justify-content-center w-100 h-100 text-white">

        <div v-show="loading" class="spinner">
          <div class="double-bounce1"></div>
          <div class="double-bounce2"></div>
        </div>
        
        <h2>Estimez l'empreinte carbone de votre site web.</h2>
        
        <form @submit.prevent="scan" class="form-inline">
            <div class="form-group">
                <input class="form-control form-control-lg" v-model="url" placeholder="https://" type="url" required>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-lg ml-4" type="submit">Calculer</button>
            </div>
        </form>

        <div v-if="result" class="container text-dark">

            <div class="my-5 alert alert-info">
              Score total : {{ total }} %
            </div>

            <div class="results row text-center d-flex">

              <div class="card-deck justify-content-center align-self-center">

                <div class="col card">
                  <h4>Hébergement vert</h4>
                  <span v-if="result.hosting.green">75%</span>
                  <span v-else>25%</span>
                </div>

                <div v-if="result.hosting.hostedby" class="col card rabbit-bg">
                  <h4>Performance</h4>
                  {{ result.pagespeed.original.speedScore }} %
                </div>

                <div class="col card">
                  <h4>Émission</h4>
                  <p><strong>{{ result.carbon.c }}g</strong><br> de CO2 par visite</p>
                </div>

                <div class="col card">
                  <h4>Adaptabilité</h4>
                  {{ result.pagespeed.original.usabilityScore }} %
                </div>

                <div class="col card">
                  <img class="img-fluid" :src="'data:image/jpeg;base64,'+result.pagespeed.original.thumbnail">
                </div>

              </div>

            </div>

        </div>

    </div>

</template>

<script>
    export default {

        name: 'scan',

        data: function () {
            return {
                result: null,
                url: 'https://www.google.com',
                loading: false,
                total : 0,
            }
        },

        mounted() {
            //console.log('Component mounted.')
        },

        methods: {

            scan() {

                this.loading = true;

                axios.get('/scan?url=' + this.url).then(response => {
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
        }
    }

</script>

<style>

.results {
    font-size: 2rem;
}

.spinner {
  width: 40px;
  height: 40px;

  position: relative;
  margin: 100px auto;
}

.double-bounce1, .double-bounce2 {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background-color: #FFF;
  opacity: 0.6;
  position: absolute;
  top: 0;
  left: 0;
  
  -webkit-animation: sk-bounce 2.0s infinite ease-in-out;
  animation: sk-bounce 2.0s infinite ease-in-out;
}

.double-bounce2 {
  -webkit-animation-delay: -1.0s;
  animation-delay: -1.0s;
}

@-webkit-keyframes sk-bounce {
  0%, 100% { -webkit-transform: scale(0.0) }
  50% { -webkit-transform: scale(1.0) }
}

@keyframes sk-bounce {
  0%, 100% { 
    transform: scale(0.0);
    -webkit-transform: scale(0.0);
  } 50% { 
    transform: scale(1.0);
    -webkit-transform: scale(1.0);
  }
}

</style>

