<?php

namespace App\Http\Livewire\Components\Company;

use Livewire\Component;
use Livewire\WithFileUploads;

class ChangeCompanyLogoComponent extends Component
{
    use WithFileUploads;

    public $photo;
    public $formOpen;

    public function mount()
    {
        $this->formOpen = false;
    }

    public function toggleForm()
    {
        $this->formOpen = !$this->formOpen;
    }

    public function save()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);

        if(auth()->user()->can('company.settings.update')){
            auth()->user()->company->logo_path = "/storage/".$this->photo->store('photos');
            auth()->user()->company->save();
            $this->formOpen = false;
        }
    }

    public function render()
    {
        return view('livewire.components.company.change-company-logo-component');
    }
}
