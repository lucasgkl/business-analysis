<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
 * 
 * @property Company $company
 *
 * @package App\Models
 */
class QuarterlyResult extends Model
{
	protected $table = 'quarterly_results';
	public $timestamps = false;

	protected $casts = [
		'ebitda' => 'float',
		'ebit' => 'float',
		'net_income' => 'float',
		'gross_debt' => 'float',
		'net_debt' => 'float',
		'company_id' => 'int'
	];

	protected $fillable = [
		'ebitda',
		'ebit',
		'net_income',
		'gross_debt',
		'net_debt',
		'company_id',
		'quarter'
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}
}
