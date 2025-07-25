<div class="component--company">
    <div class="row">
        <div class="d-flex justify-content-between">
            <h3 class="h-3">Empresas</h3>
            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa-solid fa-plus"></i> Adicionar
            </button>
        </div>

    </div>




    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nova empresa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="store">
                    <div class="modal-body">

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
</div>