<div class="modal fade " id="factors" tabindex="4" role="dialog" aria-labelledby="Scoring Factors" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="factorsTitle">Scoring Factors</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body container-fluid">
				<div class="row">
					<div class="col-md-9">
						<h3>Adjust Scoring Factors
							<small class="text-muted">Maximum of 10pts</small>
						</h3>
					</div>
					<div class="col-md-3">
						<div class="lds-spinner calculating" v-bind:class="[ isCalculating ?  'visible' : 'd-none' ]"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
					</div>
				</div>	
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="zoning" name="zoning" min="0" max="10" v-model="adjust_factors.zoning">
						<span>@{{adjust_factors.zoning}}</span> 
					</div>
					<div class="col-md-6">
						<label for="zoning">Zoning Density</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="bedrooms" name="bedrooms" min="0" max="10" v-model="adjust_factors.bedrooms">
						<span>@{{adjust_factors.bedrooms}}</span> 
					</div>
					<div class="col-md-6">
						<label for="bedrooms">Pts / Bedroom</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="vacant" name="vacant" min="0" max="10" v-model="adjust_factors.vacant">
						<span>@{{adjust_factors.vacant}}</span>
					</div>
					<div class="col-md-6">
						<label for="vacant">Vacant Lot</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="assessed_value" name="assessed_value" min="0" max="10" v-model="adjust_factors.assessed_value">
						<span>@{{adjust_factors.assessed_value}}</span>
					</div>
					<div class="col-md-6">
						<label for="assessed_value">Assessed Value</label>
					</div>
				</div>	
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="historic_district" name="historic_district" min="0" max="10" v-model="adjust_factors.historic_district">
						<span>@{{adjust_factors.historic_district}}</span>
					</div>
					<div class="col-md-6">
						<label for="historic_district">Not in Historic District</label>
					</div>
				</div>	
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="overlay_zoning" name="overlay_zoning" min="0" max="10" v-model="adjust_factors.overlay_zoning">
						<span>@{{adjust_factors.overlay_zoning}}</span>
					</div>
					<div class="col-md-6">
						<label for="overlay_zoning">Not in Overlay Zoning</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="watershed_condition" name="watershed_condition" min="0" max="10" v-model="adjust_factors.watershed_condition">
						<span>@{{adjust_factors.watershed_condition}}</span>
					</div>
					<div class="col-md-6">
						<label for="watershed_condition">Watershed Condition</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="sewer" name="sewer" min="0" max="10" v-model="adjust_factors.sewer">
						<span>@{{adjust_factors.sewer}}</span>
					</div>
					<div class="col-md-6">
						<label for="sewer">Sewer</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="townwater" name="townwater" min="0" max="10" v-model="adjust_factors.townwater">
						<span>@{{adjust_factors.townwater}}</span>
					</div>
					<div class="col-md-6">
						<label for="townwater">Town Water</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="wildlife" name="wildlife" min="0" max="10" v-model="adjust_factors.wildlife">
						<span>@{{adjust_factors.wildlife}}</span>
					</div>
					<div class="col-md-6">
						<label for="wildlife">Not in NHESP Priority Habitat</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="wetlands" name="wetlands" min="0" max="10" v-model="adjust_factors.wetlands">
						<span>@{{adjust_factors.wetlands}}</span>
					</div>
					<div class="col-md-6">
						<label for="wetlands">Not in Wetlands</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="bike_path" name="bike_path" min="0" max="10" v-model="adjust_factors.bike_path">
						<span>@{{adjust_factors.bike_path}}</span>
					</div>
					<div class="col-md-6">
						<label for="bike_path">Proximity to Shared Use Path</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="public_transit" name="public_transit" min="0" max="10" v-model="adjust_factors.public_transit">
						<span>@{{adjust_factors.public_transit}}</span>
					</div>
					<div class="col-md-6">
						<label for="public_transit">Proximity to Public Transportation</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="range" id="business_district" name="business_district" min="0" max="10" v-model="adjust_factors.business_district">
						<span>@{{adjust_factors.business_district}}</span>
					</div>
					<div class="col-md-6">
						<label for="business_district">Proximity to Business District</label>
					</div>
				</div>
			</div>
			<div class="modal-footer container-fluid">
				<div class="row">
					<div class="col-md-6">
						<button class="btn btn-primary"  v-on:click="calculateScores">Calculate</button>
					</div>
					<div class="col-md-6">
						<button class="btn btn-outline-secondary" v-on:click="resetFactors">Reset Defaults</button>
					</div>
				
					<div class="col-md-12">
						<i class="fas fa-info-circle"></i> For faster results, use the filter options on the results below before adjusting and applying the score factors.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>