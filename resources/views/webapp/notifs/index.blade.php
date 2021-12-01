@extends('layouts.argon.main')

@section('title', 'Audit Trails')

@section('upper-content')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-dark d-inline-block mb-0">Audit Trails</h6>
    </div>
</div>
    <table class="table table-hover">
        <?php $ctr = 1; ?>
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Action</th>
                <th>Details</th>
                <th>Amount</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notifs as $item)
            <tr>
                <th>{{ $ctr++ }}</th>
                <td>{{ $item->user_name }}</td>
                <td>{{ $item->action_type }}</td>
                <td>{{ $item->message }}</td>
                <td>{{ number_format($item->amount, 2)}}</td>
                <td>{{ $item->triggered_at }}</td>
                </td> 
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $notifs->links() }}


@endsection

