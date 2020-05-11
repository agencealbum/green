<template>
	
	<section class="more d-flex align-items-center">

		<div class="close-more">
			<button @click="$emit('show-more', null)" class="btn">×</button>
		</div>
		
		<div v-if="about === 'hosting'" class="more-content">

			<h2>Hébergement</h2>
			<p>Tous les hébergeurs, semble-t-il, n’ont pas encore intégré leur rôle dans la préservation de notre environnement. Si certains utilisent des énergies renouvelables, du watercooling et l’air extérieur pour refroidir... d’autres font tourner des climatisations excessivement énergivores et à énergies fossiles. Pas top!</p>

		</div>

		<div v-if="about === 'performances'" class="more-content">

			<h2>Performances</h2>
			<p>Le site est un «poids» pour l’environnement: images très lourdes, médias non optimisés, temps de chargement très longs... chaque page consomme beaucoup de ressources!Site bien pensé en amont, médias légers et code épuré, l’environnement est heureux...les utilisateurs aussi!</p>

		</div>

		<div v-if="about === 'usability'" class="more-content">

			<h2>Adaptabilité</h2>
			<p>37,4 millions de mobinautes chaque jour, le smartphone est le premierécran pour se connecter au quotidien! L’optimisation du responsive de chaque site est donc essentielle! Ergonomie peu intuitive: et le mobinaute s’agace, ouvre des pages pour rien...et consomme de l’énergie inutilement. Une bonne expérience utilisateur sur mobile et tout le monde est heureux!</p>

		</div>

		<div v-if="about === 'carbon'" class="more-content">

			<h2>Bilan carbone</h2>
			<p>Un site dégage du  carbone! Eloignement physique entre les serveurs et leurs utilisateurs –aie aie aie, mon site est en chine et mes utilisateurs principalement en France!-, poids des pages, temps de chargement,... et le carbone augmente, augmente. Pollue, pollue, pollue... Ca fait peur</p>

		</div>

	</section>
		
</template>

<script>

    export default {

        name: 'more',

        props: ['about'],

        methods: {


        }

    };

</script>

<style scoped>

	.close-more {
		position: absolute;
		top: 10vh;
		right: 10vh;
	}
	.close-more > .btn {
		font-size: 2rem;
	    overflow: hidden;
	    transition-duration: 0.8s;
	    transition-property: transform;
	}
	.close-more > .btn:hover {
	    transform: rotate(360deg);
	    -webkit-transform: rotate(360deg);
	}

</style>

