<?php

namespace App\Http\Livewire\Components\Company;

use Livewire\Component;
use Livewire\WithFileUploads;

class ChangeCompanyLogoComponent extends Component
{
    use WithFileUploads;

    public $file;
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
            'file' => 'image|max:1024', // 1MB Max
        ]);

        if(auth()->user()->can('company.settings.update')){
            auth()->user()->company->logo_path = "/storage/".$this->file->store('photos');
            auth()->user()->company->save();
            $this->formOpen = false;
        }
        $this->reset();
        $this->render();
    }

    public function render()
    {
        return view('livewire.components.company.change-company-logo-component');
    }
}
