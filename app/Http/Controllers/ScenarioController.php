<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Parcel;
use App\Models\OakBluff;
use App\Models\Town;

class ScenarioController extends Controller
{
	
	public function compare($parcels)
	{
		$town_id = $parcels[0];
		$parcels = array_shift($parcels);
		$list = implode(', ', $parcels);
		$town = DB::select("Select short_name from towns where id = $town_id");
		$town = $town[0]->short_name;
			# @TODO - break these into chunks so avoid memory issues
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
					p.in_overlay_zone
					from 
					
					$table p
					left outer join 
					(select max_points, label, `value` from scores where score_factor = 'residential' and town_id = $town_id) s
					on p.zoning = s.value
					where (p.poly_type = 'FEE' or p.poly_type = 'TAX')
					and p.loc_id in ($list)
					");
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
					$item->scores->sewer = ($item->sewered === 'Y') ? 8 : 0; // @TODO need to check status of watershed
					$item->scores->townwater = ($item->townwater === 'Y') ? 6 : 0; // @TODO need to check proximity
					$item->scores->assessed_value = $item->av_score;
					$item->scores->historic_district = ($item->in_historic_district < 1 ? 6 : 0);
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


					
					$item->style->weight = $item->scores->zoning/10;
					if($item->style->weight === 0)
					{
						$item->style->weight = 0.1;
					}
					if($isResidential)
					{
						$bedrooms = floor($item->sqfeet/10000);
						// $item->properties->info .= "<p>Bedrooms: ".$bedrooms."</p>";
						$item->scores->bedrooms = $bedrooms;
					}
					if($item->bldg_val <= 25000 && $isResidential)
					{
						$item->properties->info .= "<p><strong>Vacant Lot</strong></p>";
						$item->style->color = '#fff200';
						$item->scores->vacant = 8;
					}
					else
					{
						$item->style->color = '#dfdfd8';
						$item->properties->zoning = strpos($item->zoning, "R");
						$item->scores->vacant = 0;
					}
					$item->scores->total = (
						$item->scores->zoning +
						$item->scores->bedrooms + 
						$item->scores->vacant +
						$item->scores->sewer +
						$item->scores->townwater
					);
				
					$item->details->loc_id = $item->loc_id;
					$item->details->town_id = $item->town_id;
					$item->details->address = $item->site_addr;
					$item->details->map_lot_id = $item->map_par_id;
					$item->details->zoning = $item->zoning;
					$item->details->total_val = $item->total_val;
					$item->details->acres = $item->acres;
				
					unset($item->town_id);
					unset($item->site_addr);
					unset($item->zoning);
					unset($item->total_val);
					// unset($item->loc_id);
					
				}
		
			return $data;
		
	}
	

}
