<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Review;
use App\Models\Meal;
use Illuminate\Support\Facades\Auth;

class ReviewComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $rating;
    public $comment;
    public $meal_id;

    public function submitReview()
    {
        $this->validate([
            'meal_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'meal_id' => $this->meal_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'approved' => false,
        ]);

        // Reset inputs after submission
        $this->reset(['rating', 'comment', 'meal_id']);
        session()->flash('message', 'Review submitted successfully!');
    }

    public function render()
    {
        $reviews = Review::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(5);

        // Attach meals manually
        foreach ($reviews as $review) {
            $review->meal = Meal::find($review->meal_id);
        }

        return view('livewire.review-component', compact('reviews'));
    }
}
