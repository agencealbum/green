<template>
	<nav class="navbar navbar-expand-md fixed-top">
		<div class="container">
		    <div class="collapse navbar-collapse">
		        <div class="navbar-nav mr-auto">
		            <a target="_blank" href="https://www.agencealbum.com/" class="nav-item nav-link"><img src="/img/logo.png" alt="Agence Album"></a>
		        </div>
		       	<router-link to="/contact" class="nav-item nav-link">Contact</router-link>
		       	<!--<router-link to="/faq" class="nav-item nav-link">FAQ</router-link>-->
		    </div>
		</div>
	</nav>
</template>

<script>

    export default {

        name: 'navbar',

    };

</script>