require("./bootstrap");
import Vue from "vue";
import Vuex from "vuex";
import JsonExcel from "vue-json-excel";

Vue.component("downloadExcel", JsonExcel);

Vue.use(Vuex);

import ParcelRow from "./components/ParcelRow";
import bugsnag from "@bugsnag/js";
import bugsnagVue from "@bugsnag/plugin-vue";

const bugsnagClient = bugsnag("54a9c79e6b4ac780a518ea149e9a5ea3");
bugsnagClient.use(bugsnagVue, Vue);

new Vue({
    el: "#app",
    data: {
        map: null,
        tileLayer: null,
        isHeatMap: false,
        filters: {
            map_par_id: "",
            address: "",
            min_bedrooms: 0,
            sewered: 0,
            max_value: 0,
            min_acres: 0,
            max_acres: 0,
            road_surface: 0,
            water_supply_zone: ""
        },
        layers: [
            {
                bikeLayer: {},
                busLayer: {},
                roadsLayer: {},
                wetlandsLayer: {},
                historicLayer: {},
                town: {},
                zoningLayer: {},
                openSpaceLayer: {},
                watershedLayer: {},
                waterSupplyProtection: {},
                wildlifeHabitats: {}
            }
        ],
        sort: "total",
        visibleLayers: [],
        minBedrooms: 0,
        baselayer: {},
        overlays: {},
        parcels: [
            {
                id: "",
                address: "",
                owners: [
                    {
                        owner1: "Owner Name"
                    }
                ],
                scores: {
                    zoning: 0,
                    transit: 0,
                    size: 0,
                    vacant: 0,
                    historic: 0,
                    wetlands: 0,
                    overlay: 0,
                    wildlife: 0,
                    water: 0,
                    sewer: 0,
                    watershed: 0,
                    bedrooms: 0,
                    wildlife: 0,
                    bike_path: 0,
                    public_transit: 0,
                    business_district: 0
                },
                details: {
                    location_id: "",
                    zoning: "",
                    total_val: "",
                    address: "",
                    acres: 0,
                    distance_business_district: 0
                },
                geometry: {},
                type: "",
                properties: {}
            }
        ],
        isLoading: false,
        isCalculating: false,
        isFiltering: false,
        isError: false,
        appLoaded: false,
        selectedTown: "",
        heatMapscores: [],
        factors: {
            zoning: 5,
            business: 5,
            bedrooms: 5,
            vacant: 5,
            assessed_value: 5,
            historic_district: 5,
            overlay_zoning: 5,
            watershed_condition: 5,
            sewer: 5,
            townwater: 5,
            wildlife: 5,
            wetlands: 5,
            bike_path: 5,
            public_transit: 5,
            business_district: 5
        },
        adjust_factors: {
            zoning: 5,
            business: 5,
            bedrooms: 5,
            vacant: 5,
            assessed_value: 5,
            historic_district: 5,
            overlay_zoning: 5,
            watershed_condition: 5,
            sewer: 5,
            townwater: 5,
            wildlife: 5,
            wetlands: 5,
            bike_path: 5,
            public_transit: 5,
            business_district: 5
        },
        default_factors: {
            zoning: 5,
            business: 5,
            bedrooms: 5,
            vacant: 5,
            assessed_value: 5,
            historic_district: 5,
            overlay_zoning: 5,
            watershed_condition: 5,
            sewer: 5,
            townwater: 5,
            wildlife: 5,
            wetlands: 5,
            bike_path: 5,
            public_transit: 5,
            business_district: 5
        },
        compareList: [],
        parcel_fields: {
            "Map Parcel ID": "map_par_id",
            Loc_ID: "loc_id",
            "Street Address": "details.address",
            "Assessed Value": "details.total_val",
            "Lot Size (sqft)": "sqfeet",
            "Lot Size (acres)": "acres",
            Zoning: "label",
            "Paved Road": {
                field: "is_paved",
                callback: value => {
                    if (value == "1") {
                        return `Yes`;
                    } else {
                        return "No";
                    }
                }
            },
            "In Historic District": {
                field: "in_historic_district",
                callback: value => {
                    if (value == "1") {
                        return `Yes`;
                    } else {
                        return "No";
                    }
                }
            },
            "In Wetlands": {
                field: "in_wetlands",
                callback: value => {
                    if (value == "1") {
                        return `Yes`;
                    } else {
                        return "No";
                    }
                }
            },
            "In Overlay Zone": {
                field: "in_overlay_zone",
                callback: value => {
                    if (value == "0") {
                        return `None`;
                    } else if (value == "1") {
                        return "Non-DCPC Zone";
                    } else {
                        return "DCPC Zone";
                    }
                }
            },
            "Town Water": {
                field: "townwater",
                callback: value => {
                    if (value == "Y") {
                        return `Yes`;
                    } else {
                        return "No";
                    }
                }
            },
            Sewered: {
                field: "sewered",
                callback: value => {
                    if (value == "Y") {
                        return `Yes`;
                    } else {
                        return "No";
                    }
                }
            },
            "Water Protection Zone": {
                field: "water_supply_zone",
                callback: value => {
                    if (value == "") {
                        return `No`;
                    } else {
                        return value;
                    }
                }
            },
            "NHESP Priority Habitat": {
                field: "wildlife_habitat",
                callback: value => {
                    if (value == 0) {
                        return `No`;
                    } else {
                        return "Yes";
                    }
                }
            },
            "Watershed Condition": "watershed_condition_text",
            "Bedroom Score": {
                field: "scores",
                callback: value => {
                    return value.bedrooms * value.factors.bedrooms;
                }
            },
            "Zoning Score": {
                field: "scores",
                callback: value => {
                    return (value.zoning * value.factors.zoning) / 10;
                }
            },
            "Assessed Value Score": {
                field: "scores",
                callback: value => {
                    return (
                        (value.assessed_value * value.factors.assessed_value) /
                        10
                    );
                }
            },
            "Vacant Score": {
                field: "scores",
                callback: value => {
                    return (value.vacant * value.factors.vacant) / 10;
                }
            },
            "Historic District Score": {
                field: "scores",
                callback: value => {
                    return (
                        (value.historic_district *
                            value.factors.historic_district) /
                        10
                    );
                }
            },
            "Wetlands Score": {
                field: "scores",
                callback: value => {
                    return (value.wetlands * value.factors.wetlands) / 10;
                }
            },
            "Overlay Zone Score": {
                field: "scores",
                callback: value => {
                    return (
                        (value.overlay_zoning * value.factors.overlay_zoning) /
                        10
                    );
                }
            },
            "Watershed Condition Score": {
                field: "scores",
                callback: value => {
                    return (
                        (value.watershed_condition *
                            value.factors.watershed_condition) /
                        10
                    );
                }
            },
            "Sewer Score": {
                field: "scores",
                callback: value => {
                    return (value.sewer * value.factors.sewer) / 10;
                }
            },
            "Townwater Score": {
                field: "scores",
                callback: value => {
                    return (value.townwater * value.factors.townwater) / 10;
                }
            },
            "Wildlife Habitat Score": {
                field: "scores",
                callback: value => {
                    return (value.wildlife * value.factors.wildlife) / 10;
                }
            },
            "Proximity to Shared Use Path Score": {
                field: "scores",
                callback: value => {
                    return (value.bike_path * value.factors.bike_path) / 10;
                }
            },
            "Proximity to Public Transportation": {
                field: "scores",
                callback: value => {
                    return (
                        (value.public_transit * value.factors.public_transit) /
                        10
                    );
                }
            },
            "Proximity to Business District": {
                field: "scores",
                callback: value => {
                    return (
                        (value.business_district *
                            value.factors.business_district) /
                        10
                    );
                }
            },

            "Owner Name": "owner_name",
            "Owner Street": "owner_street",
            "Owner City, State, Zip": "owner_city_state_zip"
        }
    },
    components: {
        ParcelRow
    },
    mounted() {
        this.parcels.length = 0;
        self = this;
        this.initMap();
        this.initLayers();
        this.appLoaded = true;
    },
    computed: {
        sortedParcels: function() {
            if (this.sort == "total") {
                return this.filteredParcels.sort(function(a, b) {
                    return b.calc_score_total > a.calc_score_total ? 1 : -1;
                });
            } else {
                return;
            }
        },
        filteredIds: function() {
            return [
                ...new Set(this.filteredParcels.map(parcel => parcel.loc_id))
            ];
        },
        filteredParcels: function() {
            let self = this;
            return _.filter(self.parcels, function(a) {
                return (
                    a.map_par_id &&
                    a.map_par_id
                        .toLowerCase()
                        .includes(self.filters.map_par_id.toLowerCase()) &&
                    (a.details.address
                        ? a.details.address
                              .toLowerCase()
                              .includes(self.filters.address.toLowerCase())
                        : true) &&
                    a.scores.bedrooms >= self.filters.min_bedrooms &&
                    a.scores.sewer >= self.filters.sewered &&
                    a.details.is_paved >= self.filters.road_surface &&
                    (self.filters.water_supply_zone !== ""
                        ? a.details.water_supply_zone ==
                          self.filters.water_supply_zone
                        : true) &&
                    (self.filters.max_value > 0
                        ? parseInt(a.details.total_val) <=
                          parseInt(self.filters.max_value)
                        : parseInt(a.details.total_val) >=
                          parseInt(self.filters.max_value)) &&
                    a.details.acres >= self.filters.min_acres &&
                    (self.filters.max_acres > 0
                        ? a.details.acres <= self.filters.max_acres
                        : true)
                );
            });
        }
    },
    methods: {
        initMap() {
            this.map = L.map("map", {
                center: [41.389, -70.627],
                zoom: 12
            });

            this.tileLayer = L.tileLayer(
                // mapbox://styles/bluegearsue/cjx403kbpbujc1ctdy6gdv50o
                // "https://api.mapbox.com/styles/v1/bluegearsue/cjx403kbpbujc1ctdy6gdv50o/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYmx1ZWdlYXJzdWUiLCJhIjoiY2praW5rOXR2MDJiNzNxbXVseWkwZHhwciJ9.kKJIS2GWV6hB0bwK_mBEXg",
                // "https://api.mapbox.com/styles/v1/bluegearsue/cjkioh1gg0bip2rlx2lqx9pae/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYmx1ZWdlYXJzdWUiLCJhIjoiY2praW5rOXR2MDJiNzNxbXVseWkwZHhwciJ9.kKJIS2GWV6hB0bwK_mBEXg",
                "https://api.mapbox.com/styles/v1/bluegearsue/ck2m2h4pa01yv1cug5kkpaucd/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYmx1ZWdlYXJzdWUiLCJhIjoiY2praW5rOXR2MDJiNzNxbXVseWkwZHhwciJ9.kKJIS2GWV6hB0bwK_mBEXg",
                {
                    minZoom: 10,
                    maxZoom: 18,
                    attribution:
                        "Built by bluegear labs for Martha's Vineyard Commission"
                }
            );
            this.tileLayer.addTo(this.map);
        },
        initLayers() {
            axios.get("/api/data/bike_network").then(function(response) {
                self.layers.bikeLayer = L.geoJSON(response.data, {
                    style: { color: "#ffff00" },
                    onEachFeature: self.onEachFeature
                });
            });
            axios.get("/api/data/bus_route").then(response => {
                self.layers.busLayer = L.geoJSON(response.data, {
                    style: { color: "#c500ff", weight: 1 },
                    onEachFeature: self.onEachFeature
                });
            });
            axios.get("/api/data/roads").then(response => {
                self.layers.roadsLayer = L.geoJSON(response.data, {
                    style: function(feature) {
                        return feature.style;
                    },
                    onEachFeature: self.onEachFeature
                });
            });
            axios.get("/api/data/wetlands").then(response => {
                self.layers.wetlandsLayer = L.geoJSON(response.data, {
                    style: { color: "#00ffc5", weight: 1 },
                    onEachFeature: self.onEachFeature
                });
            });
            axios.get("/api/data/historic").then(response => {
                self.layers.historicLayer = L.geoJSON(response.data, {
                    style: {
                        color: "#ffff00",
                        fillColor: "#df73ff"
                    },
                    onEachFeature: self.onEachFeature
                });
            });
            axios.get("/api/data/zoning").then(response => {
                self.layers.zoningLayer = L.geoJSON(response.data, {
                    style: function(feature) {
                        return feature.style;
                    },
                    onEachFeature: self.onEachFeature
                });
            });
            axios.get("/api/data/open").then(response => {
                self.layers.openSpaceLayer = L.geoJSON(response.data, {
                    style: {
                        color: "#38a807",
                        fillColor: "#ffd37f",
                        weight: 1
                    },
                    onEachFeature: self.onEachFeature
                });
            });
            axios.get("/api/data/watershed").then(response => {
                self.layers.watershedLayer = L.geoJSON(response.data, {
                    style: function(feature) {
                        return feature.style;
                    },
                    onEachFeature: self.onEachFeature
                });
            });
            axios
                .get("/api/data/water_supply_protection_zones")
                .then(response => {
                    self.layers.waterSupplyProtection = L.geoJSON(
                        response.data,
                        {
                            style: function(feature) {
                                return feature.style;
                            },
                            onEachFeature: self.onEachFeature
                        }
                    );
                });
            axios.get("/api/data/wildlife_habitats").then(response => {
                self.layers.wildlifeHabitats = L.geoJSON(response.data, {
                    style: function(feature) {
                        return feature.style;
                    },
                    onEachFeature: self.onEachFeature
                });
            });
        },
        onEachFeature(feature, layer) {
            if (feature.properties) {
                layer.bindPopup(feature.properties.info);
            }
        },
        onEachFeatureTown(feature, layer) {
            let self = this;
            if (feature.properties) {
                layer.bindPopup(feature.properties.info);
                layer.on({
                    click: function(e) {
                        var selectedParcel = e.target.feature.loc_id;
                        this.setStyle({
                            color: "#ff0000"
                        });
                        document.getElementById(selectedParcel).click();
                    },
                    popupclose: function(e) {
                        var selectedParcel = e.target.feature.loc_id;
                        this.setStyle({
                            color: this.feature.style.color
                        });
                        document.getElementById(selectedParcel).click();
                    }
                });
                layer._leaflet_id = feature.loc_id;
            }
            this.parcels.push(feature);
        },
        toggleLayer(layer) {
            if (self.map.hasLayer(layer)) {
                self.map.removeLayer(layer);
                self.visibleLayers.splice(self.visibleLayers.indexOf(layer), 1);
            } else {
                self.map.addLayer(layer);
                self.visibleLayers.push(layer);
            }
        },
        selectTown(town) {
            this.isHeatMap = false;
            this.isLoading = true;

            if (this.map.hasLayer(this.layers.town)) {
                this.map.removeLayer(this.layers.town);
            }
            this.parcels.length = 0;

            axios
                .get("/api/data/town/" + this.selectedTown)
                .then(response => {
                    self.layers.town = L.geoJSON(response.data, {
                        style: function(feature) {
                            if (feature.scores.bedrooms < self.minBedrooms) {
                                feature.style.color = "#fefefe";
                            }
                            return feature.style;
                        },
                        onEachFeature: this.onEachFeatureTown
                    }).addTo(this.map);
                    var bounds = self.layers.town.getBounds();
                    if (bounds.isValid()) {
                        self.map.fitBounds(bounds);
                    }
                    self.isLoading = false;
                })
                .catch(error => {
                    console.log("selected town: ", this.selectedTown);
                    console.log(error);
                    self.isError = true;
                    self.isLoading = false;
                    bugsnagClient.notify(new Error(error));
                });
        },
        setSort(factor) {
            this.sort = factor;
        },

        clearFilters() {
            let self = this;
            this.isLoading = true;
            self.filters.address = "";
            self.filters.map_par_id = "";
            self.filters.min_bedrooms = 0;
            self.filters.max_value = 0;
            self.filters.min_acres = 0;
            self.filters.max_acres = 0;
            self.filters.road_surface = "";
            self.filters.water_supply_zone = "";
            self.filters.sewered = "";
            self.filterMap();
            this.$nextTick(function() {
                this.isLoading = false;
            });
        },

        filterMap() {
            let self = this;
            self.isFiltering = true;

            setTimeout(function() {
                self.isFiltering = false;
            }, 1500);
            this.doFilterMap();
        },

        doFilterMap() {
            let self = this;
            if (self.layers.town) {
                self.layers.town.eachLayer(function(layer) {
                    if (
                        !self.filteredIds.includes(layer.feature.details.loc_id)
                    ) {
                        layer.setStyle({
                            fillOpacity: 0
                        });
                    } else {
                        var opacity = 0;
                        // opacity = document.getElementById(layer.feature.details.loc_id).
                        layer.setStyle({
                            fillOpacity: 0.2
                        });
                    }
                });
            }
        },
        toggleHeatMap() {
            let self = this;
            if (self.isHeatMap == true) {
                // change all the parcels back to their original color and turn off the heat map
                self.layers.town.eachLayer(function(layer) {
                    layer.setStyle({
                        color: layer.feature.style.color,
                        fillOpacity: 0.2
                    });
                });
                self.isHeatMap = false;
            } else {
                self.isHeatMap = true;
                var quadrants = Array();
                var heatColors = Array();
                // need to get the highest and lowest scores, and then use those to break into quadrants

                heatColors = ["#ffff00", "#FFA500", "#ff0000", "#800000"];
                var scores = Array();
                self.$refs.results.forEach(element => {
                    scores.push(parseInt(element.children[0].dataset.score));
                });

                scores.sort((a, b) => a - b);
                var lowScore = scores[0];
                var highScore = scores[scores.length - 1];
                var diff = highScore - lowScore;
                var chunk = parseInt(diff / 4);
                quadrants[0] = lowScore + chunk;
                quadrants[1] = lowScore + chunk * 2;
                quadrants[2] = lowScore + chunk * 3;
                quadrants[3] = lowScore + chunk * 4; // this should equal the high score
                self.heatMapscores = quadrants;
                self.$refs.results.forEach(element => {
                    var score = element.children[0].dataset.score;
                    var parcel = element.children[0].dataset.parcel;
                    var layer = self.layers.town.getLayer(parcel);
                    if (score < quadrants[0]) {
                        layer.setStyle({
                            color: heatColors[0],
                            fillOpacity: 0.5
                        });
                    } else if (score < quadrants[1]) {
                        layer.setStyle({
                            color: heatColors[1],
                            fillOpacity: 0.5
                        });
                    } else if (score < quadrants[2]) {
                        layer.setStyle({
                            color: heatColors[2],
                            fillOpacity: 0.5
                        });
                    } else {
                        layer.setStyle({
                            color: heatColors[3],
                            fillOpacity: 0.5
                        });
                    }
                });
            }
        },

        calculateScores() {
            let self = this;
            self.isCalculating = true;

            setTimeout(function() {
                self.isCalculating = false;
            }, 1500);

            this.factors = _.cloneDeep(this.adjust_factors);
        },
        resetFactors() {
            let self = this;
            self.isCalculating = true;

            setTimeout(function() {
                self.isCalculating = false;
            }, 1500);
            this.adjust_factors = _.cloneDeep(this.default_factors);
        },
        dismissWarning() {
            this.isError = false;
        },
        formatCurrency(numberValue) {
            if (numberValue && numberValue > 0) {
                return numberValue.toLocaleString("en-US", {
                    style: "currency",
                    currency: "USD",
                    minimumFractionDigits: 0
                });
            } else {
                return "$0";
            }
        },

        prepDownload() {
            this.parcels.forEach(element => {
                element.scores.factors = this.factors;
            });
        }
    }
});
