@extends('layouts.argon.main')

@section('title', 'Expiring contracts')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Watchout for expired and expiring contracts ({{ $tenants_to_watch_out->count() }})...</h6>
    
  </div>
  

</div>
<div class="row">
    <div class="col">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered table-condensed" >
            <thead>
        
              <tr>
         
                <th>Tenant</th>
                <th>Room</th>
                <th>Moveout</th>
               
                <th>Status</th>
                <th>Mobile</th>
                {{-- <th>Action</th> --}}
             
            </tr>
            </thead>
            <tbody>
              @foreach($tenants_to_watch_out as $item)
             
               <tr>
     
                   <th>
                     <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}#contracts">{{ $item->first_name.' '.$item->last_name }}  
                     </th>
                   <th>
                     @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                     <a href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a>
                    @else
                    <a href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}">{{ $item->building.' '.$item->unit_no }}</a>
                    @endif
                    
                   </th>
                   <td>{{Carbon\Carbon::parse($item->moveout_at)->format('M d Y')}} <span class="text-danger">({{ Carbon\Carbon::parse($item->moveout_at)->diffForHumans() }})</span></td>
                   
                   <td>
                     @if($item->contract_status === 'active')
                    <span class="text-success"><i class="fas fa-check-circle"></i> {{ $item->contract_status }}</span>
                     @else
                     <span class="text-warning"><i class="fas fa-clock"></i> {{ $item->contract_status }}</span>
           
                     @endif
                   </td>
                   {{-- <td>
                     @if($item->email_address === null)
                     <a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}/edit#email_address" class="badge badge-danger">Please add an email</a>
                     @else
                     <form action="/property/{{Session::get('property_id')}}/home/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/contract/{{ $item->contract_id }}/alert">
                       @csrf
                       @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin')
                       <button class="btn btn-sm btn btn-primary" type="submit" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-paper-plane fa-sm text-white-50"></i> Send email</button>
                       @else
                       <button class="btn btn-sm btn btn-primary" title="for manager and admin access only" type="submit" onclick="this.form.submit(); this.disabled = true;" disabled><i class="fas fa-paper-plane fa-sm text-white-50"></i> Send Email</button>
                       @endif
                     </form>
                     @endif
                   </td> --}}
                 <td>{{ $item->contact_no }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
            </div>
    </div>
</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



