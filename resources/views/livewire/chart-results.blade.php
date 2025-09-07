<div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-bar"></i>
                        Gráfico de Resultados Trimestrais
                    </h4>
                </div>
                <div class="card-body">
                    {{-- Seletor de Empresa --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="companySelect" class="form-label">Selecione a Empresa:</label>
                            <select wire:model.live="companyId" id="companySelect" class="form-select">
                                <option value="">-- Selecione uma empresa --</option>
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            @if($hasResults)
                            <span class="badge bg-success">
                                <i class="fas fa-check"></i> {{ $results->count() }} resultado(s) encontrado(s)
                            </span>
                            @elseif($companyId)
                            <span class="badge bg-warning">
                                <i class="fas fa-exclamation-triangle"></i> Nenhum resultado encontrado
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Container do Gráfico --}}
                    @if($companyId)
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info d-flex align-items-center mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                <small><strong>Nota:</strong> Valores em milhões.</small>
                            </div>
                            <div id="chartContainer" style="height: 500px;">
                                <canvas id="resultsChart"></canvas>
                            </div>
                        </div>
                    </div>

                    @if(!$hasResults)
                    <div class="alert alert-info text-center mt-3">
                        <i class="fas fa-info-circle"></i>
                        Não há dados disponíveis para esta empresa.
                    </div>
                    @endif
                    @else
                    <div class="alert alert-secondary text-center">
                        <i class="fas fa-chart-bar fa-2x mb-3"></i>
                        <h5>Selecione uma empresa para visualizar o gráfico</h5>
                        <p class="mb-0">Escolha uma empresa no seletor acima para ver os resultados trimestrais.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let chart = null;

    function toNumber(v) {
        if (v === null || v === undefined || v === '') return 0;
        if (typeof v === 'number') return v;
        const n = Number(v);
        if (!isNaN(n)) return n;
        const clean = String(v).replace(/\./g, '').replace(',', '.');
        const n2 = Number(clean);
        return isNaN(n2) ? 0 : n2;
    }

    function normalizeArray(arr) {
        return (arr || []).map(toNumber);
    }

    function computeCommonRange(allArrays) {
        const flat = [].concat(...allArrays).map(toNumber);
        if (flat.length === 0) return { min: 0, max: 1000 };
        let min = Math.min(...flat, 0);
        let max = Math.max(...flat, 0);
        if (min === max) {
            if (max === 0) { max = 1000; min = 0; }
            else { max = max + 100; }
        }
        return {
            min: Math.min(Math.floor(min / 100) * 100, 0),
            max: Math.ceil(max / 100) * 100
        };
    }

    function createChart(data) {
        const ctx = document.getElementById('resultsChart');
        if (!ctx) {
            console.error('Canvas element not found');
            return;
        }

        if (chart) chart.destroy();
        if (!data.labels || data.labels.length === 0) {
            console.log('No data to display');
            return;
        }

        const ebitda = normalizeArray(data.ebitda);
        const ebit = normalizeArray(data.ebit);
        const netIncome = normalizeArray(data.netIncome);
        const db = normalizeArray(data.db);
        const dl = normalizeArray(data.dl);

        const range = computeCommonRange([ebitda, ebit, netIncome, db, dl]);

        // stepSize automático: 100 para valores pequenos, 1000 para grandes
        const stepSize = range.max < 10000 ? 100 : 1000;

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'EBITDA',
                        data: ebitda,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.1,
                        fill: true,
                        yAxisID: 'y'
                    },
                    {
                        label: 'EBIT',
                        data: ebit,
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        tension: 0.1,
                        fill: true,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Lucro Líquido',
                        data: netIncome,
                        borderColor: 'rgba(103, 252, 62, 1)',
                        backgroundColor: 'rgba(115, 228, 84, 0.47)',
                        tension: 0.1,
                        fill: true,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Dívida Bruta',
                        data: db,
                        borderColor: 'rgba(251, 46, 15, 0.6)',
                        backgroundColor: 'rgba(229, 117, 77, 0.6)',
                        tension: 0.1,
                        fill: false,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Dívida Líquida',
                        data: dl,
                        borderColor: 'rgba(255, 240, 102, 1)',
                        backgroundColor: 'rgba(245, 243, 84, 0.48)',
                        tension: 0.1,
                        fill: false,
                        yAxisID: 'y'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Evolução dos Resultados Trimestrais'
                    },
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                label += new Intl.NumberFormat('pt-BR', {
                                    style: 'currency',
                                    currency: 'BRL'
                                }).format(context.parsed.y);
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Trimestre'
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Valores (R$)'
                        },
                        min: range.min,
                        max: range.max,
                        ticks: {
                            stepSize: stepSize,
                            callback: function(value) {
                                return new Intl.NumberFormat('pt-BR', {
                                    style: 'currency',
                                    currency: 'BRL'
                                }).format(value);
                            }
                        }
                    }
                }
            }
        });
    }

    Livewire.on('updateChart', (data) => {
        console.log('Chart data received:', data);
        createChart(data[0]);
    });
});
</script>
@endpush
