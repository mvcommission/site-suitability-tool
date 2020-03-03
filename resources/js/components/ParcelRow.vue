<template>
  <div class="row parcel_score" :data-score="calc_score_total" :data-parcel="parcel.details.loc_id">
    <div class="col-lg-2">{{parcel.map_par_id}}</div>
    <div class="col-lg-2">{{parcel.details.address}}</div>
    <div class="col-lg-2 text-right">{{formatCurrency(parcel.details.total_val)}}</div>
    <div class="col-lg-1">{{parcel.details.acres.toFixed(2)}}</div>
    <div class="col-lg-2 text-right">{{formatCurrency(calc_price_per_acre)}}</div>
    <div class="col-lg-1">{{calc_score_total}}</div>
    <div class="col-lg-1">
      <input type="checkbox" @click="addToCompare()" />
    </div>
    <div class="col-lg-1">
      <button
        class="btn btn-outline-primary btn-sm"
        @click="toggleDetails()"
        title="Toggle Details"
        :id="parcel.loc_id"
      >
        <i class="fas" v-bind:class="[isHidden == 'd-none' ? 'fa-plus' : 'fa-minus']"></i>
      </button>
    </div>
    <div class="col-lg-12 details" v-bind:class="isHidden">
      <div class="row">
        <div class="col-lg-6">
          <h6>Parcel Details</h6>
          <ul>
            <li>Bedrooms as of right: {{parcel.scores.bedrooms}}</li>
            <li>Zoning: {{parcel.details.zoning}}</li>
            <li>Loc ID: {{parcel.details.loc_id}}</li>
            <li>Total Value: {{formatCurrency(parcel.details.total_val)}}</li>
            <li>Road Surface: {{parcel.details.is_paved == 1 ? 'Paved' : 'Unpaved' }}</li>
            <li>Sewered: {{parcel.scores.sewer > 0 ? 'Y' : 'N'}}</li>
            <li>Water Protection Zone: {{parcel.details.water_supply_zone}}</li>
            <li>Watershed Condition: {{parcel.details.watershed_condition === null ? "Land draining directly into Ocean/Sound" : parcel.details.watershed_condition}}</li>
            <li>Town Water: {{parcel.scores.townwater > 0 ? 'Y' : 'N'}}</li>
            <li>{{parcel.scores.wildlife > 0 ? 'Not in ' : 'Inside '}} NHESP Priority Habitat</li>
            <li>{{parcel.scores.wetlands > 0 ? 'Not in ' : 'In '}} Wetlands</li>
            <li>{{parcel.details.bike_path == 2 ? 'Within 1/4 mile of' : parcel.scores.bike_path == 1 ? 'Within 1/2 mile of' : 'Over 1/2 mile from' }} Shared Use Path</li>
            <li>{{calc_distance_to_public_transit}} mile to Public Transportation</li>
            <li>{{calc_distance_to_business_district}} Business District</li>
          </ul>
        </div>
        <div class="col-lg-6">
          <h6>Weighted Scores</h6>
          <ul>
            <li>Bedrooms: {{calc_score_bedrooms}}</li>
            <li>Zoning: {{calc_score_zoning}}</li>
            <li>Vacant: {{calc_score_vacant}}</li>
            <li>Assessed Value: {{calc_score_assessed_value}}</li>
            <li>Not in Historic District: {{calc_score_historic_district}}</li>
            <li>Not in Overlay Zoning: {{calc_score_overlay_zoning}}</li>
            <li>Watershed Condition: {{calc_score_watershed_condition}}</li>
            <li>Sewer: {{calc_score_sewer}}</li>
            <li>Town Water: {{calc_score_townwater}}</li>
            <li>Not in NHESP Priority Habitat: {{calc_score_wildlife}}</li>
            <li>Not in Wetlands: {{calc_score_wetlands}}</li>
            <li>Proximity to Shared Use Paths: {{calc_score_bike_path}}</li>
            <li>Proximity to Public Transportation: {{calc_score_public_transit}}</li>
            <li>Proximity to Business District: {{calc_score_business_district}}</li>
          </ul>
        </div>

        <div class="row col-lg-12">
          <div class="col-lg-2">
            <strong>Owner Name</strong>
          </div>
          <div class="col-lg-4">
            <strong>Owner Address</strong>
          </div>
          <div class="col-lg-4">
            <strong>Owner City, State, Zip</strong>
          </div>
          <div class="col-lg-2">
            <strong>Unit Value</strong>
          </div>
        </div>
        <div
          v-for="(owner) in parcel.owners"
          v-bind:key="owner.owner1"
          class="owner_row row col-lg-12"
        >
          <div class="col-lg-2">{{owner.OWNER1}}</div>
          <div class="col-lg-4">{{owner.OWN_ADDR}}</div>
          <div class="col-lg-4">{{owner.OWN_CITY}}, {{owner.OWN_STATE}}</div>
          <div class="col-lg-2">{{owner.TOTAL_VAL}}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "parcel-row",

  props: {
    parcel: Object
  },

  data() {
    return {
      isHidden: "d-none",
      calcScores: {}
    };
  },

  computed: {
    calc_score_bedrooms: function() {
      return this.parcel.scores.bedrooms * this.$parent.factors.bedrooms;
    },
    calc_score_zoning: function() {
      return this.parcel.scores.zoning * (this.$parent.factors.zoning / 10);
    },
    calc_score_assessed_value: function() {
      if (this.parcel.scores.assessed_value > 0) {
        return (
          (this.parcel.scores.assessed_value *
            this.$parent.factors.assessed_value) /
          10
        );
      } else {
        return 0;
      }
    },
    calc_score_vacant: function() {
      return (this.parcel.scores.vacant * this.$parent.factors.vacant) / 10;
    },
    calc_score_historic_district: function() {
      return (
        (this.parcel.scores.historic_district *
          this.$parent.factors.historic_district) /
        10
      );
    },
    calc_score_overlay_zoning: function() {
      return (
        (this.parcel.scores.overlay_zoning *
          this.$parent.factors.overlay_zoning) /
        10
      );
    },
    calc_score_watershed_condition: function() {
      return (
        this.parcel.scores.watershed_condition *
        (this.$parent.factors.watershed_condition / 10)
      );
    },
    calc_score_sewer: function() {
      return this.parcel.scores.sewer * (this.$parent.factors.sewer / 10);
    },
    calc_score_townwater: function() {
      return (
        this.parcel.scores.townwater * (this.$parent.factors.townwater / 10)
      );
    },
    calc_score_wildlife: function() {
      return this.parcel.scores.wildlife * (this.$parent.factors.wildlife / 10);
    },
    calc_score_wetlands: function() {
      return this.parcel.scores.wetlands * (this.$parent.factors.wetlands / 10);
    },
    calc_score_bike_path: function() {
      return Math.floor(
        this.parcel.scores.bike_path * (this.$parent.factors.bike_path / 10)
      );
    },
    calc_score_public_transit: function() {
      return (
        this.parcel.scores.public_transit *
        (this.$parent.factors.public_transit / 10)
      );
    },
    calc_score_business_district: function() {
      return (
        this.parcel.scores.business_district *
        (this.$parent.factors.business_district / 10)
      );
    },
    calc_distance_to_public_transit: function() {
      if (parseFloat(this.parcel.details.public_transit) < 0.11) {
        return "Within 1/10 ";
      } else if (
        parseFloat(this.parcel.details.public_transit) < parseFloat(0.26)
      ) {
        return "Within 1/4 ";
      } else if (parseFloat(this.parcel.details.public_transit) < 0.51) {
        return "Within 1/2 ";
      } else {
        return "Over 1/2 ";
      }
    },
    calc_distance_to_business_district: function() {
      if (parseFloat(this.parcel.details.business_district) == 0) {
        return "Inside ";
      } else if (
        parseFloat(this.parcel.details.business_district) < parseFloat(0.11)
      ) {
        return "Less than 1/10 mile to ";
      } else if (parseFloat(this.parcel.details.business_district) < 0.25) {
        return "Less than 1/4 mile to ";
      } else if (parseFloat(this.parcel.details.business_district) < 0.5) {
        return "Less than 1/2 mile to ";
      } else if (parseFloat(this.parcel.details.business_district) < 0.75) {
        return "Less than 3/4 mile to ";
      } else if (parseFloat(this.parcel.details.business_district) < 1) {
        return "Less than 1 mile to ";
      } else {
        return "Over 1 mile to ";
      }
    },
    calc_score_total: function() {
      return (
        this.calc_score_bedrooms +
        this.calc_score_zoning +
        this.calc_score_vacant +
        this.calc_score_assessed_value +
        this.calc_score_historic_district +
        this.calc_score_overlay_zoning +
        this.calc_score_watershed_condition +
        this.calc_score_townwater +
        this.calc_score_wildlife +
        this.calc_score_wetlands +
        this.calc_score_sewer +
        this.calc_score_bike_path +
        this.calc_score_public_transit +
        this.calc_score_business_district
      );
    },
    calc_price_per_acre: function() {
      if (this.parcel.details.acres && this.parcel.details.acres > 0) {
        return Math.floor(
          parseFloat(this.parcel.details.total_val / this.parcel.details.acres)
        );
      }
      return 0;
    },
    total_unit_value: function() {
      let total_val = 0;
      if (this.parcel.owners) {
        this.parcel.owners.forEach(unit => {
          total_val += unit.TOTAL_VAL;
        });
      }

      return total_val;
    }
  },
  mounted() {},
  watch: {
    show: function() {
      if (this.parcel.details.loc_id == this.$parent.selectedParcel) {
        this.toggleDetails();
      }
    }
  },
  methods: {
    toggleDetails() {
      if (this.isHidden === "d-none") {
        axios
          .get(
            "/api/data/owner/" +
              this.parcel.details.loc_id +
              "/" +
              this.parcel.details.town_id
          )
          .then(response => {
            this.parcel.owners = response.data;
            this.isHidden = "d-block";
          });

        var layer = this.$parent.layers.town.getLayer(
          this.parcel.details.loc_id
        );
        layer.fireEvent("click");
        var bounds = layer.getBounds();
        if (bounds.isValid()) {
          this.$parent.map.fitBounds(bounds);
        }
      } else {
        this.isHidden = "d-none";
        var layer = this.$parent.layers.town.getLayer(
          this.parcel.details.loc_id
        );
        layer.closePopup();
        var bounds = this.$parent.layers.town.getBounds();
        if (bounds.isValid()) {
          this.$parent.map.fitBounds(bounds);
        }
      }
    },
    addToCompare() {
      this.parcel.factors = this.$parent.factors;
      this.parcel.calcScores = {
        total_score: this.calc_score_total,
        bedrooms: this.calc_score_bedrooms,
        price_per_acre: this.calc_price_per_acre,
        wetlands: this.calc_score_wetlands,
        zoning: this.calc_score_zoning,
        vacant: this.calc_score_vacant,
        assessed_value: this.calc_score_assessed_value,
        historic_district: this.calc_score_historic_district,
        overlay_zoning: this.calc_score_overlay_zoning,
        watershed_condition: this.calc_score_watershed_condition,
        townwater: this.calc_score_townwater,
        wildlife: this.calc_score_wildlife,
        sewer: this.calc_score_sewer,
        bike_path: this.calc_score_bike_path,
		public_transit: this.calc_score_public_transit,
		business_district: this.calc_score_business_district
      };
      this.$parent.compareList.push(this.parcel);
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
    }
  }
};
</script>
