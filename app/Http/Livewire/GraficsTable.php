<?php

namespace App\Http\Livewire;

use App\Models\Grafic;
use Livewire\Component;
use Livewire\WithPagination;

class GraficsTable extends Component
{
    use WithPagination;
    protected string $paginationTheme = 'bootstrap';

    public int $itemsPerPage = 10;
    public string $search = '';
    public int $selected_image_id = 0;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.grafics-table', [
            'grafics' => Grafic::search($this->search)->latest('updated_at')->paginate($this->itemsPerPage)
        ]);
    }

    public function deleteConfirmation($image_id)
    {
        $this->selected_image_id = $image_id;
    }
}
