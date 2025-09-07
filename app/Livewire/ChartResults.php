<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Company;
use App\Models\QuarterlyResult;

class ChartResults extends Component
{
    public $companyId;

    public function mount()
    {
        // Inicializa com a primeira empresa se nenhuma estiver selecionada
        if (!$this->companyId) {
            $firstCompany = Company::first();
            $this->companyId = $firstCompany?->id;
        }
    }

    public function getResults()
    {
        if (!$this->companyId) {
            return collect(); // Retorna coleção vazia se não houver empresa selecionada
        }

        return QuarterlyResult::where('company_id', $this->companyId)
            ->orderBy('id') // Ordena por data para sequência correta
            ->get();
    }

    public function updatedCompanyId()
    {
        $this->updateChart();
    }

    public function updateChart()
    {
        $results = $this->getResults();

        if ($results->isEmpty()) {
            // Se não há resultados, envia dados vazios
            $data = [
                'labels'    => [],
                'ebitda'    => [],
                'ebit'      => [],
                'netIncome' => [],
                'db'        => [],
                'dl'        => [],
            ];
        } else {
            $data = [
                'labels'    => $results->pluck('quarter')->toArray(),
                'ebitda'    => $results->pluck('ebitda')->map(fn($val) => $val ? (float)$val : 0)->toArray(),
                'ebit'      => $results->pluck('ebit')->map(fn($val) => $val ? (float)$val : 0)->toArray(),
                'netIncome' => $results->pluck('net_income')->map(fn($val) => $val ? (float)$val : 0)->toArray(),
                'db'        => $results->pluck('gross_debt')->map(fn($val) => $val ? (float)$val : 0)->toArray(),
                'dl'        => $results->pluck('net_debt')->map(fn($val) => $val ? (float)$val : 0)->toArray(),
            ];
        }

        $this->dispatch('updateChart', $data);
    }

    public function render()
    {
        $results = $this->getResults();
        $companies = Company::orderBy('name')->get();

        // Atualiza o gráfico quando o componente é renderizado
        if ($this->companyId) {
            $this->updateChart();
        }

        return view('livewire.chart-results', [
            'companies' => $companies,
            'results' => $results,
            'hasResults' => $results->isNotEmpty()
        ]);
    }
}