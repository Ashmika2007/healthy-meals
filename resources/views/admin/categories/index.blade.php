@extends('admin.layout')

@section('content')
    <div class="container mt-4">
        <h3>Categories</h3>
        <hr>
        @livewire('admin.category-manager')
    </div>
@endsection
