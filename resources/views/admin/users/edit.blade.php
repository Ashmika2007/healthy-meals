@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Name</label>
            <input type="text" 
                   name="name" 
                   value="{{ old('name', $user->name) }}" 
                   class="form-control" 
                   required>
        </div>

        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" 
                   name="email" 
                   value="{{ old('email', $user->email) }}" 
                   class="form-control" 
                   required>
        </div>

        <div class="form-group mb-3">
            <label>Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control" placeholder="New password">
            <input type="password" name="password_confirmation" class="form-control mt-2" placeholder="Confirm new password">
        </div>

        <div class="form-group mb-3">
    <label>Role</label>
    <select name="role" class="form-select" required>
        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
</div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
