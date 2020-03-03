<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
	
    protected $fillable = [
		'name', 
		'short_name'
		
	];
	
	public function parcels()
	{
		return $this->hasMany('App\Models\Parcel');
	}

	public function residential_zones()
	{
		// e.g. Edgartown: R-5, R-20, R-60, R-120, RA-120
	}

	public function business_zones()
	{
		// e.g. Edgartown: B-I, B-II, B-III, B-IV
	}
}
