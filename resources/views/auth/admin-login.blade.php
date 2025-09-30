@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin Login</h2>
    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</div>
@endsection
