<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\Price;
use Livewire\Component;

class Prices extends Component
{
    public $id;
    public $price_lpa4a;
    public $price_lpa2a;
    public $price_dy4a;
    public $price_dy2a;
    public $companyId;
    public $year;


    public function getPrices()
    {
        $pricesQuery = Price::select(['prices.*'])->orderBy('prices.id', 'desc');

        if ($this->companyId) {
            $pricesQuery->where('prices.company_id', '=', $this->companyId);
        }
        
        return $pricesQuery->paginate(15);
    }

    public function getCompanys()
    {
        return Company::all();
    }

    public function store()
    {
        Price::updateOrCreate(
            [
                'id' => $this->id,
            ],
            [
                'price_lpa4a' => $this->price_lpa4a,
                'price_lpa2a' => $this->price_lpa2a,
                'price_dy4a' => $this->price_dy4a,
                'price_dy2a' => $this->price_dy2a,
                'company_id' => $this->companyId,
                'year' => $this->year,
            ]
        );

        $this->reset();
    }

    public function setPricesModal(Price $price)
    {
        $this->id = $price->id;
        $this->price_lpa4a = $price->price_lpa4a;
        $this->price_lpa2a = $price->price_lpa2a;
        $this->price_dy4a = $price->price_dy4a;
        $this->price_dy2a = $price->price_dy2a;
        $this->companyId = $price->company_id;
        $this->year = $price->year;
    }

    public function setIdpricesDelete(int $id)
    {
        $this->id = $id;
    }

    public function deletePrices(Price $price)
    {
        $price->delete();
    }


    public function render()
    {
        return view('livewire.prices', [
            'prices' => $this->getPrices(),
            'companys' => $this->getCompanys(),
        ]);
    }
}
