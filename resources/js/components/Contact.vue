<template>

	<div class="mh-100 d-flex align-items-center">

		<div class="container faq">

			<div class="row mb-5">

				<div class="col-md-12">

					<form role="form" method="post" data-toggle="validator">

						<!-- URL -->
						<div class="form-group">
							<label for="url">URL</label>
							<input type="url" class="form-control" v-model="mail.url" id="url" required>
						</div>

						<!-- EMAIL -->
						<div class="form-group">
							<label for="email">Votre adresse email</label>
							<input type="email" class="form-control" v-model="mail.email" id="email" required>
						</div>

						<!-- TEL -->
						<div class="form-group">
							<label for="tel">Votre adresse email</label>
							<input type="tel" class="form-control" v-model="mail.tel" id="tel">
						</div>

						<!-- MESSAGE -->
						<div class="form-group">
							<label for="message">Message</label>
							<textarea class="form-control" v-model="mail.message" id="message" required></textarea>
						</div>


						<div class="form-group">
							<button class="btn btn-lg btn-submit" type="submit">Je veux optimier mon site</button>
						</div>


					</form>

				</div>

			</div>

		</div>

	</div>
	
</template>

<script>

    export default {

        data: function () {
            return {
                mail: {
                	url: '',
                	email: '',
                	tel: '',
                	message: "Bonjour,\nJe souhaiterais avoir plus d'informations concernant l'optimisation de mon site.",
                },
            }
        },

        name: 'contact',

    }

</script>