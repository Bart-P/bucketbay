<?php

namespace App\Http\Livewire;

use App\Models\Grafic;
use Livewire\Component;

class GraficsInCart extends Component
{
    protected $listeners = ['removeGraficFromCart'];

    private $printFilesInCart = [];

    public function removeGraficFromCart()
    {
        // TODO pass value to emit and catch it here to delete printfile to remove from session
        dd($this->printFilesInCart);
        /* $selectedGraficInCart = array_search($graficId, $graficsCartArray); */
        /**/
        /* if ($selectedGraficInCart) { */
        /*     array_splice($graficsCartArray, $selectedGraficInCart, 1); */
        /* } */
    }
    public function render()
    {
        foreach ($this->getGraficIdsInCartArray() as $id) {
            array_push($this->printFilesInCart, Grafic::find($id));
        }

        return view('livewire.grafics-in-cart', [
            'grafics' => $this->printFilesInCart
        ]);
    }

    public function getGraficIdsInCartArray(): array | null
    {
        return session('shopping-cart.grafics-id');
    }
}
