<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Variation;

class Producttype extends Component
{
    public $variations;
    public $selected_variations = [];
    public $options0 = '';
    public $options1 = '';
    public $options2 = '';

	public function mount()
	{
		$this->variations = Variation::orderBy('id', 'DESC')->get();
	}

	public function selected()
	{
		dd('Okay');
	}

    public function render()
    {
        return view('livewire.producttype');
    }
}
