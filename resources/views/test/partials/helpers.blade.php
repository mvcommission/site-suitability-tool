<div class="lds-spinner" v-bind:class="[ isLoading ?  'visible' : 'd-none' ]"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
<div class="border border-warning" v-bind:class="[ isError ? 'd-block' : 'd-none']">
		<i class="fas fa-exclamation-triangle text-warning"></i> 
		There was an error loading the data. You can try again or refresh the page. If the problem persists, please contact sue@bluegear.io 
		<button type="button" class="close" aria-label="Close" @click="dismissWarning()">
			<span aria-hidden="true">&times;</span>
		</button>
</div>