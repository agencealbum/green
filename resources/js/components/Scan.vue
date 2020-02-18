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

            <div class="mt-5 results row text-center">

              <div class="card-deck">

                <div class="col card">
                  <p>Hébergement vert</p>
                  <span v-if="result.hosting.green">OUI</span>
                  <span v-else>NON</span>
                </div>

                <div v-if="result.hosting.hostedby" class="col card rabbit-bg">

                </div>

                <div class="col card">
                  <strong>{{ result.carbon.c }}g</strong> de CO2 à chaque visite.
                </div>

                <div class="col card rabbit-bg">

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
                loading: false
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
                });
            }
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

