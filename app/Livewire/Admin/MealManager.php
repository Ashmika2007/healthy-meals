<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Meal;
use App\Models\Category;

class MealManager extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $category = '';
    public $filterSearch = '';
    public $filterCategory = '';

    // Handle search submission
    public function applyFilters()
    {
        $this->filterSearch = $this->search;
        $this->filterCategory = $this->category;
        $this->resetPage();
    }

    public function render()
    {
        $query = Meal::with('category');

        if ($this->filterSearch) {
            $query->where('name', 'like', '%' . $this->filterSearch . '%');
        }

        if ($this->filterCategory) {
            $query->where('category_id', $this->filterCategory);
        }

        return view('livewire.admin.meal-manager', [
            'meals' => $query->paginate(10),
            'categories' => Category::all(),
        ]);
    }
}
