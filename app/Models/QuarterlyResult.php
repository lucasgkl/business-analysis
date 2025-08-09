<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class QuarterlyResult
 * 
 * @property int $id
 * @property float $ebitda
 * @property float $ebit
 * @property float $net_income
 * @property float $gross_debt
 * @property float $net_debt
 * @property int $company_id
 * @property string|null $quarter
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Company $company
 *
 * @package App\Models
 */
class QuarterlyResult extends Model
{
	use SoftDeletes;
	protected $table = 'quarterly_results';

	protected $casts = [
		'ebitda' => 'float',
		'ebit' => 'float',
		'net_income' => 'float',
		'gross_debt' => 'float',
		'net_debt' => 'float',
		'company_id' => 'int',
		'start_date' => 'datetime',
		'end_date' => 'datetime'
	];

	protected $fillable = [
		'ebitda',
		'ebit',
		'net_income',
		'gross_debt',
		'net_debt',
		'company_id',
		'quarter',
		'start_date',
		'end_date'
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}
}
