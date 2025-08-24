<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Price
 * 
 * @property int $id
 * @property float|null $price_lpa4a
 * @property float|null $price_lpa2a
 * @property float|null $price_dy4a
 * @property float|null $price_dy2a
 * @property int $company_id
 * @property Carbon|null $year
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Company $company
 *
 * @package App\Models
 */
class Price extends Model
{
	use SoftDeletes;
	protected $table = 'prices';

	protected $casts = [
		'price_lpa4a' => 'float',
		'price_lpa2a' => 'float',
		'price_dy4a' => 'float',
		'price_dy2a' => 'float',
		'company_id' => 'int',
		'year' => 'int'
	];

	protected $fillable = [
		'price_lpa4a',
		'price_lpa2a',
		'price_dy4a',
		'price_dy2a',
		'company_id',
		'year'
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}
}
