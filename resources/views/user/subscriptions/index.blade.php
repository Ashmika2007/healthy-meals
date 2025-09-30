@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Available Plans</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($plans as $key => $plan)
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body text-center">
                        <h4 class="fw-bold">{{ $plan['name'] }}</h4>
                        <p class="text-muted">Rs {{ number_format($plan['price'], 2) }}</p>
                        <a href="{{ route('subscriptions.payment', $key) }}" class="btn btn-primary">Subscribe</a>

            
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h4 class="mt-4">My Subscriptions</h4>
    @if($subscriptions->count())
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Start</th>
                    <th>End</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        @if(isset($plans[$s->plan]))
                            {{ $plans[$s->plan]['name'] }}
                        @else
                            {{ $s->plan }}
                        @endif
                    </td>
                    <td>{{ ucfirst($s->status) }}</td>
                    <td>{{ optional($s->start_date)->format('d M Y') }}</td>
<td>{{ optional($s->end_date)->format('d M Y') }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">You have no subscriptions yet.</p>
    @endif
</div>
@endsection
