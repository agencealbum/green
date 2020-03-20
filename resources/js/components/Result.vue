<template>
  <div v-if="result" class="container text-center">

    <div class="results row mb-5">

      <div class="col h-100 result result-1 justify-content-center align-self-center">
        <img v-if="result.hosting > 50" src="/img/results/hosting-1.svg">
        <img v-else src="/img/results/hosting-0.svg">
        <h4>Hébergement</h4>
        <animated-number :formatValue="formatNumber" :value="result.hosting"></animated-number> %
      </div>

      <div class="col h-100 result result-2 justify-content-center align-self-center">
        <img v-if="result.performance > 50" src="/img/results/performances-1.svg">
        <img v-else src="/img/results/performances-0.svg">
        <h4>Performances</h4>
        <animated-number :formatValue="formatNumber" :value="result.performance"></animated-number> %
      </div>

      <div class="col h-100 result result-3 justify-content-center align-self-center">
        <img v-if="result.usability > 50" src="/img/results/adaptability-1.svg">
        <img v-else src="/img/results/adaptability-0.svg">
        <h4>Adaptabilité</h4>
        <animated-number :formatValue="formatNumber" :value="result.usability"></animated-number> %
      </div>

      <div class="col h-100 result result-4 justify-content-center align-self-center">
        <img v-if="result.carbon > 50" src="/img/results/carbon-1.svg">
        <img v-else src="/img/results/carbon-0.svg">
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

<script>

    import AnimatedNumber from "animated-number-vue";

    export default {

        name: 'faq',

        components: {
          AnimatedNumber
        },

        props: ['result'],

        methods: {

            formatNumber(value) {
              return `${value.toFixed()}`;
            },

        }

    }

</script>