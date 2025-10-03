<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Meal;
use App\Models\Category;
use Illuminate\Support\Str;

class MealManager extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $category = '';
    public $filterSearch = '';
    public $filterCategory = '';

    // Form fields
    public $mealId;
    public $name;
    public $price;
    public $category_id;
    public $image_path; // Match the DB column

    // Handle search/filter submission
    public function applyFilters()
    {
        $this->filterSearch = $this->search;
        $this->filterCategory = $this->category;
        $this->resetPage();
    }

    // Add or Update meal
    public function saveMeal()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_path' => 'nullable|image|max:1024', // optional image
        ]);

        if ($this->mealId) {
            $meal = Meal::findOrFail($this->mealId);
        } else {
            $meal = new Meal();
        }

        $meal->name = $this->name;
        $meal->price = $this->price;
        $meal->category_id = $this->category_id;

        // Handle image upload
        if ($this->image_path) {
            $imageName = Str::random(10) . '.' . $this->image_path->getClientOriginalExtension();
            $this->image_path->storeAs('meals', $imageName, 'public');
            $meal->image_path = $imageName;
        } elseif (!$this->mealId) {
            // For new meal without image, optional default
            $meal->image_path = 'default-meal.png';
        }

        $meal->save();

        // Reset form
        $this->reset(['name', 'price', 'category_id', 'image_path', 'mealId']);

        session()->flash('message', $this->mealId ? 'Meal updated successfully!' : 'Meal added successfully!');
    }

    // Edit existing meal
    public function editMeal($id)
    {
        $meal = Meal::findOrFail($id);
        $this->mealId = $meal->id;
        $this->name = $meal->name;
        $this->price = $meal->price;
        $this->category_id = $meal->category_id;
        // Image will be uploaded only if changed
    }

    // Delete meal
    public function deleteMeal($id)
    {
        $meal = Meal::findOrFail($id);
        $meal->delete();
        session()->flash('message', 'Meal deleted successfully!');
    }

    public function render()
{
    $query = Meal::with('category')->orderBy('created_at', 'desc'); // latest first

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
