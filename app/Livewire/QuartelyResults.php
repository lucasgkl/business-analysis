<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Component;
use App\Models\QuarterlyResult as Result;
use Livewire\WithPagination;


class QuartelyResults extends Component
{
    use WithPagination;
    public $id;
    public $ebitda;
    public $ebit;
    public $netIncome;
    public $grossDebt;
    public $netDebt;
    public $quarter;
    public $startDate;
    public $endDate;
    public $companyId;

    protected $rules = [

        'ebitda' => 'nullable|numeric',
        'ebit' => 'nullable|numeric',
        'netIncome' => 'nullable|numeric',
        'grossDebt' => 'nullable|numeric',
        'netDebt' => 'nullable|numeric',
        'quarter' => 'required|string',
        'startDate' => 'date',
        'endDate' => 'date',
        'companyId' => 'required|int',
    ];

    protected $messages = [
        'companyId.required' => 'O nome da empresa é obrigatório',
        'quarter.required' => 'O trimestre é obrigatório'

    ];

    public function store()
    {
        // dd(124);
        //   $this->validate();

        Result::updateOrCreate(
            ['id' => $this->id],
            [
                'ebitda' => $this->ebitda,
                'ebit' => $this->ebit,
                'net_income' => $this->netIncome,
                'gross_debt' => $this->grossDebt,
                'net_debt' => $this->netDebt,
                'quarter' => $this->quarter,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'company_id' => $this->companyId,
            ]
        );

        $this->reset(
            'ebitda',
            'ebit',
            'netIncome',
            'grossDebt',
            'netDebt',
            'quarter',
            'startDate',
            'endDate'
        );
    }

    public function setResultsModal(Result $result)
    {
        $this->id = $result->id;
        $this->ebitda = $result->ebitda;
        $this->ebit = $result->ebit;
        $this->netIncome = $result->net_income;
        $this->grossDebt = $result->gross_debt;
        $this->netDebt = $result->net_debt;
        $this->quarter = $result->quarter;
        $this->startDate = $result->start_date?->format('Y-m-d');
        $this->endDate = $result->end_date?->format('Y-m-d');
        $this->companyId = $result->company_id;
    }

    public function getResults()
    {
        $resultsQuery = Result::select(['quarterly_results.*']);

        if ($this->companyId) {
            $resultsQuery->where('quarterly_results.company_id', '=', $this->companyId);
        }

        return $resultsQuery->orderBy('quarterly_results.id', 'desc')->paginate(15);
    }
    public function setIdResultsDelete(int $id)
    {
        $this->id = $id;
    }
    public function deleteresults(Result $result)
    {
        $result->delete();
    }
    public function render()
    {
        return view(
            'livewire.quartely-results',
            [
                'results' => $this->getResults(),
                'companys' => Company::orderBy('name')->get(),
            ]
        );
    }
}
