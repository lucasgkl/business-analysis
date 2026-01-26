<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\Price;
use Livewire\Component;

class ChartPrice extends Component
{
    public $prices;
    public $companyId;

    public function getPrices()
    {
        if (!$this->companyId) {
            return collect();
        }

        return Price::where('company_id', $this->companyId)->orderBy('year', 'asc')->get();
    }

    public function updated($property)
    {
        if ($property === 'companyId') {
            $this->companyId = $this->companyId ? (int) $this->companyId : null;
        }

        $this->updateChart();
    }

    public function updateChart()
    {
        $results = $this->getPrices();

        if ($results->isEmpty()) {
            $data = [
                'labels' => [],
                'lpa4anos'    => [],
                'lpa2anos'    => [],
                'dy4anos'      => [],
                'dy2anos' => [],

            ];
        } else {
            $data = [
                'labels' => $results->pluck('year')->toArray(),
                'lpa4anos'    => $results->pluck('price_lpa4a')->toArray(),
                'lpa2anos'    => $results->pluck('price_lpa2a')->map(fn($v) => (float) $v)->toArray(),
                'dy4anos'      => $results->pluck('price_dy4a')->map(fn($v) => (float) $v)->toArray(),
                'dy2anos' => $results->pluck('price_dy2a')->map(fn($v) => (float) $v)->toArray(),

            ];
        }


        $this->dispatch('updateChart', $data);
    }


    public function getCompanies()
    {
        return Company::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.chart-price', [
            'results' => $this->getPrices(),
            'companies' => $this->getCompanies(),
        ]);
    }
}
