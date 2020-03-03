<div class="modal fade " id="filters" tabindex="3" role="dialog" aria-labelledby="Filters" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="filtersTitle">Filter Parcels</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body container-fluid">
				<div class="row" id="filters" >
					<div class="col-md-4">
						<label for="">Map & Lot ID	<input type="text" v-model="filters.map_par_id"  @input="filterMap()" class="form-control form-control-sm"></label>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="address">Address
								<input type="text" id="address" class="form-control-sm form-control" v-model="filters.address"  @input="filterMap()">
							</label>
						</div>
					</div>
					<div class="col-md-4">
						<div class="lds-spinner filtering" v-bind:class="[ isFiltering ?  'visible' : 'd-none' ]"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="road_surface">Road Surface
								<select name="road_surface" id="road_surface" v-model="filters.road_surface" @change="doFilterMap" class="form-control-sm form-control">
									<option value="0">Show All</option>
									<option value="1">Paved Roads</option>
								</select>
							</label>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="sewered">Sewer
								<select name="sewered" id="sewered" v-model="filters.sewered" @change="filterMap()" class="form-control-sm form-control">
									<option value="0">Show All</option>
									<option value="1">Sewered</option>
								</select>
							</label>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="water_supply_zone">Water Protection Zone
								<select name="water_supply_zone" id="water_supply_zone" v-model="filters.water_supply_zone" @change="filterMap()" class="form-control-sm form-control">
									<option value="">Show All</option>
									<option value="IWPA">IWPA</option>
									<option value="Zone 1">Zone 1</option>
									<option value="Zone 2">Zone 2</option>
								</select>
							</label>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="min_bedrooms">Min Bedrooms
							<select name="min_bedrooms" id="min_bedrooms" v-model="filters.min_bedrooms" @change="filterMap()" class="form-control-sm form-control">
								<option value="0">Show All</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10+</option>
							</select></label>
						</div>
					</div>
					<div class="col-lg-4">
						<label for="max_value">Max Value
							<select name="max_value" id="max_value" v-model="filters.max_value" @change="filterMap()" class="form-control-sm form-control">
								<option value="0">Show All</option>
								<option value="100000"><= $100,000</option>
								<option value="200000"><= $200,000</option>
								<option value="300000"><= $300,000</option>
								<option value="400000"><= $400,000</option>
							</select>

						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4">
						<label for="max_value">Min Acres
							<select name="min_acres" id="min_acres" v-model="filters.min_acres" @change="filterMap()" class="form-control-sm form-control">
								<option value="0">Show All</option>
								<option value="1">>= 1</option>
								<option value="2">>= 2</option>
								<option value="3">>= 3</option>
								<option value="4">>= 4</option>
								<option value="5">>= 5</option>
								<option value="6">>= 6</option>
								<option value="7">>= 7+</option>
							</select>
						</label>
					</div>

					<div class="col-lg-4">
						<label for="max_value">Max Acres
							<select name="max_acres" id="max_acres" v-model="filters.max_acres" @change="filterMap()" class="form-control-sm form-control">
								<option value="0">Show All</option>
								<option value="10"><= 10</option>
								<option value="9"><= 9</option>
								<option value="8"><= 8</option>
								<option value="7"><= 7</option>
								<option value="6"><= 6</option>
								<option value="5"><= 5</option>
								<option value="4"><= 4</option>
							</select>
						</label>
					</div>
					
				</div>	
			</div>
			<div class="modal-footer ">
				<div class="container-fluid">
					<div class="row">					
						<div class="col-lg-4">
							<button id="clearFilters" @click="clearFilters()" class="btn btn-outline-primary">Reset Filters</button> 
						</div>
						<div class="col-lg-4">&nbsp;</div>
						<div class="col-lg-4">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Apply</button>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>	
</div>

