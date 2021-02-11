@extends('layouts.argon.main')

@section('title', $tenant->first_name.' '.$tenant->last_name)

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-auto text-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $contract->tenant_id_foreign }}/">{{ $tenant->first_name.' '.$tenant->last_name }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contract ID: {{ $contract->contract_id }}</li>
      </ol>
    </nav>
    
    
  </div>
</div>
<div class="row">
    <div class="col-md-10">
        {{-- <a href="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}#contracts"  class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>  --}}
        <a class="btn btn-primary" href="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/edit"><i class="fas fa-edit"></i> Edit</a>
        <a class="btn btn-primary" href="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/extend"><i class="fas fa-external-link-alt"></i> Extend</a>
        @if(!$contract->terminated_at)
          @if($balance->count()<0)
          <a href="#" data-toggle="modal" data-target="#pendingBalance" class="btn btn-danger"><i class="fas fa-sign-out-alt fa-sm text-white-50"></i> Terminate</a>
          @else
          <a class="btn btn-danger" href="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/preterminate"><i class="fas fa-sign-out-alt fa-sm text-white-50"></i> Terminate</a>
          @endif
       @endif
        @if($contract->terminated_at)
          @if($balance->count()<0)
          <a href="#" data-toggle="modal" data-target="#pendingBalance" class="btn btn-danger"><i class="fas fa-sign-out-alt text-white-50"></i> Moveout</a>
          @else
            @if($contract->status != 'inactive')
            <a class="btn btn-success" href="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}/moveout"><i class="fas fa-sign-out-alt text-white-50"></i>  Moveout</a>
            @endif
          @endif
        @endif
       
       
    </div>
    <div class="col-md-2 text-right">
        <form action="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}/contract/{{ $contract->contract_id }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="d-none d-sm-inline-block btn btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-trash-alt"></i> Delete</button>
          </form>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                 {{-- <tr>
                     <th>Tenant </th>
                     <td><a target="_blank" href="/property/{{Session::get('property_id')}}/tenant/{{ $contract->tenant_id_foreign }}">View</a></td>
                 </tr> --}}
                 <tr>
                   <thead>
                  <th>Room </th>
                  <td><a target="_blank" href="/property/{{Session::get('property_id')}}/room/{{ $contract->unit_id_foreign }}">View</a></td>
              </tr>
            </thead>
              <thead>
              <tr>
                  <th>Referrer </th>
                  <td>
                    @if($contract->referrer_id_foreign != '36')
                    <a target="_blank" href="/property/{{Session::get('property_id')}}/user/{{ $contract->referrer_id_foreign }}">View</a>
                    @else
                    None
                    @endif
                  </td>
              </tr>
            </thead>
              <thead>
              <tr>
                  <th>Source</th>
                  <td>{{ $contract->form_of_interaction }}</td>
              </tr>
            </thead>
              <thead>
              <tr>
                  <th>Rent</th>
                  <td>{{ number_format($contract->rent, 2) }}</td>
              </tr>
            </thead>
              <thead>
              <tr>
                  <th>Discount</th>
                  <td>{{  number_format($contract->discount, 2) }}</td>
              </tr>
            </thead>
              <thead>
              <tr>
                  <th>Status</th>
                  <td>
                    @if($contract->status != 'active')
                  <i class="fas fa-clock text-warning"></i> {{ $contract->status }}
                
                  @else
                  <i class="fas fa-check-circle text-success"></i> {{ $contract->status }}
                  @endif
                  </td>
              </tr>
            </thead>
              <thead>
              <tr>
                  <th>Movein</th>
                  <td>{{ Carbon\Carbon::parse($contract->movein_at)->format('M d, Y') }}</td>
              </tr>
              <thead>
              <tr>
                  <th>Moveout</th>
                  <td>{{ Carbon\Carbon::parse($contract->moveout_at)->format('M d, Y') }}</td>
              </tr>
            </thead>
              <thead>
              <tr>
                  <th>Length of stay</th>
                  <td>{{ $contract->number_of_months }}</td>
              </tr>
            </thead>
              <thead>
              <tr>
                  <th>Term</th>
                  <td>{{ $contract->term }}</td>
              </tr>
            </thead>
              <thead>
              <tr>
                  <th>Date terminated</th>
                  <td>{{ $contract->terminated_at? Carbon\Carbon::parse($contract->terminated_at)->format('M d, Y'): 'NOT AVAILABLE' }}</td>
              </tr>
            </thead>
              <thead>
              <tr>
                  <th>Actual moveout</th>
                  <td>{{ $contract->actual_moveout_at? Carbon\Carbon::parse($contract->actual_moveout_at)->format('M d, Y'): 'NOT AVAILABLE' }}</td>
              </tr>
            </thead>
              <thead>
              <tr>
                  <th>Reason for termination</th>
                  <td>{{ $contract->moveout_reason? $contract->moveout_reason: 'NOT AVAILABLE' }}</td>
              </tr>
             
              </table>
          </div>
          </div>
        </div>
    </div>
</div>


<div class="modal fade" id="pendingBalance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Balance</h5>
      
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
       <p class="text-danger">Tenant needs to pay the balance to moveout.</p>
        <div class="row">
          <div class="col">
           
            <div class="table-responsive text-nowrap">
             
              <table class="table">
                <thead>
                <tr>
              
                  <th>Bill No</th>
                 
                  <th>Particular</th>
                  <th>Period Covered</th>
                  <th class="text-right" colspan="3">Amount</th>
                  
                </tr>
              </thead>
                @foreach ($balance as $item)
                <tr>
                
                    <td>{{ $item->bill_no }}</td>
            
                    <td>{{ $item->particular }}</td>
                    <td>
                      {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                      {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
                    </td>
                    <td class="text-right" colspan="3">{{ number_format($item->balance,2) }}</td>
                           </tr>
                @endforeach
          
            </table>
            <table class="table">
              <tr>
               <th>TOTAL</th>
               <th class="text-right">{{ number_format($balance->sum('balance'),2) }} </th>
              </tr>    
            </table>
          </div>
          </div>
          
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" data-dismiss="modal" aria-label="Close" class="btn btn-primary"> Dismiss</a>
      </div>
      
  </div>
  </div>
</div>

@endsection

@section('scripts')
  
@endsection



