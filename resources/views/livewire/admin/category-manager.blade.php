<div class="p-4" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <!-- Page Heading -->
    <h4 class="mb-4 fw-bold text-success" style="font-size:1.75rem;">Manage Categories</h4>

    <!-- Success Message -->
    @if(session()->has('message'))
        <div class="alert alert-success shadow-sm rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search -->
    <input type="text" wire:model="search" class="form-control mb-3 border-success shadow-sm" placeholder="Search categories...">

    <!-- Category Form -->
    <form wire:submit.prevent="saveCategory" class="mb-4 p-3 bg-light rounded shadow-sm border border-success">
        <div class="mb-2">
            <input type="text" wire:model="name" class="form-control border-success shadow-sm" placeholder="Category Name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-2">
            <textarea wire:model="description" class="form-control border-info shadow-sm" placeholder="Description"></textarea>
        </div>
        <button type="submit" class="btn btn-success me-2 shadow-sm">
            {{ $categoryId ? 'Update' : 'Add' }} Category
        </button>
        <button type="button" wire:click="resetForm" class="btn btn-warning shadow-sm">Reset</button>
    </form>

    <!-- Categories Table -->
    <div class="table-responsive shadow rounded bg-light p-3 border border-success">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-success text-dark">
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr class="align-middle" style="transition: background 0.3s;" 
                        onmouseover="this.style.background='#d4edda'" 
                        onmouseout="this.style.background='white'">
                        <td class="text-center fw-semibold text-success">{{ $cat->id }}</td>
                        <td class="fw-bold text-success">{{ $cat->name }}</td>
                        <td>{{ $cat->description }}</td>
                        <td class="text-center">
                            <button wire:click="editCategory({{ $cat->id }})" 
                                    class="btn btn-sm btn-info me-1 shadow-sm"
                                    style="transition: transform 0.2s;"
                                    onmouseover="this.style.transform='scale(1.05)'" 
                                    onmouseout="this.style.transform='scale(1)'">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button wire:click="deleteCategory({{ $cat->id }})" 
                                    class="btn btn-sm btn-danger shadow-sm" 
                                    onclick="return confirm('Delete this category?')"
                                    style="transition: transform 0.2s;"
                                    onmouseover="this.style.transform='scale(1.05)'" 
                                    onmouseout="this.style.transform='scale(1)'">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-end">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
