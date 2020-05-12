<template>

	<div class="mh-100 d-flex align-items-center">

		<div class="container faq">

			<div class="close-more">
				<router-link to="/" class="btn">×</router-link>
			</div>

			<div class="row mb-5">

				<div class="col-md-12">

					<div v-if="validationErrors">
                        <ul class="alert alert-danger">
                            <li v-for="(value, key, index) in validationErrors">{{ value }}</li>
                        </ul>
                    </div>

					<form role="form" method="post" data-toggle="validator" @submit="sendEmail">

						<!-- URL -->
						<div class="form-group">
							<label for="url">URL</label>
							<input type="url" class="form-control" v-model="mail.url" id="url" required>
						</div>

						<!-- EMAIL -->
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control" v-model="mail.email" id="email" required>
						</div>

						<!-- TEL -->
						<div class="form-group">
							<label for="tel">Téléphone</label>
							<input type="tel" class="form-control" v-model="mail.tel" id="tel" required>
						</div>

						<!-- NOM -->
						<div class="form-group">
							<label for="name">Prénom, Nom</label>
							<input type="text" class="form-control" v-model="mail.name" id="name" required>
						</div>

						<!-- MESSAGE -->
						<div class="form-group">
							<label for="message">Message</label>
							<textarea class="form-control" v-model="mail.message" id="message" required></textarea>
						</div>


						<div v-if="success" class="alert alert-success">
							Votre message a correctement été envoyé.
						</div>

						<div v-else class="form-group">
							<button class="btn btn-lg btn-submit" type="submit">Envoyer</button>
						</div>


					</form>

				</div>

			</div>

		</div>

	</div>
	
</template>

<script>

    export default {

        name: 'contact',

        props: ['url', 'email'],

        data: function () {
            return {
                mail: {
                	url: '',
                	name: '',
                	email: '',
                	tel: '',
                	message: "",
                },
                validationErrors: false,
                success: false,
            }
        },

        methods: {


        	sendEmail(event) {

        		event.preventDefault();
        		this.validationErrors = false;
        		let vm = this;

        		axios.post('/email/send', this.mail).then(function (response) {
					if(response.status == 200) vm.success = true;
				}).catch(error => {
					console.log(error);
					if (error.response.status == 422){
						this.validationErrors = error.response.data.errors;
					}
				});

        	}

        }

    };

</script>