<div class="p-4" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <!-- Page Heading -->
    <h4 class="mb-4 fw-bold text-success" style="font-size:1.8rem;">Manage Meals</h4>

    <!-- Search + Filter Form -->
    <form wire:submit.prevent="applyFilters" class="row g-2 mb-4 align-items-center">
        <div class="col-md-4">
            <input type="text" wire:model="search" class="form-control border-success shadow-sm" placeholder="Search meals...">
        </div>
        <div class="col-md-3">
            <select wire:model="category" class="form-select border-info shadow-sm">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-success shadow-sm">
                <i class="fas fa-filter me-1"></i> Apply
            </button>
        </div>
    </form>

    <!-- Current Filters -->
    @if($filterSearch || $filterCategory)
        <p class="text-muted mb-4">
            Filtering by:
            @if($filterSearch) <span class="badge bg-success">{{ $filterSearch }}</span> @endif
            @if($filterCategory) <span class="badge bg-info text-dark">{{ \App\Models\Category::find($filterCategory)->name ?? '' }}</span> @endif
        </p>
    @endif

    <!-- Meals Table -->
    @if($meals->count())
    <div class="table-responsive shadow rounded bg-white p-4">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark text-white">
                <tr>
                    <th class="text-center">#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($meals as $meal)
                <tr class="align-middle" style="transition: background 0.3s;" onmouseover="this.style.background='#f1f8f2'" onmouseout="this.style.background='white'">
                    <td class="text-center fw-semibold">{{ $meal->id }}</td>
                    <td>
                        @if($meal->image)
                            <img src="{{ asset('storage/meals/'.$meal->image) }}" 
                                 class="rounded-circle border border-success shadow-sm" width="60" height="60" alt="{{ $meal->name }}">
                        @else
                            <div class="bg-secondary rounded-circle d-inline-block shadow-sm" style="width:60px; height:60px;"></div>
                        @endif
                    </td>
                    <td class="fw-bold text-success">{{ $meal->name }}</td>
                    <td>
                        <span class="badge bg-info text-dark shadow-sm">{{ $meal->category->name ?? '-' }}</span>
                    </td>
                    <td><span class="fw-bold text-success">Rs {{ number_format($meal->price, 2) }}</span></td>
                    <td class="text-center">
                        <button wire:click="editMeal({{ $meal->id }})" 
                                class="btn btn-sm btn-primary me-1 shadow-sm" 
                                style="transition: transform 0.2s;" 
                                onmouseover="this.style.transform='scale(1.05)'" 
                                onmouseout="this.style.transform='scale(1)'">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button wire:click="deleteMeal({{ $meal->id }})" 
                                class="btn btn-sm btn-danger shadow-sm" 
                                onclick="return confirm('Are you sure you want to delete this meal?')"
                                style="transition: transform 0.2s;" 
                                onmouseover="this.style.transform='scale(1.05)'" 
                                onmouseout="this.style.transform='scale(1)'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-end">
            {{ $meals->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @else
        <p class="text-center text-muted mt-4">No meals found.</p>
    @endif
</div>
