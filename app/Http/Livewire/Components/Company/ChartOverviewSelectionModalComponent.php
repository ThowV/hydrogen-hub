<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\CompanyHydrogenInterest;
use Livewire\Component;

class ChartOverviewSelectionModalComponent extends Component
{
    public $isOpen = false;
    public $interests = [];

    protected $listeners = ['openChartOverviewSelectionModal' => 'toggleModal'];

    public function toggleModal()
    {
        $this->isOpen = !$this->isOpen;

        if ($this->isOpen) {
            $this->interests = auth()->user()->company->hydrogenInterestsAsArray;
        }
    }

    public function save()
    {
        $hydrogenInterests = auth()->user()->company->hydrogenInterests;

        // Remove interests that are not present anymore
        foreach ($hydrogenInterests as $hydrogenInterest) {
            if (!in_array($hydrogenInterest->interest, $this->interests)) {
                $hydrogenInterest->delete();
            }
        }

        // Add interests that need to be present
        foreach ($this->interests as $interest) {
            if (!in_array($interest, auth()->user()->company->hydrogenInterestsAsArray)) {
                $companyHydrogenInterest = new CompanyHydrogenInterest();
                $companyHydrogenInterest->fill(['company_id' => auth()->user()->company->id, 'interest' => $interest]);
                $companyHydrogenInterest->save();
            }
        }

        $this->toggleModal();
        $this->emit('chartTypesUpdated');
    }

    public function render()
    {
        return view('livewire.components.company.chart-overview-selection-modal-component');
    }
}
