<template>
  <div v-if="result" class="container text-center">

    <div class="results row mb-5">

      <div @click="showMore('hosting', $event)" class="hosting col-md-3 h-100 result result-1 justify-content-center align-self-center">
        <img class="img-result" v-if="result.hosting > 70" src="/img/results/hosting-1.svg">
        <img class="img-result" v-else src="/img/results/hosting-0.svg">
        <h4>Hébergement</h4>
        <animated-number :formatValue="formatNumber" :value="result.hosting"></animated-number> %
      </div>

      <div @click="showMore('performances', $event)" class="performances col-md-3 h-100 result result-2 justify-content-center align-self-center">
        <img class="img-result" v-if="result.performance > 70" src="/img/results/performances-1.svg">
        <img class="img-result" v-else src="/img/results/performances-0.svg">
        <h4>Performances</h4>
        <animated-number :formatValue="formatNumber" :value="result.performance"></animated-number> %
      </div>

      <div @click="showMore('usability', $event)" class="usability col-md-3 h-100 result result-3 justify-content-center align-self-center">
        <img class="img-result" v-if="result.usability > 70" src="/img/results/adaptability-1.svg">
        <img class="img-result" v-else src="/img/results/adaptability-0.svg">
        <h4>Adaptabilité</h4>
        <animated-number :formatValue="formatNumber" :value="result.usability"></animated-number> %
      </div>

      <div @click="showMore('carbon', $event)" class="carbon col-md-3 h-100 result result-4 justify-content-center align-self-center">
        <img class="img-result" v-if="result.carbon.g < 1" src="/img/results/carbon-1.svg">
        <img class="img-result" v-else src="/img/results/carbon-0.svg">
        <h4>Bilan carbone</h4>
        <!--<animated-number :formatValue="formatNumber" :value="result.carbon.percent"></animated-number> %<br>-->
        <small style="font-size:60%; display:block;">{{ result.carbon.g }}g de CO2<br> par visite</small>
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

<script>

    import AnimatedNumber from "animated-number-vue";

    export default {

        name: 'result',

        components: {
          AnimatedNumber
        },

        props: ['result'],

        methods: {

            formatNumber(value) {
              return `${value.toFixed()}`;
            },

            showMore(el, event) {

              var div = $(event.target).closest('.result');

              var scrollTop     = $(window).scrollTop(),
                  scrollLeft    = $(window).scrollLeft(),
                  elementOffsetTop = $(event.target).offset().top,
                  elementOffsetLeft = $(event.target).offset().left,
                  distanceTop      = (elementOffsetTop - scrollTop),
                  distanceLeft      = (elementOffsetLeft - scrollLeft);

              this.$emit('show-more', el);

              $('.result').removeClass('active').addClass('hide');
              $('.header').addClass('hide');

              div.removeClass('hide')
                  .addClass('active')
                  .attr('data-left', distanceLeft)
                  .attr('data-top', distanceTop)
                  .css('transform', 'translate(' + (-distanceLeft + 100) + 'px, 0)')
                  .delay(1000)
                  .queue(function (next) {
                    $(this).css('transform', 'translate(' + (-distanceLeft + 100) + 'px, ' + (-distanceTop + 200) + 'px)');
                    next();
                  })
                  
            }

        }

    };

</script>