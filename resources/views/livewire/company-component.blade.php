<div class="component--company">
    <div class="row">
        <div class="d-flex justify-content-between">
            <h3 class="h-3">Empresas</h3>
            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#companyModal">
                <i class="fa-solid fa-plus"></i> Adicionar
            </button>
        </div>

    </div>


    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Tag</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companys as $company)
                <tr>
                    <td>
                        {{ $company->id}}
                    </td>
                    <td>
                        {{ $company->name }}

                    </td>
                    <td>
                        {{ $company->tag }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-dark"
                            data-bs-toggle="modal" data-bs-target="#companyModal" wire:click="setCompanyModal({{ $company->id }})">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="btn btn-outline-dark"
                            data-bs-toggle="modal" data-bs-target="#companyDelete" wire:click="setIdCompanyDelete({{ $company->id }})">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        {{ $companys->links() }}
    </div>




    <div class="modal fade" id="companyModal" tabindex="-1" aria-labelledby="companyModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="companyModalLabel">Nova empresa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <div>
                            <input type="hidden" name="id" wire:model="id">
                        </div>
                        <div class="mb-3">
                            <label for="companyName" class="col-form-label">Nome*</label>
                            <input type="text" class="form-control" id="companyName" wire:model="companyName">
                        </div>
                        <div class="mb-3">
                            <label for="tag" class="col-form-label">Tag*</label>
                            <input class="form-control" id="tag" wire:model="tag">
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

    <div class="modal fade" id="companyDelete" tabindex="-1" aria-labelledby="companyDeleteLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="companyDeleteLabel">Excluir empresa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div>
                        Deseja excluir esta empresa ?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-outline-dark" wire:click="deleteCompany({{$id}})">Salvar</button>
                </div>

            </div>
        </div>
    </div>
</div>