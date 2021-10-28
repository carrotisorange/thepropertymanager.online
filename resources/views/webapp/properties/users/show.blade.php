@extends('layouts.argon.dashboard')

@section('title', 'Users')

@section('content')
<div class="card-body px-lg-5 py-lg-5">
    <?php $ctr=1;?>


        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Property</th>
                        <th>Created on</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                    
                    <tr>
                        <th>{{ $ctr++ }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->role }}</td>
                        <td>{{ $item->property }}</td>
                        <td>{{ Carbon\Carbon::parse($item->created_on)->format('M d Y') }}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        <br>
        <div class="row">


            <div class="col">

                <a href="/property/all" class="text-white btn btn-primary btn-block"><i class="fas fa-arrow-left"></i>
                    Back</a>

            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')

@endsection