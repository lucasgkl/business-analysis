<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Company
 * 
 * @property int $id
 * @property string $name
 * @property string $tag
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Price[] $prices
 * @property Collection|QuarterlyResult[] $quarterly_results
 *
 * @package App\Models
 */
class Company extends Model
{
	use SoftDeletes;
	protected $table = 'companys';

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
