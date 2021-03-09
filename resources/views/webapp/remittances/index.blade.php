@extends('layouts.argon.main')

@section('title', 'Remittances')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-md-9">
    <h6 class="h2 text-dark d-inline-block mb-0">Remittances</h6>
    
  </div>
  <div class="col-md-3 text-right">
    {{-- <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addRemittance" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a> --}}
  </div>

</div>

@if($remittances->count() <=0 )
<p class="text-danger text-center">No remittances found!</p>

@else

<div class="table">
    <table class="table table-bordered table-hover">
        <thead>
            <?php $ctr=1;?>
            <tr>
                {{-- <th>#</th> --}}
                <th>Date Prepared</th>
                <th>Period Covered</th>
                <th>Particular</th>
                <th>CV</th>
                <th>Check #</th>
                <th>Owner</th>
                <th>Room</th>
                <th>Status</th>
                <th>Amount</th>
    
            </tr>    
        </thead>
        <tbody>
            @foreach ($remittances as $item)
            <tr>
                {{-- <th>{{ $ctr++ }}</th>      --}}
                <td>{{ Carbon\Carbon::parse($item->prepared_at)->format('M d, Y') }}</td>
                
                <td>{{ Carbon\Carbon::parse($item->start_at)->format('M d, Y').' - '.Carbon\Carbon::parse($item->end_at)->format('M d, Y') }}</td>
                <td>{{ $item->particular }}</td>
                <td>{{ $item->cv_number }}</td>
                <td>{{ $item->check_number }}</td>
                <th><a href="/property/{{ Session::get('property_id') }}/owner/{{ $item->owner_id }}">{{ $item->name }}</a></th>
                <th><a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}">{{ $item->unit_no }}</a></th>
               <td>
                @if($item->remitted_at === NULL)
                <span class="badge badge-danger">pending</span>
                @else
                <span class="badge badge-success">remitted</span>
                @endif
               </td>
                <th><a href="/property/{{ Session::get('property_id') }}/remittance/{{ $item->remittance_id }}/expenses">{{ number_format($item->amt_remitted,2) }}</a></th>
            </tr>   
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="addRemittance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" >Add</h5>
  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form id="addRemittanceForm" action="/property/{{ Session::get('property_id') }}/remittances/store" method="POST">
                @csrf
            </form>
  
            <div class="form-group">
                <label>Room</label>
                <select   form="addRemittanceForm" class="form-control" name="unit_id" id="" required>
                    <option value="">Please select one</option>
                    @foreach ($rooms as $item)
                    <option value="{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</option>   
                    @endforeach
                </select>
                
            </div>
  
            <div class="form-group">
                <label>Period Covered</label>
                <div class="row">
                    <div class="col">
                        <small for="">Start</small>
                        <input form="addRemittanceForm" type="date" class="form-control" name="start" required>
                    </div>
                    <div class="col">
                        <small>End</small>
                        <input form="addRemittanceForm" type="date" class="form-control" name="end" required>
                    </div>
                </div>
                
            </div>

            <div class="form-group">
                <label>Particular</label>
                <select  form="addRemittanceForm" class="form-control" name="particular" id="" required>
                    <option value="">Please select one</option>
                    <option value="Rent">Rent</option>
                </select>
                
            </div>

            <div class="form-group">
                <label>Amount</label>
                <input form="addRemittanceForm" type="number" min="1" class="form-control" name="amt" step="0.001" required>
                
            </div>
        </div>
        <div class="modal-footer">
            <button form="addRemittanceForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Add</button>
            </div>
    </div>
    </div>
  </div>
  

@endif
@endsection

@section('scripts')
  
@endsection



