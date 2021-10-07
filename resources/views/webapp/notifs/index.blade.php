@extends('layouts.argon.main')

@section('title', 'Audit Trails')

@section('css')
<style>
    /*This will work on every browser*/
    thead tr:nth-child(1) th {
        background: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }
</style>

@section('upper-content')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-dark d-inline-block mb-0">Audit Trails</h6>
    </div>
</div>
<div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
    <table class="table table-hover">
        <?php $ctr = 1; ?>
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Action</th>
                <th>Details</th>
                <th>Amount</th>
                <th>Triggered on</th>
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

</div>
@endsection

@section('scripts')

@endsection