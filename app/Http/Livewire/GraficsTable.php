<?php

namespace App\Http\Livewire;

use App\Models\Grafic;
use App\Services\CartService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class GraficsTable extends Component
{
    use WithPagination;

    public int $itemsPerPage = 10;
    public string $search = '';
    public int $selectedImageId = 0;
    protected string $paginationTheme = 'bootstrap';
    private CartService $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

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
        return view('livewire.grafics-table', ['grafics' => Grafic::search($this->search)->latest('updated_at')->paginate($this->itemsPerPage)]);
    }

    public function deleteConfirmation($imageId)
    {
        $this->selectedImageId = $imageId;
    }

    public function downloadFile(string $fileName)
    {
        return Storage::download('public/grafics/' . $fileName);
    }

    public function toggleGraficsIdInCart(int $graficsId)
    {
        $this->cartService->addOrRemoveGraficsId($graficsId);
    }
}