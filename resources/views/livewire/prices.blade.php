<div class="component--prices">
    <div class="row">
        <div class="d-flex justify-content-between">
            <h3 class="h-3">Preço teto</h3>
            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#pricesModal">
                <i class="fa-solid fa-plus"></i> Adicionar
            </button>
        </div>

    </div>


    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Preço LPA 4 anos</th>
                    <th scope="col">Preço LPA 2 anos</th>
                    <th scope="col">Preço DY 4 anos</th>
                    <th scope="col">Preço DY 2 anos</th>
                    <th scope="col">Ano</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prices as $price)
                <tr>
                    <td>
                        {{ $price->id}}
                    </td>
                    <td>
                        {{ $price->price_lpa4a }}

                    </td>
                    <td>
                        {{ $price->price_lpa2a }}
                    </td>
                    <td>
                        {{ $price->price_dy4a }}
                    </td>
                    <td>
                        {{ $price->price_dy2a }}
                    </td>
                    <td>
                        {{ $price->year }}
                    </td>
                    <td>
                        {{ $price->company()->first()->name }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-dark"
                            data-bs-toggle="modal" data-bs-target="#pricesModal"
                            wire:click="setPricesModal({{ $price->id }})">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="btn btn-outline-dark"
                            data-bs-toggle="modal" data-bs-target="#pricesDelete"
                            wire:click="setIdpricesDelete({{ $price->id }})">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        {{ $prices->links() }}
    </div>




    <div class="modal fade" id="pricesModal" tabindex="-1"
        aria-labelledby="pricesModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="pricesModalLabel">Novo priceado</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <div>
                            <input type="hidden" name="id" wire:model="id">
                        </div>
                        <div class="mb-3">
                            <label for="price_lpa4a" class="col-form-label">Preço lpa 4 anos *</label>
                            <input type="number" step="any" class="form-control" id="price_lpa4a" wire:model="price_lpa4a">
                        </div>
                        <div class="mb-3">
                            <label for="price_lpa2a" class="col-form-label">Preço lpa 2 anos *</label>
                            <input type="number" step="any" class="form-control" id="price_lpa2a" wire:model="price_lpa2a">
                        </div>
                        <div class="mb-3">
                            <label for="price_dy4a" class="col-form-label">Preço dy 4 anos *</label>
                            <input type="number" step="any" class="form-control" id="price_dy4a" wire:model="price_dy4a">
                        </div>
                        <div class="mb-3">
                            <label for="price_dy2a" class="col-form-label">Preço dy 2 anos *</label>
                            <input type="number" step="any" class="form-control" id="price_dy2a" wire:model="price_dy2a">
                        </div>
                        <div class="mb-3">
                            <label for="year" class="col-form-label">Ano *</label>
                            <input type="number" step="any" class="form-control" id="year" wire:model="year">
                        </div>

                        <div class="mb-3">
                            <label for="endDate" class="col-form-label">Empresa *</label>
                            <select class="form-select" aria-label="Default select example" wire:model="company_id">
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

    <div class="modal fade" id="pricesDelete" tabindex="-1" aria-labelledby="pricesDeleteLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="
                    pricesDeleteLabel">Excluir resultado</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div>
                        Deseja excluir esse resultado ?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-outline-dark" wire:click="deletePrices({{$id}})">Deletar</button>
                </div>

            </div>
        </div>
    </div>
</div>