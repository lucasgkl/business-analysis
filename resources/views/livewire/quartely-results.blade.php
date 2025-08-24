<div class="component--company">
    <div class="row">
        <div class="d-flex justify-content-between">
            <h3 class="h-3">Resultados trimestrais</h3>
            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#resultsModal">
                <i class="fa-solid fa-plus"></i> Adicionar
            </button>
        </div>

    </div>

    <div class="form-group col-6 pb-4">
        <label for="companyId" class="form-label"> Escolha a empresa:</label>
        <select id="companyId" class="form-select" wire:model.live="companyId" name="companyId">
            <option value="">---</option>

            @foreach ($companys as $company)
            <option value="{{ $company->id }}">
                {{ $company->name }}
            </option>
            @endforeach
        </select>

        @error('companyId')
        <span class="error text-danger">{{ $message }}</span>
        @enderror

    </div>

    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ebitda</th>
                    <th scope="col">Ebit</th>
                    <th scope="col">Lucro líquido</th>
                    <th scope="col">Dívida bruta</th>
                    <th scope="col">Dívida líquida</th>
                    <th scope="col">Trimestre</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr>
                    <td>
                        {{ $result->id}}
                    </td>
                    <td>
                        {{ $result->ebitda }}

                    </td>
                    <td>
                        {{ $result->ebit }}
                    </td>
                    <td>
                        {{ $result->net_income }}
                    </td>
                    <td>
                        {{ $result->gross_debt }}
                    </td>
                    <td>
                        {{ $result->net_debt }}
                    </td>
                    <td>
                        {{ $result->quarter }}
                    </td>
                    <td>
                        {{ $result->company()->first()->name }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-dark"
                            data-bs-toggle="modal" data-bs-target="#resultsModal" wire:click="setResultsModal({{ $result->id }})">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="btn btn-outline-dark"
                            data-bs-toggle="modal" data-bs-target="#resultsDelete" wire:click="setIdResultsDelete({{ $result->id }})">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        {{ $results->links() }}
    </div>




    <div class="modal fade" id="resultsModal" tabindex="-1" aria-labelledby="resultsModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="resultsModalLabel">Novo resultado</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <div>
                            <input type="hidden" name="id" wire:model="id">
                        </div>
                        <div class="mb-3">
                            <label for="ebitda" class="col-form-label">Ebitda *</label>
                            <input type="number" step="any" class="form-control" id="ebitda" wire:model="ebitda">
                        </div>
                        <div class="mb-3">
                            <label for="ebit" class="col-form-label">Ebit *</label>
                            <input type="number" step="any" class="form-control" id="ebit" wire:model="ebit">
                        </div>
                        <div class="mb-3">
                            <label for="netIncome" class="col-form-label">Lucro Líquido*</label>
                            <input type="number" step="any" class="form-control" id="netIncome" wire:model="netIncome">
                        </div>
                        <div class="mb-3">
                            <label for="grossDebt" class="col-form-label">Dívida Bruta*</label>
                            <input type="number" step="any" class="form-control" id="grossDebt" wire:model="grossDebt">
                        </div>
                        <div class="mb-3">
                            <label for="netDebt" class="col-form-label">Dívida Líquida *</label>
                            <input type="number" step="any" class="form-control" id="netDebt" wire:model="netDebt">
                        </div>
                        <div class="mb-3">
                            <label for="quarter" class="col-form-label">Trimestre *</label>
                            <input type="text" class="form-control" id="quarter" wire:model="quarter">
                        </div>

                        <div class="mb-3">
                            <label for="startDate" class="col-form-label">Data Inicial *</label>
                            <input type="date" class="form-control" id="startDate" wire:model="startDate">
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="col-form-label">Data Final *</label>
                            <input type="date" class="form-control" id="endDate" wire:model="endDate">
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="col-form-label">Empresa *</label>
                            <select class="form-select" aria-label="Default select example" wire:model="companyId">
                                <option selected>Secione a empresa *</option>
                                @foreach($companys as $company)
                                <option value="{{$company->id}}">{{$company->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-outline-dark">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resultsDelete" tabindex="-1" aria-labelledby="resultsDeleteLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="resultsDeleteLabel">Excluir resultado</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div>
                        Deseja excluir esse resultado ?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-outline-dark" wire:click="deleteresults({{$id}})">Deletar</button>
                </div>

            </div>
        </div>
    </div>
</div>