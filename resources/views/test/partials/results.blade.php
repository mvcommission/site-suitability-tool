<div v-bind:class="[appLoaded ? 'd-block' : 'd-hide']">
	<div class="row score_titles sticky-top">
		<div class="col-lg-2">Map & Lot ID</div>
		<div class="col-lg-2">Address</div>
		<div class="col-lg-2 text-right">Assessed Value</div>
		<div class="col-lg-1">Acres</div>
		<div class="col-lg-2 text-right">Price per Acre</div>
		<div class="col-lg-1">Score</div>
		<div class="col-lg-1">Compare</div>
		<div class="col-lg-1">Details</div>
	</div>	
	<div v-for="(parcel) in filteredParcels" :key="parcel.loc_id" class="lg-col-12 parcel_row" ref="results">
		<parcel-row :parcel="parcel" ref="parcel.loc_id">
		</parcel-row>
	</div>
</div>