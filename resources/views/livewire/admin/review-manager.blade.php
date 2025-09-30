<div class="p-4" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    @if(session()->has('message'))
        <div class="alert alert-success shadow-sm rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="row mb-3 g-2">
        <div class="col-md-4">
            <input wire:model="filterUser" class="form-control border-success" placeholder="Filter user id or name">
        </div>
        <div class="col-md-3">
            <input wire:model="filterMeal" class="form-control border-success" placeholder="Filter meal id or name">
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="table-responsive shadow rounded bg-light p-3 border border-success">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-success text-dark">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Meal</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Approved</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $r)
                <tr style="transition: background 0.3s;" onmouseover="this.style.background='#f0fff0'" onmouseout="this.style.background='white'">
                    <td class="fw-semibold text-success">
                        {{ isset($r->_id) ? (is_object($r->_id) ? $r->_id->__toString() : $r->_id) : $r->id }}
                    </td>
                    <td>{{ $r->user->name ?? ('User '.$r->user_id) }}</td>
                    <td>{{ optional($r->meal)->name ?? ('Meal '.$r->meal_id) }}</td>
                    <td><span class="badge bg-warning text-dark">{{ $r->rating }}</span></td>
                    <td style="max-width:400px; white-space:normal;">{{ $r->comment }}</td>
                    <td>
                        @if($r->approved)
                            <span class="badge bg-success text-white">Yes</span>
                        @else
                            <span class="badge bg-secondary text-dark">No</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $id = isset($r->_id) ? (is_object($r->_id) ? $r->_id->__toString() : $r->_id) : $r->id;
                        @endphp

                        @if(!$r->approved)
                            <button wire:click="approve('{{ $id }}')" class="btn btn-sm btn-success mb-1">
                                <i class="fas fa-check me-1"></i>Approve
                            </button>
                        @else
                            <button wire:click="unapprove('{{ $id }}')" class="btn btn-sm btn-warning mb-1">
                                <i class="fas fa-times me-1"></i>Unapprove
                            </button>
                        @endif

                        <button wire:click="destroy('{{ $id }}')" onclick="return confirm('Delete?')" class="btn btn-sm btn-danger mb-1">
                            <i class="fas fa-trash-alt me-1"></i>Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $reviews->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
