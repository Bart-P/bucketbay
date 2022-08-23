<?php

namespace App\Http\Livewire;

use App\Models\Grafic;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GraficsInCart extends Component
{
    protected $listeners = ['removeGraficFromCart'];

    private $printFilesInCart = [];

    public function removeGraficFromCart($graficId)
    {
        if($graficId) {
            $currentGraficsCart = session('shopping-cart.grafic-ids');
            $indexToDelete = array_search($graficId, $currentGraficsCart);
            if($indexToDelete !== false) {
                array_splice($currentGraficsCart, $indexToDelete, 1);
                session()->put('shopping-cart.grafic-ids', $currentGraficsCart);
            }
        }
    }

    public function render(): Factory|View|Application
    {
        if($this->getGraficIdsInCartArray())
            $this->printFilesInCart = Grafic::find($this->getGraficIdsInCartArray());

        return view('livewire.grafics-in-cart', [
            'grafics' => $this->printFilesInCart
        ]);
    }

    public function getGraficIdsInCartArray(): array | null
    {
        return session('shopping-cart.grafic-ids');
    }
}
