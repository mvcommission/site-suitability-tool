<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use App\Models\Score;

abstract class Parcel extends Model
{
	use SpatialTrait;
	protected $primaryKey = 'OGR_FID';

    protected $fillable = [
		'OGR_FID', 
		'SHAPE',
		'loc_id',
		'town_id',
		'zoning',
		'bldg_val',
		'land_val',
		'other_val',
		'total_val',
		'lot_size',
		'site_addr',
		'is_open_space',	// 
		'sewered', 	// 0 = no; 1 = yes
		'townwater',	// 0 = no; 1 = within 500'; 2 = yes
		'watershed_condition',
		'dist_to_business_district',	// (calculated) distance to town business districts
		'dist_to_sup',	// (calculated) distance to bike paths
		'dist_to_bus', 	// (calculated) distance to bus routes
		'priority_habitat', 
		'historic_district',
		'overlay_zoning', // 0 = not within any restricted zone; 1 = within non-DCPC zone; 2 = within restricted zone
		'poly_type'

	];
	
	protected $spatialFields = [
		'SHAPE'
	];
	public function town()
	{
		return $this->belongsTo('App\Models\Town');
	}

	public function score_residential()
	{
		// max score depends on town's rules
		$score = Score::where('score_factor', 'residential')->where('value', $this->zoning)->where('town_id', $this->town_id)->first();
		if($score)
		{
			return $score->max_points;
		}
		else {
			return 0;
		}
	}

	public function score_business()
	{
		// see scale for points based on distance to business district
	}
	
}
