<?php

namespace App\Http\Livewire;

use App\Models\Grafic;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class GraficsTable extends Component
{
    use WithPagination;
    protected string $paginationTheme = 'bootstrap';

    public int $itemsPerPage = 10;
    public string $search = '';
    public int $selectedImageId = 0;


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedItemsPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.grafics-table', [
            'grafics' => Grafic::search($this->search)->latest('updated_at')->paginate($this->itemsPerPage)
        ]);
    }

    public function deleteConfirmation($imageId)
    {
        $this->selectedImageId = $imageId;
    }

    public function downloadFile(string $fileName)
    {
        return Storage::download('public/grafics/' . $fileName);
    }

    public function setGraficsIdCart(int $graficsId)
    {
        $graficsCartArray = [];

        if (session('shopping-cart.grafics-id')) {
            $graficsCartArray = session('shopping-cart.grafics-id');
            if (!in_array($graficsId, $graficsCartArray)) {
                array_unshift($graficsCartArray, $graficsId);
            } else {
                array_splice($graficsCartArray, array_search($graficsId, $graficsCartArray), 1);
            }
        } else {
            $graficsCartArray = [$graficsId];
        };
        session()->put('shopping-cart.grafics-id', $graficsCartArray);
    }
}
