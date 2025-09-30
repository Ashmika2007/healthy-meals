<div>
    <h4>My Reviews</h4>

    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <!-- Submit Review Form -->
    <form wire:submit.prevent="submitReview">
        <select wire:model="meal_id" class="form-control mb-2">
            <option value="">Select Meal</option>
            @foreach(\App\Models\Meal::all() as $meal)
                <option value="{{ $meal->id }}">{{ $meal->name }}</option>
            @endforeach
        </select>

        <input type="number" wire:model="rating" placeholder="Rating (1-5)" class="form-control mb-2" min="1" max="5">
        <textarea wire:model="comment" placeholder="Write your review" class="form-control mb-2"></textarea>
        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>

    <hr>

    @if($reviews->count())
        <ul class="list-group">
            @foreach($reviews as $r)
                <li class="list-group-item">
                    <strong>Meal: {{ $r->meal->name ?? 'Deleted Meal' }}</strong>
                    <div>Rating: ⭐ {{ $r->rating }}/5</div>
                    <div>{{ $r->comment }}</div>
                    <span class="badge bg-{{ $r->approved ? 'success' : 'warning' }}">
                        {{ $r->approved ? 'Approved' : 'Pending' }}
                    </span>
                </li>
            @endforeach
        </ul>

        <div class="mt-3">
            {{ $reviews->links('pagination::bootstrap-5') }}
        </div>
    @else
        <p class="text-muted">You haven’t written any reviews yet.</p>
    @endif
</div>
