<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 * 
 * @property int $id
 * @property string $name
 * @property string $tag
 * 
 * @property Collection|Price[] $prices
 * @property Collection|QuarterlyResult[] $quarterly_results
 *
 * @package App\Models
 */
class Company extends Model
{
	protected $table = 'companys';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'tag'
	];

	public function prices()
	{
		return $this->hasMany(Price::class);
	}

	public function quarterly_results()
	{
		return $this->hasMany(QuarterlyResult::class);
	}
}
