<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
		'score_factor',
		'town_id',
		'label',
		'value',
		'max_points'
	];
}
