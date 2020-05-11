<template>

    <div class="h-100">

        <!-- NAVBAR -->
        <navbar></navbar>

        <transition name="fade" mode="out-in">
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </transition>

        <div class="container footer">

	        <div class="row">

	        	<div class="col-md-12 text-right">
	        		<p>© 2020 Agence Album</p>
	        	</div>

	        </div>

	    </div>

    </div>

</template>

<script>
    export default {


    };
</script>


<style>

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .1s;
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }

</style>