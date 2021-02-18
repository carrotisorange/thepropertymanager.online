@extends('webapp.owner_access.template')

@section('title', 'Financials')

@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Financials</h6>
    
  </div>
  {{-- <div class="col-md-6 text-right">
    <a  href="#" class="btn btn-primary" data-toggle="modal" data-target="#addConcern" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>  
  </div> --}}
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-4">
        <div class="table-responsive text-nowrap">
            <p>Amount Collected</p>
            <table class="table">
                <tbody>
                   @foreach ($bills as $item)
                   <tr>
                        <td>{{ Carbon\Carbon::parse($item->date_posted )->format('M d, Y')}}</td>
                        <td>{{ number_format($item->amt_paid, 2) }}</td>
                    </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        <div class="table-responsive text-nowrap">
            <p>Expense</p>
            <table class="table">
                <tbody>
                   @foreach ($expenses as $item)
                   <tr>
                       
                        <td>{{ number_format($item->total_expenses, 2) }}</td>
                    </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        <div class="table-responsive text-nowrap">
            <p>Amount Remitted</p>
            <table class="table">
                <tbody>
                   @foreach ($remittances as $item)
                   <tr>
                       
                        <th>{{ number_format($item->amt_remitted, 2) }}</th>
                    </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
       

@endsection

@section('scripts')
  
@endsection



