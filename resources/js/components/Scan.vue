<template>

   <div>

      <scan-header :result="result" :total="total"></scan-header>

      <loading v-if="loading" :progress="progress"></loading>

      <template v-if="!loading">

        <section v-if="!result" class="ask">

          <div class="container">

            <div class="row">

              <div class="col-md-12 text-center">

                <form @submit="checkUrl">

                  <div class="row mb-5">

                    <div class="col-md-6">

                      <label class="sr-only" for="inlineFormInputName2"></label>
                      <input type="email" class="form-control form-control-lg mb-2 mr-sm-2" v-model="email" required placeholder="Entrez votre email">

                    </div>

                    <div class="col-md-6">

                      <label class="sr-only" for="inlineFormInputName2"></label>
                      <input type="url" class="form-control form-control-lg mb-2 mr-sm-2" :class="{'is-invalid': urlError}" v-model="url" required placeholder="Entrez l'URL de votre site">
                      <div v-if="urlError" class="invalid-feedback">
                        L'adresse de votre site est incorrecte ou n'existe pas.
                      </div>

                    </div>

                  </div>

                  <div class="row">

                    <div class="col-md-12 d-flex justify-content-center">

                      <button v-if="checking" class="btn btn-lg btn-submit d-flex align-items-center" type="submit">
                        <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                         Vérification de l'url...
                      </button>
                      <button v-else class="btn btn-lg btn-submit" type="submit">Testez maintenant</button>

                    </div>

                  </div>

                </form>

              </div>

            </div>

          </div>

        </section>

        <transition name="fade" mode="out-in">
          <result v-if="result" :result="result" v-on:show-more="more = $event"></result>
        </transition>

        <more :class="{active : more}" v-on:show-more="hideMore" :about="more"></more>

      </template>

    </div>

</template>

<script>

    export default {

        name: 'scan',

        data: function () {
            return {
                result: null,
                url: '',
                checking: false,
                urlError: false,
                loading: false,
                total: 0,
                progress: 0,
                lastprogress: 0,
                interval: 0,
                email: 'martin@agencealbum.com',
                ip: '',
                more: null,
            }
        },

        watch: {

          url: function (newUrl, oldUrl) {
            if (!this.url.match(/^[a-zA-Z]+:\/\//))
            {
                this.url = 'https://' + this.url;
            }
          }

        },

        methods: {

          verification() {

            axios.post('/verification', {url: this.url, email: this.email})
              .then(function (response) {
                console.log(response.data);
              });

          },

          hideMore(event) {

            this.more = null;
            $('.result').delay(1000).removeClass('hide');

            var left = parseFloat($('.result.active').attr('data-left'));

            $('.result.active').removeClass('active')
                  .css('transform', 'translate(' + (-left - 40) + 'px, 0px)')
                  .delay(200)
                  .queue(function (next) {
                    $(this).css('transform', 'translateX(0)');
                    $('.header').removeClass('hide');
                    next();
                  })


          },


            checkUrl(e) {

              let vm = this;
              vm.urlError = false;
              vm.checking = true;

              e.preventDefault();

              axios.post('/check/url', {url: this.url, email: this.email})
                .then(function (response) {
                  if(response.data) {
                    vm.scan();
                  } else {
                    vm.urlError = true;
                  }
                  vm.checking = false;

                })
                .catch(function (error) {
                  console.log(error);
                })

            },

            scan() {

                this.loading = true;
                this.getProgress();

                axios.post('/scan', {url:this.url, email:this.email}).then(response => {
                    this.clearProgress();
                    this.result = response.data;
                    this.loading = false;
                    this.calculate();
                });
            },

            calculate() {

              var sum = this.result.performance + this.result.usability + this.result.carbon.percent + this.result.hosting;
              this.total = Math.round(sum / 4);

            },

            getProgress() {
              this.progress = 0;
              let vm = this;
              this.interval = setInterval(function(){
                  axios.get('/progress').then(response => {
                      console.log(response.data);
                      if (vm.lastprogress == response.data) {
                        vm.progress = vm.progress + 1.2; // 0.8
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
    };

</script>
