<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Parcel;
use App\Models\OakBluff;
use App\Models\Town;

class LayerController extends Controller
{
	
	public function get_bike_network()
	{
		$data = DB::select(
			"SELECT 
			objectid as id,
		 ST_AsGeoJSON(shape) as geometry,
		 streetname,
		 phase,
		 status_con,
		 type_con
			from bike_network
			where status_con = 'existing'
			and type_con = 'designated path'
			");
			foreach ($data as $item ) {
				$item->type = "Feature";
				$item->geometry = json_decode($item->geometry);
				$item->properties = new \stdClass();
				$item->properties->info 	= "<p><strong>Street:</strong> " . ($item->streetname ? $item->streetname : '') . "<br />";
				$item->properties->info  	.= "<strong>Phase:</strong> " . $item->phase . "<br />";
				$item->properties->info 	.= "<strong>Status:</strong> " . $item->status_con . "<br />";
				$item->properties->info		.= "<strong>Type:</strong> " . strtoupper($item->type_con) . "</p>";
				unset($item->objectid);
				unset($item->streetname);
				unset($item->phase);
				unset($item->status_con);
				unset($item->type_con);
			}
			
		  return $data;
		
	}
	public function get_bus_route()
	{
		$data = DB::select(
			"SELECT 
			OGR_FID as id,
		 ST_AsGeoJSON(shape) as geometry,
		 route_num
			from bus_routes_new");
			foreach ($data as $item ) {
				
				$item->type = "Feature";
				$item->geometry = json_decode($item->geometry);
				$item->properties = new \stdClass();
				$item->properties->info = "<p><strong>Route #</strong> " . $item->route_num . "</p>";
				unset($item->route_num);
			}
		  return $data;		
	}
	
	public function get_roads()
	{
		$data = DB::select(
			"SELECT 
			OGR_FID as id,
			ST_AsGeoJSON(shape) as geometry,
			street_nam,
			road_class,
			paved
			from ferry_routes
			where ferry IS NULL");
			foreach ($data as $item ) {
				
				$item->type = "Feature";
				$item->geometry = json_decode($item->geometry);
				$item->style = new \stdClass();
				$item->style->weight = .75;
				if($item->paved == 'Y')
				{
					$item->style->color = '#666666';
				}
				else {
					$item->style->color = '#D2B48C';
				}
				$item->properties = new \stdClass();
				$item->properties->info = "<p><strong>Street:</strong> " . $item->street_nam . "<br />";
				$item->properties->info .= "<strong>Surface:</strong> " . ($item->paved == 'Y'? 'Paved' : 'Unpaved') ."</p>";
				unset($item->street_nam);
				unset($item->road_class);
				unset($item->paved);
			}
		  return $data;		
	}

	public function get_wetlands()
	{
		
		$data = DB::select(
			"SELECT 
			OGR_FID as id,
			ST_AsGeoJSON(shape) as geometry,
			it_valdesc as name
			from wetlands");
			foreach ($data as $item ) {
				
				$item->type = "Feature";
				$item->geometry = json_decode($item->geometry);
				$item->properties = new \stdClass();
				$item->properties->info = "<p>" . $item->name . "</p>";
				unset($item->name);
			}
		  return $data;		
	}
	public function get_historic($town = null)
	{
		
		$data = DB::select(
			"SELECT 
			OGR_FID as id,
			ST_AsGeoJSON(shape) as geometry,
			name
			from historic_districts");
			foreach ($data as $item ) {
				
				$item->type = "Feature";
				$item->geometry = json_decode($item->geometry);
				$item->properties = new \stdClass();
				$item->properties->info = "<p>" . $item->name . "</p>";
				unset($item->name);
			}
		  return $data;		
	}

	public function get_town_parcels($town)
	{
		if ($town == 'sample') {
			$town_id = 221;
			$limit = " limit 100";
			$town = "oakbluffs";
		}
		else {
			$town_id = DB::select("Select id from towns where short_name = '$town'");
			$town_id = $town_id[0]->id;
			$limit = " ";

		}
		
	 {
			# @TODO - break these into chunks to avoid memory issues
		$table = $town . "_parcels";
			$data = DB::select(
				"Select
					p.map_par_id,
					p.loc_id,
					ST_AsGeoJSON(p.shape) as geometry,
					p.site_addr,
					p.bldg_val,
					p.zoning,
					s.max_points as res_score,
					s.label,
					p.sewered,
					p.townwater,
					p.total_val_owners as total_val,
					p.lot_size as sqfeet,
					p.gis_acres as acres,
					p.town_id,
					udf_score_assessed_value(p.total_val_owners) as av_score,
					p.in_historic_district,
					p.in_overlay_zone,
					p.is_paved,
					p.water_supply_zone,
					p.watershed_condition_text,
					p.watershed_condition,
					p.wildlife_habitat,
					p.wetlands,
					p.owner_name,
					p.owner_street,
					p.owner_city_state_zip,
					p.score_bike_path,
					p.distance_public_transit,
					p.score_public_transit,
					p.score_business_district,
					p.distance_business_district
					from 
					
					$table p
					left outer join 
					(select max_points, label, `value` from scores where score_factor = 'residential' and town_id = $town_id) s
					on p.zoning = s.value
					where (p.poly_type = 'FEE' or p.poly_type = 'TAX') $limit");
				foreach ($data as $item ) {
					
					$item->type = "Feature";
					$item->geometry = json_decode($item->geometry);
					// $item->id = $item->id;
					$item->bldg_val = $item->bldg_val;
					$item->properties = new \stdClass();
					$item->details = new \stdClass();
					$item->scores = new \stdClass();
					$item->style = new \stdClass();
					$item->style->weight = .5;
					$item->properties->info = "<p><strong>Address</strong>: " . $item->site_addr . "<br />";
					$item->properties->info .= "<strong>Map & Lot ID</strong>: " . $item->map_par_id . "<br />";
					$item->properties->info .= "<strong>Zone Code</strong>:" . $item->zoning . "<br />";
					$item->properties->info .= "<strong>Assessed value</strong>: $" . number_format($item->total_val, 0, '.', ',') . "</p>";
					if(strpos($item->zoning, 'R') >= 0)
					{
						$isResidential = true;
					}
					if(!$item->res_score )
					{
						$item->res_score = 0;
					}
					$item->scores->zoning = $item->res_score;
					$item->scores->sewer = ($item->sewered === 'Y') ? 10 : 0; // @TODO need to check status of watershed
					$item->scores->townwater = ($item->townwater === 'Y') ? 10 : 0; // @TODO need to check proximity
					$item->scores->wildlife = ($item->wildlife_habitat === 1 ? 0 : 10);
					$item->scores->assessed_value = $item->av_score;
					$item->scores->historic_district = ($item->in_historic_district < 1 ? 10 : 0);
					$item->scores->wetlands = ($item->wetlands < 1 ? 10 : 0);
					$item->scores->bike_path = $item->score_bike_path * 5;
					$item->scores->public_transit = $item->score_public_transit;
					$item->scores->business_district = $item->score_business_district;
					
					switch ($item->in_overlay_zone) {
						case 0:
							$item->scores->overlay_zoning = 10;
							break;
						case 1:
							$item->scores->overlay_zoning = 4;
						default:
							$item->scores->overlay_zoning = 0;
							break;
					}
					switch ($item->watershed_condition) {
						case 1:
							$item->scores->watershed_condition = 2;
							break;
						case 2:
							$item->scores->watershed_condition = 8;
						default:
							$item->scores->watershed_condition = 0;
							break;
					}

					$item->style->weight = $item->scores->zoning/10;
					if($item->style->weight === 0)
					{
						$item->style->weight = 0.1;
					}
					if($isResidential)
					{
						$bedrooms = floor($item->sqfeet/10000);
						$item->scores->bedrooms = $bedrooms;
					}
					if($item->bldg_val <= 25000 && $isResidential)
					{
						$item->properties->info .= "<p><strong>Vacant Lot</strong></p>";
						$item->style->color = '#fff200';
						$item->scores->vacant = 10;
					}
					else
					{
						$item->style->color = '#dfdfd8';
						$item->properties->zoning = strpos($item->zoning, "R");
						$item->scores->vacant = 0;
					}				

					$item->details->loc_id = $item->loc_id;
					$item->details->town_id = $item->town_id;
					$item->details->address = $item->site_addr;
					$item->details->map_lot_id = $item->map_par_id;
					$item->details->zoning = $item->zoning;
					$item->details->total_val = $item->total_val;
					$item->details->acres = $item->acres;
					$item->details->is_paved = $item->is_paved;
					$item->details->water_supply_zone = $item->water_supply_zone;
					$item->details->watershed_condition = $item->watershed_condition_text;	
					$item->details->bike_path = $item->score_bike_path;		
					$item->details->public_transit = $item->distance_public_transit;	
					$item->details->business_district = $item->distance_business_district;						
				
					unset($item->town_id);
					unset($item->site_addr);
					unset($item->zoning);
					unset($item->total_val);
					// unset($item->loc_id);
				}
					
				}
		
			return $data;		
	}

	public function get_vacant_parcels($town)
	{
		$table = $town . "_parcels";
		$data = DB::select(
			"Select
				ogr_fid as id,
				ST_AsGeoJSON(shape) as geometry,
				site_addr,
				bld_area
			from $table ");
			foreach ($data as $item ) {
				$item->type = "Feature";
				$item->geometry = json_decode($item->geometry);
				$item->properties = new \stdClass();
				$item->properties->info = "<p>" . $item->site_addr . "</p>";
				$item->properties->vacant = ($item->bld_area == 0 ? true : false);
				unset($item->town_id);
				unset($item->site_addr);
				unset($item->bldg_area);
			}
			return $data;
		
	}

	public function get_zoning()
	{
		$data = DB::select(
			"Select
				objectid as id,
				ST_AsGeoJSON(shape) as geometry,
				prim_use as zone,
				zonecode,
				t.name as town
			from zoning
			inner join towns t on town_id = t.id
			");
			$colors = [
				'red'	=>	'#ff0000',
				'blue'	=>	'#005ce6', 
				'green'	=>	'#00ff00',
				'brown'	=>	'#793721',
				'gray'	=>	'#b0aeae',
				'ltblue'	=>	'#76a2d0',
				'ltgreen'	=>	'#7da955',
				'salmon'	=>	'#ff7f7f',
				'purple'	=>	'#a900e6',
				'lilac'		=>	'#e8beff',
				'bronze'	=>	'#a87000',
				'orange'	=>	'#e69800',
				'peach'		=>	'#ffd37f',
				'lemonade'	=>	'#ffffbe',
				'olive'		=>	'#a8a800',
				'cornflower' => '#9ebbd7',
				'cyan'		=>	'#00ffff',
				'pink'		=>	'#ffbebe',
				'white'		=>	'#ffffff'
			];
			$zones = [
				'GB' 	=>	$colors['blue'],
				'R5'	=> 	$colors['red'],
				'R4'	=>	$colors['red'],
				'R3'	=>	$colors['red'],
				'R2'	=>	$colors['red'],
				'R1'	=>	$colors['red'],
				'NZ'	=>	$colors['green'],
				'CP'	=>	$colors['gray'],
				'HC'	=>	$colors['brown'],
				'LB'	=>	$colors['ltblue'],
				'LI'	=>	$colors['ltblue'],
				'MU'	=>	$colors['ltblue'],
				'NZ'	=>	$colors['ltblue'],
				'RA'	=>	$colors['ltgreen']
			];
			$zonecodes = [
				'221R2'			=>	$colors['orange'],
				'221NZ'		=>	$colors['white'],
				'221R1'			=>	$colors['bronze'],
				'221B1'			=>	$colors['red'],
				'221HC'			=>	$colors['cyan'],
				'221B2'			=>	$colors['salmon'],
				'221R3'			=>	$colors['peach'],
				'221R4'			=>	$colors['lemonade'],
				'89NZ'		=>	$colors['white'],
				'89R-20'		=>	$colors['orange'],
				'89R-5'			=>	$colors['bronze'],
				'89B-III'		=>	$colors['lilac'],
				'89B-IV'		=>	$colors['purple'],
				'89R-120'		=>	$colors['olive'],
				'89B-II'		=>	$colors['salmon'],
				'89B-I'			=>	$colors['red'],
				'89R-60'		=>	$colors['peach'],
				'89RA-120'		=>	$colors['lemonade'],
				'89SW'			=>	$colors['cornflower'],
				'327MB'			=>	$colors['salmon'],
				'327LI'			=>	$colors['lilac'],
				'327VR'			=>	$colors['olive'],
				'327RU'		=>	$colors['white'],
				'327NZ'		=>	$colors['white'],
				'296R25'		=>	$colors['peach'],
				'296R50'		=>	$colors['lemonade'],
				'296NZ'		=>	$colors['white'],
				'296R10'		=>	$colors['bronze'],
				'296R3A'		=>	$colors['olive'],
				'296W/C'									=>	$colors['blue'],
				'296B1'			=>	$colors['red'],
				'296R20'		=>	$colors['orange'],
				'296B2'			=>	$colors['salmon'],
				'296LHP'		=>	$colors['blue']
			];
			foreach ($data as $item) {
				$item->type="Feature";
				$item->geometry = json_decode($item->geometry);
				$item->properties = new \stdClass();
				$item->properties->info = "<p>Town: $item->town <br />";
				$item->properties->info .= "Zone: $item->zone</p>";
				$item->style = new \stdClass();
				$item->style->color = $zonecodes[$item->zonecode];
				$item->style->weight = 1;
				if ($item->zonecode == '296W/C') {
					$item->style->fillColor = $colors['pink'];

				}
				unset($item->zone);
				unset($item->town);
			}
			return $data;
	}

	public function get_open_space()
	{
		$data = DB::select(
			"SELECT 
			OGR_FID as id,
			ST_AsGeoJSON(shape) as geometry,
			site_name as name
			from open_space");

			
			foreach ($data as $item ) {
				
				$item->type = "Feature";
				$item->geometry = json_decode($item->geometry);
				$item->properties = new \stdClass();
				$item->properties->info = "<p>" . $item->name . "</p>";
				unset($item->name);
			}
		  return $data;	
	}
	public function get_watersheds()
	{
		$data = DB::select(
			"SELECT 
			OGR_FID as id,
			ST_AsGeoJSON(shape) as geometry,
			name,
			ov_rating as `condition`
			from watershed_condition");
			// outline #005ce6;
			$conditions = [
				'Unknown' => '#e6e6e6',
				'Impaired' => '#793721',
				'Compromised' => '#ffd37f',
				'Good' => '#ffffbe'
			];
			foreach ($data as $item ) {
				
				$item->type = "Feature";
				$item->geometry = json_decode($item->geometry);
				$item->properties = new \stdClass();
				$item->properties->info = "<p>" . $item->name . "<br />Condition: "	. $item->condition . "</p>";
				$item->style = new \stdClass();
				$item->style->fillColor = $conditions[$item->condition];
				$item->style->color = '#005ce6';
				
			}
		  return $data;	
	}
	
	public function get_water_protection_zones()
	{
		$data = DB::select(
			"SELECT 
			OGR_FID as id,
			ST_AsGeoJSON(shape) as geometry,
			town,
			zone
			from h20_supply_protection");
			
			foreach ($data as $item ) {
				
				$item->type = "Feature";
				$item->geometry = json_decode($item->geometry);
				$item->properties = new \stdClass();
				$item->properties->info = "<p>" . $item->town . "<br /> "	. $item->zone . "</p>";
				$item->style = new \stdClass();
				$item->style->fillColor = '#00c5ff';
				$item->style->weight = 0;				
			}
		  return $data;	
	}

	public function get_wildlife_habitats()
	{
		$data = DB::select(
			"SELECT 
			OGR_FID as id,
			ST_AsGeoJSON(shape) as geometry
			from wildlife_protected");
			
			foreach ($data as $item ) {
				
				$item->type = "Feature";
				$item->geometry = json_decode($item->geometry);
				$item->properties = new \stdClass();
				$item->properties->info = "<p>Wildlife Habitat</p>";
				$item->style = new \stdClass();
				$item->style->fillColor = '#808000';
				$item->style->weight = 0;				
			}
		  return $data;	
	}
	public function get_owner($loc_id, $town_id)
	{
		$town = DB::select("Select short_name from towns where id = $town_id");
		$town = $town[0]->short_name;
		$table = $town . "_owners";
		$data = DB::select(
				"Select
					*
					from $table o
					where o.loc_id = '$loc_id'");
		return $data;

	}



}
