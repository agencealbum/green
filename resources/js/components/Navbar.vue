<template>
	<nav class="navbar navbar-expand-md fixed-top">
		<div class="container">
		    <div class="collapse navbar-collapse">
		        <div class="navbar-nav mr-auto">
		            <router-link to="/" class="nav-item nav-link">Test</router-link>
		        </div>
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