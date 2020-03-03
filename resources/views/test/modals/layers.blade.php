		
		<div class="modal fade" id="mapLayers" tabindex="-1" role="dialog" aria-labelledby="Additional Map Layers" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Map Layers</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-4">
								<div class="btn-group-vertical">
									<button id="toggleLayer" @click="toggleLayer(layers.bikeLayer)" class="btn btn-sm" v-bind:class="[ visibleLayers.includes(layers.bikeLayer) ?  'btn-primary' : 'btn-outline-primary' ]" role="button">Shared Use Paths</button>
									<button id="toggleLayer" @click="toggleLayer(layers.busLayer)" class="btn btn-sm" v-bind:class="[ visibleLayers.includes(layers.busLayer) ?  'btn-primary' : 'btn-outline-primary' ]" role="button">Bus Routes</button>
									<button id="toggleLayer" @click="toggleLayer(layers.roadsLayer)" class="btn  btn-sm" v-bind:class="[ visibleLayers.includes(layers.roadsLayer) ?  'btn-primary' : 'btn-outline-primary' ]" role="button">Roads</button>									
								</div>
							</div>	
							<div class="col-md-4">
								<div class="btn-group-vertical">
									<button id="toggleLayer" @click="toggleLayer(layers.watershedLayer)" class="btn  btn-sm" v-bind:class="[ visibleLayers.includes(layers.watershedLayer) ?  'btn-primary' : 'btn-outline-primary' ]" role="button">Pond Watershed Condition</button>
									<button id="toggleLayer" @click="toggleLayer(layers.waterSupplyProtection)" class="btn  btn-sm" v-bind:class="[ visibleLayers.includes(layers.waterSupplyProtection) ?  'btn-primary' : 'btn-outline-primary' ]" role="button">Water Supply Protection Zones</button>
									<button id="toggleLayer" @click="toggleLayer(layers.wildlifeHabitats)" class="btn  btn-sm" v-bind:class="[ visibleLayers.includes(layers.wildlifeHabitats) ?  'btn-primary' : 'btn-outline-primary' ]" role="button">Wildlife Habitats</button>	
								</div>
							</div>
							<div class="col-md-4">
								<div class="btn-group-vertical">
									<button id="toggleLayer" @click="toggleLayer(layers.wetlandsLayer)" class="btn  btn-sm" v-bind:class="[ visibleLayers.includes(layers.wetlandsLayer) ?  'btn-primary' : 'btn-outline-primary' ]">Wetlands</button>
									<button id="toggleLayer" @click="toggleLayer(layers.historicLayer)" class="btn  btn-sm" v-bind:class="[ visibleLayers.includes(layers.historicLayer) ?  'btn-primary' : 'btn-outline-primary' ]">Historic Districts</button>
									<button id="toggleLayer" @click="toggleLayer(layers.zoningLayer)" class="btn  btn-sm" v-bind:class="[ visibleLayers.includes(layers.zoningLayer) ?  'btn-primary' : 'btn-outline-primary' ]">Zoning</button>
									<button id="toggleLayer" @click="toggleLayer(layers.openSpaceLayer)" class="btn  btn-sm" v-bind:class="[ visibleLayers.includes(layers.openSpaceLayer) ?  'btn-primary' : 'btn-outline-primary' ]">Open Space</button>
								</div>								
							</div>	
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>


