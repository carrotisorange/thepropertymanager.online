@extends('layouts.argon.main')

@section('title', 'Results for ' .'"'.$search_key.'"')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0"><span class=""> <small> you searched for </small></span> <span class="text-danger">"{{ $search_key }}"<span></h6>
  </div>

</div>
<div class="row">
    <div class="table-responsive text-nowrap">
       <div class="col-md-12">
        <p><span class="font-weight-bold">{{ $all_tenants->count() }}</span> matched for tenants...</p>
        @if($all_tenants->count() >= 1  )
        <table class="table">
            <tr>
                <th>#</th>
                <th>Name</th>
        
                <th>Email</th>
                <th>Mobile</th>
    
                <th>Civil status</th>
              
            </tr>
            <?php $tenant_ctr=1;?>
            @foreach ($all_tenants as $tenant)
            <tr>
                <th>{{ $tenant_ctr++ }}</th>
                <td><a href="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}">{{ $tenant->first_name.' '.$tenant->middle_name.' '.$tenant->last_name }}</a></td>
                
              
                <td>{{ $tenant->email_address }}</td>
                <td>{{ $tenant->contact_no }}</td>
        
                <td>{{ $tenant->civil_status }}</td>
               
            </tr>
            @endforeach
            
         </table>
        @endif
         <br>

         <p><span class="font-weight-bold">{{ $units->count() }}</span> matched for rooms...</p>
         @if($units->count() >= 1  )
        <table class="table">
            <tr>
                <th>#</th>
                <th>Building</th>
                <th>Room</th>
                <th>Floor</th>
                <th>Type</th>
          
                <th>Status</th>
                <th>Occupancy</th>
                <th>Rent</th>
            </tr>
            <?php $unit_ctr=1;?>
            @foreach ($units as $unit)
            <tr>
                <th>{{ $unit_ctr++ }}</th>
                <td>{{ $unit->building }}</td>
                <td>
                  @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex'){
                    <a href="/property/{{Session::get('property_id')}}/unit/{{ $unit->unit_id }}">{{ $unit->unit_no }}</a>
               @else
               <a href="/property/{{Session::get('property_id')}}/room/{{ $unit->unit_id }}">{{ $unit->unit_no }}</a>
                 @endif
                </td>
                <td>{{ $unit->floor }}</td>
                <td>{{ $unit->type }}</td>
                <td>{{ $unit->status }}</td>
                <td>{{ $unit->occupancy }} pax</td>
                <td>{{ number_format($unit->rent, 2) }}</td>
            </tr>
            @endforeach
         </table>
          @endif
         <br>

         <p><span class="font-weight-bold">{{ $all_owners->count() }}</span> matched for owners...</p>
         @if($all_owners->count() >= 1  )
        <table class="table">
            <tr>
                <th>#</th>
                <th>Name</th>
                
                <th>Email</th>
                <th>Mobile</th>
                <th>Representative</th>
       
             
            </tr>
            <?php $owner_ctr=1;?>
            @foreach ($all_owners as $owner)
            <tr>
                <th>{{ $owner_ctr++ }}</th>
                <td><a href="/property/{{Session::get('property_id')}}/owner/{{ $owner->owner_id }}">{{ $owner->name }} </a></td>
              
               <td>{{ $owner->email}}</td>
               <td>{{ $owner->mobile }}</td>
               <td>{{ $owner->representative }}</td>
             
              

             
            </tr>
            @endforeach
    
         </table>
         @endif
       </div>
        
    </div>
</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



