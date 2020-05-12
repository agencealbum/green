<template>
	<nav class="navbar navbar-expand-md fixed-top">
		<div class="container">
		    <div class="collapse navbar-collapse">
		        <div class="navbar-nav mr-auto">
		            <router-link to="/" class="nav-item nav-link"><img src="/img/logo.png" alt="Agence Album"></router-link>
		        </div>
		       	<router-link to="/contact" class="nav-item nav-link">Contact</router-link>
		       	<router-link to="/faq" class="nav-item nav-link">FAQ</router-link>
		    </div>
		</div>
	</nav>
</template>

<script>

    export default {

        name: 'navbar',

    }

</script>