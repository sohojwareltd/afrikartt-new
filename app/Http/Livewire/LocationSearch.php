<?php

namespace App\Http\Livewire;

use App\Models\Shop;
use Livewire\Component;

class LocationSearch extends Component
{
    public $selected = '';
    public $states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'];
    public $ss;
    public $cities = [];
    public function mount()
    {
        $this->ss = 'New York' ?? session()->get('state');
        $this->cities = Shop::where('state', $this->ss)->pluck('city', 'city')->toArray();
    }

    public function updatingState()
    {

        $this->cities = [];
        $this->cities = Shop::where('state', $this->ss)->get();
    }
    public function render()
    {
        return view('livewire.location-search');
    }
}
