@extends('admin.layout')

@section('content')
<div class="p-4">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-gray-800 fw-bold">Users</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Add User
        </a>
    </div>

    <!-- Users Table -->
    <div class="table-responsive shadow rounded">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="text-center">ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="text-center">{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                           class="btn btn-sm btn-warning me-1">
                           <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" 
                              method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Optional: Pagination -->
    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>

@endsection
