@extends('webapp.owner_access.template')

@section('title', 'Financials')

@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Financials</h6>

</div>
{{-- <div class="col-md-6 text-right">
    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i
            class="fas fa-plus fa-sm text-white-50"></i> Add</a>
</div> --}}
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-3">
        <div class="table-responsive text-nowrap">

            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($remittances as $item)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($item->start_at )->format('M d, Y')}}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-3">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Revenue <a href="#" title="Rent of your unit per month."><i
                                    class="fas fa-info-circle"></i></a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $item)
                    @foreach ($bills as $item)
                    <tr>

                        <td>{{ number_format($item->contract_rent, 2) }}</td>
                    </tr>
                    @endforeach
                    @endforeach
                    @foreach ($bills as $item)
                    <tr>
                        <th>{{ number_format($item->rent*$expenses->count(), 2) }}</th>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-3">
        <div class="table-responsive text-nowrap">

            <table class="table">
                <thead>
                    <tr>
                        <th>Expenses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $item)
                    <tr>
                        <td><a
                                href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/remittance/{{ $item->remittance_id_foreign }}/expenses">{{
                                number_format($item->total_expenses, 2) }}</a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <th>{{ number_format($expenses->sum('total_expenses'), 2) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-3">
        <div class="table-responsive text-nowrap">

            <table class="table">
                <thead>
                    <tr>
                        <th>Amount Remitted</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($remittances as $item)
                    <tr>

                        <th>{{ number_format($item->amt_remitted, 2) }}</th>
                    </tr>
                    @endforeach
                    <tr>
                        <th>{{ number_format($remittances->sum('amt_remitted'), 2) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@section('scripts')

@endsection