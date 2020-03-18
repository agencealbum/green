@extends('layouts.app')

@section('content')


	<div class="header">


		<div class="inner-header">

			<!-- NAVBAR -->
			<nav class="navbar-nav">

				<div class="container">
				
					<div class="row p-2">

						<div class="col-md-6 text-left">
							<img src="/img/logo.svg" alt="Agence Album">
						</div>

						<div class="col-md-6 text-right">
							FAQ
						</div>

					</div>

				</div>

			</nav>
		    
			<!-- HEADER CONTENT -->
			<div class="container mt-5">

				<scan></scan>

				<div class="row d-flex align-items-end h-100">

					<div class="col-md-6">
						<h1>Sauvez le climat</h1>
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




		<section class="ask">

			<div class="container">

				<div class="row">

					<div class="col-md-3">

					</div>

					
					<div class="col-md-3">

					</div>

					
					<div class="col-md-3">

					</div>

					
					<div class="col-md-3">

					</div>

				</div>

				<div class="row">

					<div class="col-md-12">

						<form>

							<div class="row mb-5">

								<div class="col-md-6">

									<label class="sr-only" for="inlineFormInputName2"></label>
									<input type="email" class="form-control form-control-lg mb-2 mr-sm-2" v-model="email" required placeholder="Entrez votre email">

								</div>

								<div class="col-md-6">

									<label class="sr-only" for="inlineFormInputName2"></label>
									<input type="url" class="form-control form-control-lg mb-2 mr-sm-2" v-model="url" required placeholder="Entrez l'URL de votre site">

								</div>

							</div>

							<div class="row">

								<div class="col-md-12 d-flex justify-content-center">

									<div class="btn-group">
										<button class="btn btn-lg btn-submit" type="submit">Testez maintenant</button>
										<button class="btn btn-lg btn-primary" id="headerBtn" type="button">Header</button>
										<button class="btn btn-lg btn-primary" id="moreBtn" type="button">Sidebar</button>
									</div>

								</div>

							</div>

						</form>

					</div>

				</div>

			</div>

		</section>

		<section class="more">

			<div class="float-right close-more">
				<button class="btn">X</button>
			</div>
			
			<h1>Test</h1>

		</section>


@endsection