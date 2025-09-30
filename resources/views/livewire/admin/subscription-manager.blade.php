<div class="p-3 bg-light rounded">

    <h3 class="mb-4 text-success">All Subscribers</h3>

    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <!-- Add/Edit Form -->
    <form wire:submit.prevent="save" class="mb-4">
        <div class="row g-2">
            <div class="col-md-2">
                <select wire:model="userId" class="form-select border-success">
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} (ID: {{ $user->id }})</option>
                    @endforeach
                </select>
                @error('userId') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <input type="text" wire:model="plan" class="form-control border-success" placeholder="Plan">
                @error('plan') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <select wire:model="status" class="form-select border-success">
                    <option value="active">Active</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="pending">Pending</option>
                </select>
                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <input type="date" wire:model="startDate" class="form-control border-success">
                @error('startDate') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <input type="date" wire:model="endDate" class="form-control border-success">
                @error('endDate') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success">{{ $selectedId ? 'Update' : 'Add' }}</button>
                <button type="button" wire:click="resetFields" class="btn btn-secondary">Clear</button>
            </div>
        </div>
    </form>

    <!-- Subscribers Table -->
    @if($subscriptions->count())
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Plan</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $i => $sub)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $sub->user->name ?? 'N/A' }} (ID: {{ $sub->user_id }})</td>
                            <td>{{ $sub->plan }}</td>
                            <td><span class="badge bg-info text-dark">{{ ucfirst($sub->status) }}</span></td>
                            <td>{{ optional($sub->start_date)->format('d M Y') }}</td>
                            <td>{{ optional($sub->end_date)->format('d M Y') }}</td>
                            <td>
                                <button wire:click="edit({{ $sub->id }})" class="btn btn-sm btn-warning">Edit</button>
                                <button wire:click="delete({{ $sub->id }})" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted mt-3">No subscribers found.</p>
    @endif

</div>
