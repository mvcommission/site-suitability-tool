<div class="mb-3">
	<label for="selectedTown">Select Town: </label>
	<select class="custom-select" @change="selectTown" v-model="selectedTown" id="selectedTown" >
		<option>Select a town</option>
		<option value="edgartown">Edgartown</option>
		<option value="oakbluffs">Oak Bluffs</option>
		<option value="tisbury">Tisbury</option>
		<option value="west_tisbury">West Tisbury</option>
		<option value="sample">Sample Data</option>
	</select>
</div>

	<div class="small row border p-3">
		<div class="btn-group-vertical">
			<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#mapLayers">
				View Additional Map Layers
			</button>
			<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#mapLegend">
				View Map Legend
			</button>
			<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#filters">View Filters</button>
			<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#factors">Adjust Scoring Factors</button>
			<button type="button" class="btn" v-bind:class="[isHeatMap ? 'btn-primary' : 'btn-outline-primary']" @click="toggleHeatMap()">View Scores as Heat Map</button>			
		</div>

		<div v-if="isHeatMap" class="row mt-2">
			<div class="col-md-12 map-legend">
				<h4>Heat Map Legend</h4>
				<p>Based on Calculated Total Score</p>
				<p><span class="heat q1">&nbsp;</span> 0 - @{{heatMapscores[0]}}</p>
				<p><span class="heat q2">&nbsp;</span> @{{heatMapscores[0]+1}} - @{{heatMapscores[1]}}</p>	
				<p><span class="heat q3">&nbsp;</span> @{{heatMapscores[1]+1}} - @{{heatMapscores[2]}}</p>
				<p><span class="heat q4">&nbsp;</span> @{{heatMapscores[2]}}+</p>
			</div>
		</div>
			<div v-if="filteredParcels.length > 0" class="mt-2">
				<div class="btn-group-vertical">
					<span class="btn btn-primary"><download-excel
						:fields = "parcel_fields"
						:data   = "parcels"
						:before-generate = "prepDownload"
						>
						Download All Results
						
					</download-excel></span>
					<span class="btn btn-primary"><download-excel
						:fields = "parcel_fields"
						:data   = "filteredParcels"
						:before-generate = "prepDownload"
						>
						Download Filtered Results					
					</download-excel></span>
				</div>
			</div>
	</div>



	<div class="row mt-3">
		<h4 v-if="filteredParcels.length > 0">@{{filteredParcels.length}} Results</h4>
		<h5 v-if="parcels.length > 0 && filteredParcels.length == 0" class="text-danger">No results found. <br />Try adjusting the filters.</h5>
	</div>
		<div class="row mt-3">
			<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#comparison" v-if="compareList.length > 0">View @{{compareList.length}} Selected Parcels</button>

	</div>
