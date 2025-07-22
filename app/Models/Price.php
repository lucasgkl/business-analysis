<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Price
 * 
 * @property int $id
 * @property float|null $plpa4a
 * @property float|null $plpa2a
 * @property float|null $pdy4a
 * @property float|null $pdy2a
 * @property int $company_id
 * @property Carbon|null $year
 * 
 * @property Company $company
 *
 * @package App\Models
 */
class Price extends Model
{
	protected $table = 'prices';
	public $timestamps = false;

	protected $casts = [
		'plpa4a' => 'float',
		'plpa2a' => 'float',
		'pdy4a' => 'float',
		'pdy2a' => 'float',
		'company_id' => 'int',
		'year' => 'datetime'
	];

	protected $fillable = [
		'plpa4a',
		'plpa2a',
		'pdy4a',
		'pdy2a',
		'company_id',
		'year'
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}
}
