<div class="modal fade " id="comparison" tabindex="6" role="dialog" aria-labelledby="Comparison" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-scrollable" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="comparisonTitle">Selected Parcels</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body container-fluid">
					<table class="table">
						<tr class="score_titles sticky-top">
							<th>Map & Lot ID</th>
							<th>Address</th>
							<th>Assessed Value</th>
							<th>Acres</th>
							<th>Price per Acre</th>
							<th>Bedrooms</th>
							<th>Wetlands</th>
							<th>Watershed Condition</th>
							<th>Town Water</th>
							<th>Sewer</th>
							<th>Zoning</th>
							<th>Vacant</th>
							<th>Historic</th>
							<th>Overlay Zoning</th>
							<th>Proximity to Shared Use Paths</th>
							<th>Proximity to Public Transit</th>
							<th>Proximity to Business District</th>
							<th>Total Score</th>
						</tr>
					<tr v-for="each in compareList" :key="each.loc_id" class=" parcel_row" >						
						<td>@{{each.map_par_id}}</td>
						<td>@{{each.details.address}}</td>
						<td>@{{formatCurrency(each.details.total_val)}}</td>
						<td>@{{each.details.acres.toFixed(2)}}</td>
						<td>@{{formatCurrency(each.calcScores.price_per_acre)}}</td>
						<td>@{{each.calcScores.bedrooms}}</td>
						<td>@{{each.calcScores.wetlands}}</td>
						<td>@{{each.calcScores.watershed_condition}}</td>
						<td>@{{each.calcScores.townwater}}</td>
						<td>@{{each.calcScores.sewer}}</td>
						<td>@{{each.calcScores.zoning}}</td>
						<td>@{{each.calcScores.vacant}}</td>
						<td>@{{each.calcScores.historic_district}}</td>
						<td>@{{each.calcScores.overlay_zoning}}</td>
						<td>@{{each.calcScores.bike_path}}</td>
						<td>@{{each.calcScores.public_transit}}</td>
						<td>@{{each.calcScores.business_district}}</td>
						<td>@{{each.calcScores.total_score}}</td>
        {{-- 
        wildlife: this.calc_score_wildlife, --}}
		</tr>
					</table>
			</div>
			<div class="modal-footer">
				<div class="container-fluid">
				<div class="row">										
					<div class="col-lg-4">
						<span class="btn btn-primary">
							<download-excel
								:fields = "parcel_fields"
								:data   = "compareList"
								:before-generate = "prepDownload"
								>
							Download Comparison
							</download-excel>
						</span>
					</div>
					<div class="col-lg-4">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					</div>
				</div>
				</div>
				
			</div>
		</div>
	</div>	
</div>