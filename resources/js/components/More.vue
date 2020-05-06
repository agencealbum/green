<template>
	
	<section class="more">

		<div class="float-right close-more">
			<button @click="$emit('show-more', null)" class="btn">X</button>
		</div>
		
		<div v-if="about === 'hosting'" class="more-content">

			<h2>Hébergement</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dignissim libero id congue congue. Fusce volutpat interdum lectus, et facilisis nisi hendrerit sagittis. Donec ac nibh ac ex maximus aliquet a sed augue. Phasellus in justo elementum, pellentesque dolor id, vulputate mi. Nam mollis nisi in rutrum eleifend. Duis blandit ac augue id commodo. Donec sed tellus eu mauris euismod posuere. Donec commodo, ipsum quis auctor tempus, erat felis laoreet felis, vel vehicula purus leo at leo. Etiam vel lacus vitae dolor euismod ullamcorper. Proin sit amet tellus neque. Phasellus cursus vel ligula id aliquam.</p>

			<p>Donec at mollis arcu. Proin vitae risus nec mauris mollis pulvinar. Praesent congue, urna vel fringilla malesuada, ipsum velit faucibus nunc, in ultrices dolor eros ut elit. Duis sodales consequat quam nec fermentum. Phasellus quis tortor ac massa sodales viverra scelerisque in tellus. Sed ac suscipit sem. Sed eleifend vel nunc non semper. Nunc aliquam vehicula odio in rutrum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at commodo dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus at faucibus eros. Morbi eu mi luctus, eleifend ligula vitae, lobortis felis. Praesent lobortis nunc dolor, id faucibus nibh feugiat eget.</p>

		</div>

		<div v-if="about === 'performances'" class="more-content">

			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dignissim libero id congue congue. Fusce volutpat interdum lectus, et facilisis nisi hendrerit sagittis. Donec ac nibh ac ex maximus aliquet a sed augue. Phasellus in justo elementum, pellentesque dolor id, vulputate mi. Nam mollis nisi in rutrum eleifend. Duis blandit ac augue id commodo. Donec sed tellus eu mauris euismod posuere. Donec commodo, ipsum quis auctor tempus, erat felis laoreet felis, vel vehicula purus leo at leo. Etiam vel lacus vitae dolor euismod ullamcorper. Proin sit amet tellus neque. Phasellus cursus vel ligula id aliquam.</p>

			<p>Donec at mollis arcu. Proin vitae risus nec mauris mollis pulvinar. Praesent congue, urna vel fringilla malesuada, ipsum velit faucibus nunc, in ultrices dolor eros ut elit. Duis sodales consequat quam nec fermentum. Phasellus quis tortor ac massa sodales viverra scelerisque in tellus. Sed ac suscipit sem. Sed eleifend vel nunc non semper. Nunc aliquam vehicula odio in rutrum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at commodo dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus at faucibus eros. Morbi eu mi luctus, eleifend ligula vitae, lobortis felis. Praesent lobortis nunc dolor, id faucibus nibh feugiat eget.</p>

		</div>

		<div v-if="about === 'usability'" class="more-content">

			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dignissim libero id congue congue. Fusce volutpat interdum lectus, et facilisis nisi hendrerit sagittis. Donec ac nibh ac ex maximus aliquet a sed augue. Phasellus in justo elementum, pellentesque dolor id, vulputate mi. Nam mollis nisi in rutrum eleifend. Duis blandit ac augue id commodo. Donec sed tellus eu mauris euismod posuere. Donec commodo, ipsum quis auctor tempus, erat felis laoreet felis, vel vehicula purus leo at leo. Etiam vel lacus vitae dolor euismod ullamcorper. Proin sit amet tellus neque. Phasellus cursus vel ligula id aliquam.</p>

			<p>Donec at mollis arcu. Proin vitae risus nec mauris mollis pulvinar. Praesent congue, urna vel fringilla malesuada, ipsum velit faucibus nunc, in ultrices dolor eros ut elit. Duis sodales consequat quam nec fermentum. Phasellus quis tortor ac massa sodales viverra scelerisque in tellus. Sed ac suscipit sem. Sed eleifend vel nunc non semper. Nunc aliquam vehicula odio in rutrum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at commodo dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus at faucibus eros. Morbi eu mi luctus, eleifend ligula vitae, lobortis felis. Praesent lobortis nunc dolor, id faucibus nibh feugiat eget.</p>

		</div>

		<div v-if="about === 'carbon'" class="more-content">

			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dignissim libero id congue congue. Fusce volutpat interdum lectus, et facilisis nisi hendrerit sagittis. Donec ac nibh ac ex maximus aliquet a sed augue. Phasellus in justo elementum, pellentesque dolor id, vulputate mi. Nam mollis nisi in rutrum eleifend. Duis blandit ac augue id commodo. Donec sed tellus eu mauris euismod posuere. Donec commodo, ipsum quis auctor tempus, erat felis laoreet felis, vel vehicula purus leo at leo. Etiam vel lacus vitae dolor euismod ullamcorper. Proin sit amet tellus neque. Phasellus cursus vel ligula id aliquam.</p>

			<p>Donec at mollis arcu. Proin vitae risus nec mauris mollis pulvinar. Praesent congue, urna vel fringilla malesuada, ipsum velit faucibus nunc, in ultrices dolor eros ut elit. Duis sodales consequat quam nec fermentum. Phasellus quis tortor ac massa sodales viverra scelerisque in tellus. Sed ac suscipit sem. Sed eleifend vel nunc non semper. Nunc aliquam vehicula odio in rutrum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at commodo dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus at faucibus eros. Morbi eu mi luctus, eleifend ligula vitae, lobortis felis. Praesent lobortis nunc dolor, id faucibus nibh feugiat eget.</p>

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

