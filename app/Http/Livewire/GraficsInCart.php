<?php

// TODO this has to be deleted? Replaced by Orderobject..


namespace App\Http\Livewire;

use App\Models\Grafic;
use App\Services\CartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GraficsInCart extends Component
{
    protected $listeners = ['removeGraficFromCart'];

    private CartService $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function removeGraficFromCart($graficId)
    {
        $this->cartService->addOrRemoveGraficsId($graficId);
    }

    public function render(): Factory|View|Application
    {
        $graficsInCart = [];
        if ($this->cartService->getAllGrafics()) {
            $graficsInCart = Grafic::find($this->cartService->getAllGrafics());
        }

        return view('livewire.grafics-in-cart', ['grafics' => $graficsInCart]);
    }
}