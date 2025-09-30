<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class CategoryManager extends Component
{
    use WithPagination;

    public $name, $description, $categoryId;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
    ];

    // Reset form
    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->categoryId = null;
    }

    // Save new / update category
    public function saveCategory()
    {
        $this->validate();

        if ($this->categoryId) {
            Category::find($this->categoryId)->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            session()->flash('message', 'Category updated successfully.');
        } else {
            Category::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            session()->flash('message', 'Category added successfully.');
        }

        $this->resetForm();
    }

    // Edit
    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->description = $category->description;
    }

    // Delete
    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function render()
    {
        $categories = Category::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.admin.category-manager', compact('categories'));
    }
}
