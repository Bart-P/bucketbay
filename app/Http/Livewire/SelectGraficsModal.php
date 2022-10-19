<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SelectGraficsModal extends Component
{
    public bool $show = false;
    public $grafics;

    protected $listeners = ['showSelectGraficsModal' => 'showModal',
                            'hideSelectGraficsModal' => 'hideModal'];

    public function render(): Factory|View|Application
    {
        return view('livewire.select-grafics-modal');
    }

    public function showModal(int $orderObjectKey): bool
    {
        return $this->show = true;
    }

    public function hideModal(): void
    {
        $this->show = false;
    }

    public function selectGraficsForOrderObject(int $graficId)
    {
        $this->emit('graficForOrderObjectSelected', $graficId);
        $this->hideModal();
    }
}