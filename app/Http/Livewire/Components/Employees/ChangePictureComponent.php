<?php

namespace App\Http\Livewire\Components\Employees;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChangePictureComponent extends Component
{

    use WithFileUploads;

    public $photo;

    public function mount()
    {
        $this->photo = null;
    }

    public function save()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);
        $path = $this->photo->store('photos');

        auth()->user()->picture_url = URL::to('/') . Storage::url($path);
        auth()->user()->save();

        return $this->mount();
    }

    public function render()
    {
        return view('livewire.components.employees.change-picture-component');
    }
}
