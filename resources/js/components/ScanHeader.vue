<template>

	<div class="header">


		<div class="inner-header d-flex align-items-end mt-5">
		    
			<!-- HEADER CONTENT -->

			<div v-if="result" class="container mt-5">

				<div class="row d-flex align-items-center h-100">

					<div class="col-md-6 mb-3">
						<a :href="result.url" target="_blank">{{ result.infos.url }}</a>
						<h2>{{ result.infos.title }}</h2>
						<p class="d-none d-md-block">{{ result.infos.description }}</p>
					</div>

					<div class="col-md-3 d-flex justify-content-end">
						<donut :total="result.total"></donut>
					</div>
					<div class="col-md-3 d-none d-md-block">
						<div class="bubble">
							<p>Bravo,<br>quelques améliorations permettraient à votre site d’être au top !</p>
						</div>
					</div>

				</div>

			</div>


			<div v-else class="container">

				<div class="row d-flex align-content-center h-100">

					<div class="col-md-6 mb-3">
						<h1>Quel est l'impact de votre site sur la planète?</h1>
					</div>

					<div class="col-md-6">
						<h2>Un jour peut-être!</h2>
						<p>Un jour peut-être, le World Wide Web fonctionnera entièrement à partir d'énergies renouvelables... C’est certainement à portée de main.</p>
						<p>Pour votre site, c’est sûr, c’est à votre portée : est-il déjà au «vert»? Pour le savoir, Album a créé une application qui vous le dira. <strong>Allez, testez!</strong></p>
					</div>

				</div>

			</div>

	    </div>

	    <!--Waves Container-->
	    <div>
	        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
	            <defs>
	                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
	            </defs>
	            <g class="parallax">
	                <use xlink:href="#gentle-wave" x="48" y="7" fill="#B8E986" />
	            </g>
	        </svg>
	    </div>
	    <!--Waves end-->

	</div>

</template>


<script>

    export default {

        name: 'scan-header',

        props: ['result'],

    };

</script>