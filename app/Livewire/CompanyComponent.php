<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Component;

class CompanyComponent extends Component
{

    public $companyName;
    public $tag;
    public $id;

    protected $rules = [
        'companyName' => 'required|string|max:45',
        'tag' => 'required|string|max:6',

    ];

    protected $messages = [
        'companyName.required' => 'O nome é obrigatório',
        'companyName.max' => 'O tamanho do nome da empresa deve conter no máximo 45 letras',
        'tag.required' => 'A tag é obrigatória',
        'tag.max' => 'O tamanho da tag deve conter no máximo 6 letras',
    ];

    public function store(): void
    {
        $this->validate();

        Company::updateOrCreate(
            ['id' => $this->id],
            [
                'name' => $this->companyName,
                'tag' => $this->tag
            ]
        );

        $this->reset();
    }

    public function setCompanyModal(Company $company)
    {
        $this->id = $company->id;
        $this->companyName = $company->name;
        $this->tag = $company->tag;
    }

    public function setIdCompanyDelete(int $id)
    {
        $this->id = $id;
    }

    public function deleteCompany(Company $company)
    {
        $company->delete();
    }


    public function getCompanys()
    {
        return Company::orderBy('name', 'ASC')->paginate(15);
    }
    public function render()
    {
        return view(
            'livewire.company-component',
            [
                'companys' => $this->getCompanys(),
            ]
        );
    }
}
