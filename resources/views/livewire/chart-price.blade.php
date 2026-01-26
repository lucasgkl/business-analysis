<div class="component--chart-price">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-bar"></i>
                        Gráfico de preço
                    </h4>
                </div>
                <div class="card-body">
                    {{-- Seletor de Empresa --}}
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="companySelect" class="form-label">Selecione a Empresa:</label>
                            <select wire:model.change="companyId" id="companySelect" class="form-select">
                                <option value="">-- Selecione uma empresa --</option>
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    {{-- Container do Gráfico --}}
                    @if($companyId)
                    <div class="row">
                        <div class="col-12">
                           
                            <div id="chartContainer" style="height: 500px;">
                                <canvas id="priceChart"></canvas>
                            </div>
                        </div>
                    </div>
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

        function computeCommonRange(allArrays) {
            const flat = [].concat(...allArrays).map(toNumber);
            if (flat.length === 0) return {
                min: 0,
                max: 1000
            };
            let min = Math.min(...flat, 0);
            let max = Math.max(...flat, 0);
            if (min === max) {
                if (max === 0) {
                    max = 1000;
                    min = 0;
                } else {
                    max = max + 100;
                }
            }
            return {
                min: Math.min(Math.floor(min / 100) * 100, 0),
                max: Math.ceil(max / 100) * 100
            };
        }

        function normalizeArray(arr) {
            return (arr || []).map(toNumber);
        }

        function createChart(data) {
            const ctx = document.getElementById('priceChart');
            if (!ctx) {
                console.error('Canvas element not found');
                return;
            }

            if (chart) chart.destroy();
            if (!data.labels || data.labels.length === 0) {
                console.log('No data to display');
                return;
            }

            const lpa4anos = normalizeArray(data.lpa4anos);
            const lpa2anos = normalizeArray(data.lpa2anos);
            const dy4anos = normalizeArray(data.dy4anos);
            const dy2anos = normalizeArray(data.dy2anos);

            const range = computeCommonRange([lpa4anos, lpa2anos, dy4anos, dy2anos]);
            const stepSize = range.max < 10000 ? 10 : 100;

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                            label: 'LPA 4 anos',
                            data: lpa4anos,
                            borderColor: 'rgb(75, 192, 192)',
                            backgroundColor: 'rgba(75, 192, 192, 0.1)',
                            tension: 0.1,
                            fill: true,
                            yAxisID: 'y'
                        },
                        {
                            label: 'LPA 2 anos',
                            data: lpa2anos,
                            borderColor: 'rgb(255, 99, 132)',
                            backgroundColor: 'rgba(255, 99, 132, 0.1)',
                            tension: 0.1,
                            fill: true,
                            yAxisID: 'y'
                        },
                        {
                            label: 'DY 4 anos',
                            data: dy4anos,
                            borderColor: 'rgba(103, 252, 62, 1)',
                            backgroundColor: 'rgba(115, 228, 84, 0.47)',
                            tension: 0.1,
                            fill: true,
                            yAxisID: 'y'
                        },
                        {
                            label: ' DY 2 anos',
                            data: dy2anos,
                            borderColor: 'rgba(251, 46, 15, 0.6)',
                            backgroundColor: 'rgba(229, 117, 77, 0.6)',
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
            requestAnimationFrame(() => {
                createChart(data[0]);
            });
        });
    });
</script>
@endpush