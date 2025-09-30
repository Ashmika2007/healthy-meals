<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Review;

class ReviewManager extends Component
{
    use WithPagination;
    public $filterUser = '';
    public $filterMeal = '';
    protected $paginationTheme = 'bootstrap';

    public function approve($id)
    {
        $r = Review::find($id);
        if ($r) { $r->approved = true; $r->save(); session()->flash('message', 'Approved'); }
    }

    public function unapprove($id)
    {
        $r = Review::find($id);
        if ($r) { $r->approved = false; $r->save(); session()->flash('message', 'Unapproved'); }
    }

    public function destroy($id)
    {
        Review::find($id)?->delete();
        session()->flash('message', 'Deleted');
    }

    public function render()
    {
        $query = Review::orderByDesc('created_at');

        if ($this->filterUser) {
            // simple filter by user id or name if stored in meta
            $query->where('user_id', $this->filterUser)
                  ->orWhere('meta.user_name', 'like', '%'.$this->filterUser.'%');
        }

        if ($this->filterMeal) {
            $query->where('meal_id', (int)$this->filterMeal);
        }

        $reviews = $query->paginate(12);
        return view('livewire.admin.review-manager', compact('reviews'));
    }
}
