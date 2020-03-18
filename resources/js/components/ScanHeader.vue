<template>

	<div class="header">


		<div class="inner-header d-flex align-items-end">
		    
			<!-- HEADER CONTENT -->

			<div v-if="result" class="container mt-5">

				<div class="row d-flex align-items-end h-100">

					<div class="col-md-6">
						<small>{{ result.url }}</small>
						<h2>{{ result.title }}</h2>
						<p>{{ result.tags.description }}</p>
					</div>

					<div class="col-md-6">
						Score total : {{ total }} %
					</div>

				</div>

			</div>


			<div v-else class="container">

				<div class="row d-flex align-items-end h-100">

					<div class="col-md-6">
						<h1>Sauvez<br> le climat</h1>
					</div>

					<div class="col-md-6">
						<h2>Make your website green and sustainable.</h2>
						<p>L’Agence Album believes that your website can become sustainable and green. Test it now and find out how to apply sustainable and green web technology patterns for your website. </p>
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

        props: ['result', 'total'],

    }

</script>