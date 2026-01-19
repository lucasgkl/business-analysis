<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Company;
use App\Models\QuarterlyResult;

class ChartResults extends Component
{
    public $companyId;
    public int $group = 0;

    public function mount() {}



    public function getResults(int $group = 0)
    {
        if (!$this->companyId) {
            return collect();
        }

        $results = QuarterlyResult::where('company_id', $this->companyId)
            ->orderBy('start_date')
            ->get();

        if ($group === 1) {
            return $results
                ->groupBy(fn($item) => $item->start_date->year)
                ->map(function ($yearResults) {
                    $last = $yearResults->last();

                    return [
                        'ebitda'     => (float) $yearResults->sum('ebitda'),
                        'ebit'       => (float) $yearResults->sum('ebit'),
                        'net_income' => (float) $yearResults->sum('net_income'),
                        'gross_debt' => (float) $last->gross_debt,
                        'net_debt'   => (float) $last->net_debt,
                    ];
                });
        }

        return $results;
    }


    public function updated($property)
    {
        if ($property === 'companyId') {
            $this->companyId = $this->companyId ? (int) $this->companyId : null;
        }

        if ($property === 'group') {
            $this->group = (int) $this->group;
        }

        $this->updateChart($this->group);
    }


    public function updateChart(int $group = 0)
    {
        $results = $this->getResults($group);

        if ($results->isEmpty()) {
            $data = [
                'labels'    => [],
                'ebitda'    => [],
                'ebit'      => [],
                'netIncome' => [],
                'db'        => [],
                'dl'        => [],
            ];
        } else {


            if ($group == 1) {
                $data = [
                    'labels' => $results->keys()->toArray(),

                    'ebitda' => $results->pluck('ebitda')->toArray(),
                    'ebit'   => $results->pluck('ebit')->toArray(),
                    'netIncome' => $results->pluck('net_income')->toArray(),

                    'db' => $results->pluck('gross_debt')->toArray(),
                    'dl' => $results->pluck('net_debt')->toArray(),
                ];
            } else {
                $data = [
                    'labels'    => $results->pluck('quarter')->toArray(),
                    'ebitda'    => $results->pluck('ebitda')->map(fn($v) => (float) $v)->toArray(),
                    'ebit'      => $results->pluck('ebit')->map(fn($v) => (float) $v)->toArray(),
                    'netIncome' => $results->pluck('net_income')->map(fn($v) => (float) $v)->toArray(),
                    'db'        => $results->pluck('gross_debt')->map(fn($v) => (float) $v)->toArray(),
                    'dl'        => $results->pluck('net_debt')->map(fn($v) => (float) $v)->toArray(),
                ];
            }
        }

        $this->dispatch('updateChart', $data);
    }


    public function render()
    {
        $results = $this->getResults();
        $companies = Company::orderBy('name')->get();


        return view('livewire.chart-results', [
            'companies' => $companies,
            'results' => $results,
            'hasResults' => $results->isNotEmpty()
        ]);
    }
}
