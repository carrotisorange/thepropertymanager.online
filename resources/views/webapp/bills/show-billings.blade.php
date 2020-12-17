@extends('templates.webapp.template')

@section('title', $tenant->first_name.' '.$tenant->last_name)

@section('sidebar')
   
      
           <!-- Heading -->
      
          <!-- Nav Item - Pages Collapse Menu -->
          <li class="nav-item">
                <a class="nav-link" href="/board">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span></a>
              </li>
      
            <hr class="sidebar-divider">
      
            <div class="sidebar-heading">
              Interface
            </div>  
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
          <li class="nav-item">
            <a class="nav-link" href="/home">
              <i class="fas fa-home"></i>
              <span>Home</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/calendar">
              <i class="fas fa-calendar-alt"></i>
              <span>Calendar</span></a>
          </li>
          @endif
        
          @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
            <li class="nav-item active">
              <a class="nav-link" href="/tenants">
                <i class="fas fa-users fa-chart-area"></i>
                <span>Tenants</span></a>
            </li>
            @endif
      
       @if((Auth::user()->user_type === 'admin' && Auth::user()->property_ownership === 'Multiple Owners') || (Auth::user()->user_type === 'manager' && Auth::user()->property_ownership === 'Multiple Owners'))
        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="/owners">
            <i class="fas fa-user-tie"></i>
            <span>Owners</span></a>
        </li>
         @endif
      
         <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="/concerns">
          <i class="far fa-comment-dots"></i>
              <span>Concerns</span></a>
        </li>
    
        @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
        <li class="nav-item">
            <a class="nav-link" href="/joborders">
              <i class="fas fa-tools fa-table"></i>
              <span>Job Orders</span></a>
        </li>
        @endif
      
             <!-- Nav Item - Tables -->
        @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
          <li class="nav-item">
            <a class="nav-link collapsed" href="/personnels" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-user-cog"></i>
                <span>Personnels</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item" href="/housekeeping">Housekeeping</a>
                  <a class="collapse-item" href="/maintenance">Maintenance</a>
                </div>
              </div>
            </li>
        @endif
      
           @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <!-- Nav Item - Tables -->
            <li class="nav-item active">
              <a class="nav-link" href="/bills">
                <i class="fas fa-file-invoice-dollar fa-table"></i>
                <span>Bills</span></a>
            </li>
           @endif
      
           @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
              <li class="nav-item">
              <a class="nav-link" href="/collections">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Collections</span></a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/financials">
                <i class="fas fa-coins"></i>
                <span>Financials</span></a>
            </li>
            @endif
      
               @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
            <a class="nav-link" href="/payables">
            <i class="fas fa-hand-holding-usd"></i>
              <span>Payables</span></a>
          </li>
          @endif
      
          @if(Auth::user()->user_type === 'manager')
           <!-- Nav Item - Tables -->
           <li class="nav-item">
            <a class="nav-link" href="/users">
              <i class="fas fa-user-circle"></i>
              <span>Users</span></a>
          </li>
          @endif
          
          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">
      
          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>
    
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">{{ $tenant->first_name.' '.$tenant->middle_name.' '.$tenant->last_name }}</h1>
</div>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-bills-tab" data-toggle="tab" href="#bills" role="tab" aria-controls="nav-bills" aria-selected="true"><i class="fas fa-file-invoice-dollar fa-sm text-primary-50"></i> Bills <span class="badge badge-primary badge-counter">{{ $balance->count() }}</span></a>
    <a class="nav-item nav-link" id="nav-payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="nav-payments" aria-selected="false"> <i class="fas fa-money-bill fa-sm text-primary-50"></i> Payments </a>
    {{-- <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a> --}}
  </div>
</nav>

<div class="tab-content" id="nav-tabContent">
  <br>
  <div class="tab-pane fade show active" id="bills" role="tabpanel" aria-labelledby="nav-bills-tab">
    <a href="/board" class="btn btn-primary"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Dashboard</a>

    @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
    <a href="/tenants/search" class="btn btn-primary"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Tenants</a>
    @else
    <a href="/units/{{ $tenant->unit_tenant_id }}/tenants/{{ $tenant->tenant_id }}" class="btn btn-primary"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Tenant</a>
    @endif
    
    @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
    <a href="/units/{{ $tenant->unit_tenant_id }}/tenants/{{ $tenant->tenant_id }}/billings/edit" class="btn btn-primary"><i class="fas fa-edit fa-sm text-gray-50"></i> Edit</a>
    @endif
    
      @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing')

      @if($balance->count() > 0)
      <a  target="_blank" href="/units/{{ $tenant->unit_tenant_id }}/tenants/{{ $tenant->tenant_id }}/bills/download" class="btn btn-primary"><i class="fas fa-download fa-sm text-white-50"></i> Export </span></a>
      @if($tenant->email_address !== null)
      <a  target="_blank" href="/units/{{ $tenant->unit_tenant_id }}/tenants/{{ $tenant->tenant_id }}/bills/send" class="btn btn-primary"><i class="fas fa-paper-plane  fa-sm text-white-50"></i> Send </span></a>
      @endif
      @endif
    
    
    @endif

    <div class="row">
      <div class="col-md-11 mx-auto">
        <br>
        <p>
          <b>Date:</b> {{ Carbon\Carbon::now()->firstOfMonth()->format('M d Y') }}
          <br>
          <span class="text-danger"><b>Due Date:</b> {{ Carbon\Carbon::now()->firstOfMonth()->addDays(7)->format('M d Y') }}</span>
          <br>
          <b>To:</b> {{ $tenant->first_name.' '.$tenant->last_name }}
          <br>
          <b>Room:</b> {{ $room->building.' '.$room->unit_no }}</b>
         
        </p>
        <p class="text-right">Statement of Accounts  
         
        </p>
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <?php $ctr=1; ?>
            <tr>
            <th>#</th>
              <th>Bill No</th>
             
              <th>Description</th>
              <th>Period Covered</th>
              <th class="text-right" colspan="3">Amount</th>
              
            </tr>
            @foreach ($balance as $item)
            <tr>
              <th>{{ $ctr++ }}</th>   
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
           <th>Total</th>
           <th class="text-right">{{ number_format($balance->sum('balance'),2) }} </th>
          </tr>
          @if($tenant->tenant_status === 'pending')
    
          @else
           <tr>
            <th class="text-danger">Total After Due Date(+10%)</th>
            <th class="text-right text-danger">{{ number_format($balance->sum('balance') + ($balance->sum('balance') * .1) ,2) }}</th>
           </tr> 
          @endif   
        </table>
      </div>
      </div>
    </div>


      
      <p>{!! Auth::user()->note !!}</p>


  </div>
  <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="nav-payments-tab">
    
    @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
    <a href="#" data-toggle="modal" data-target="#acceptPayment" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>
    @endif 
    <div class="row">
      <div class="col-md-11 mx-auto">
        <br>
        <div class="table-responsive text-nowrap">
          <table class="table">
           
              @foreach ($collections as $day => $collection_list)
                <tr>
                  <th colspan="12">{{ Carbon\Carbon::parse($day)->addDay()->format('M d Y') }} ({{ $collection_list->count() }}) </th>
                </tr>
                <?php $ctr=1;?>
                <tr>
                  <th class="text-center">#</th>
                    <th>AR No</th>
                    <th>Bill No</th>
                    <th>Room</th>  
                    <th>Description</th>
                    <th colspan="2">Period Covered</th>
                    <th>Form of Payment</th>
                    <th class="text-right">Amount</th>
                    <th colspan="2">Action</th>
                  </tr>
              </tr>
                @foreach ($collection_list as $item)
                <tr>
                        <th class="text-center">{{ $ctr++ }}</th>
                        <td>{{ $item->ar_no }}</td>
                        <td>{{ $item->payment_bill_no }}</td>
                          <td>{{ $item->building.' '.$item->unit_no }}</td> 
                         <td>{{ $item->particular }}</td> 
                         <td colspan="2">
                          {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} -
                          {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }}
                        </td>
                        <td>{{ $item->form }}</td>
                        <td class="text-right">{{ number_format($item->amt_paid,2) }}</td>
                        
                        <td class="text-center">
                          <a title="export" target="_blank" href="/units/{{ $item->unit_tenant_id }}/tenants/{{ $item->tenant_id }}/payments/{{ $item->payment_id }}/dates/{{$item->payment_created}}/export" class="btn btn-primary"><i class="fas fa-download fa-sm text-white-50"></i></a>
                          {{-- <a target="_blank" href="#" title="print invoice" class="btn btn-primary"><i class="fas fa-print fa-sm text-white-50"></i></a> 
                          --}}
                        </td>
                        <td>
                          @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager') 
                          <form action="/tenants/{{ $item->tenant_id }}/payments/{{ $item->payment_id }}" method="POST">
                            @csrf
                            @method('delete')
                            <button title="remove" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  onclick="return confirm('Are you sure you want perform this action?');"><i class="fas fa-times fa-sm text-white-50"></i></button>
                          </form>
                          @endif 
                        </td>   
                       
                    </tr>
                @endforeach
                    <tr>
                      <th>Total</th>
                      <th colspan="8" class="text-right">{{ number_format($collection_list->sum('amt_paid'),2) }}</th>
                  
                    </tr>
                    
              @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
</div>


<br>
{{-- Modal for editing payment footer message --}}
<div class="modal fade" id="editPaymentFooter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Enter Footer Message</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
         <form id="editPaymentFooterForm" action="/users/{{ Auth::user()->id }}" method="POST">
          @method('put')
          {{ csrf_field() }}
         </form>
          <textarea form="editPaymentFooterForm" class="form-control" name="note" id="" cols="30" rows="10">
          {{ Auth::user()->note }}
          </textarea>
        <input form="editPaymentFooterForm" type="hidden" name="action" value="change_footer_message">
      </div>
      <div class="modal-footer">
            {{-- <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times fa-sm text-white-50"></i> Cancel</button> --}}
            <button form="editPaymentFooterForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to perform this action?');" ><i class="fas fa-check fa-sm text-white-50"></i> Submit</button>
        </div>
  </div>
  </div>

</div>

{{-- modal for adding payments. --}}

<div class="modal fade" id="acceptPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Payment</h5>
    
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
        <form id="acceptPaymentForm" action="/payments" method="POST">
        {{ csrf_field() }}
        </form>
        
        <div class="row">
            <div class="col-md-6">
                <small for="">Date</small>
            {{-- <input form="acceptPaymentForm" type="date" class="form-control" name="payment_created" value={{date('Y-m-d')}} required> --}}
            <input  class='form-control col-md-6' type="date" form="acceptPaymentForm" class="" name="payment_created" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required >
            </div>
            <div class="col-md-6">
              <small for="">Acknowledgment Receipt No</small>
              <input class='form-control col-md-6' form="acceptPaymentForm" type="text" class="" id="" name="ar_no" value="{{ $payment_ctr }}" required readonly>
          </div>
        </div>
      
    <hr>

        <div class="row">
          <div class="col-md-12">
         
            <p class="text-left">
              <a href="#/" id='delete_payment' class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-times-circle fa-sm text-white-50"></i> Remove</a>
            <a href="#/" id="add_payment" class="btn btn-primary" ><i class="fas fa-check-circle fa-sm text-white-50"></i> Add</a>     
            </p>
              <div class="table-responsive text-nowrap">
              <table class = "table table-bordered" id="payment">
                  <tr>
                      <th>#</th>
                      <th>Bill</th>
                      <th>Amount</th>
                      <th>Form of Payment</th>
                      <th>Bank Name</th>
                      <th>Cheque No</th>
                  </tr>
                      <input form="acceptPaymentForm" type="hidden" id="no_of_payments" name="no_of_payments" >
                  <tr id='payment1'></tr>
              </table>
            </div>
          </div>
        </div>        
     
        <input type="hidden" form="acceptPaymentForm" id="payment_tenant_id" name="payment_tenant_id" value="{{ $tenant->tenant_id }}">
        <input type="hidden" form="acceptPaymentForm" id="unit_tenant_id" name="unit_tenant_id" value="{{ $tenant->unit_tenant_id }}">
        <input type="hidden" form="acceptPaymentForm" id="tenant_status" name="tenant_status" value="{{ $tenant->tenant_status }}">
      <hr>
       
    </div>
    <div class="modal-footer">
        {{-- <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times fa-sm text-white-50"></i> Cancel</button> --}}
        <button form="acceptPaymentForm" id ="addPaymentButton" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" ><i class="fas fa-check fa-sm text-white-50f"></i> Submit</button>
    </div>

</div>
</div>


</div>

<div class="modal fade" id="addBill" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content">
  <div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Enter Bill Information </h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
  </div>
 <div class="modal-body">
  <form id="addBillForm" action="/billings/" method="POST">
     @csrf
  </form>
 
  <input type="hidden" form="addBillForm" name="action" value="add_move_in_charges" required>
  <input type="hidden" form="addBillForm" name="tenant_id" value="{{ $tenant->tenant_id }}" required>
  
  <div class="row">
    <div class="col">
        <small>Billing Date</small>
        {{-- <input type="date" form="addBillForm" class="form-control" name="date_posted" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required > --}}
        <input type="date" form="addBillForm" class="" name="date_posted" value="{{ Carbon\Carbon::parse($tenant->movein_date)->format('Y-m-d') }}" required >
    </div>
  </div>
 
  <br>
  <div class="row">
    <div class="col">
   
      <p class="text-left">
        <span id='delete_row' class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-minus fa-sm text-white-50"></i> Remove Bill</span>
      <span id="add_row" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Add Bill</span>     
      </p>
        <div class="table-responsive text-nowrap">
        <table class = "table table-bordered" id="tab_logic">
            <tr>
                <th>#</th>
                <th>Description</th>
                <th colspan="2">Period Covered</th>
                <th>Amount</th>
                
            </tr>
                <input form="addBillForm" type="hidden" id="no_of_items" name="no_of_items" >
            <tr id='addr1'></tr>
        </table>
      </div>
    </div>
  </div>
 
</div>
<div class="modal-footer">
 {{-- <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times fa-sm text-white-50"></i> Close</button> --}}
 <button form="addBillForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;" ><i class="fas fa-check fa-sm text-white-50"></i> Submit</button>
</div> 
</div>
</div>

</div>


@endsection

@section('scripts')



<script>
  $(document).ready(function () {

      $("#addPaymentButton").submit(function (e) {

          //disable the submit button
          $("#addPaymentButton").attr("disabled", true);
       
          return true;

      });
  });
</script>

<script type="text/javascript">

//adding moveout charges upon moveout
  $(document).ready(function(){
  var j=1;
  $("#add_payment").click(function(){
      $('#payment'+j).html("<th>"+ (j) +"</th><td><select class='form-control' form='acceptPaymentForm' name='bill_no"+j+"' id='bill_no"+j+"' required><option >Please select bill</option> @foreach ($balance as $item)<option value='{{ $item->bill_no.'-'.$item->bill_id }}'> Bill No {{ $item->bill_no }} | {{ $item->particular }} | {{ $item->start? Carbon\Carbon::parse($item->start)->format('M d Y') : null}} - {{ $item->end? Carbon\Carbon::parse($item->end)->format('M d Y') : null }} | {{ number_format($item->balance,2) }} </option> @endforeach </select></td><td><input class='form-control'  form='acceptPaymentForm' name='amt_paid"+j+"' id='amt_paid"+j+"' type='number' min='1' step='0.01' required></td><td><select class='form-control'  form='acceptPaymentForm' name='form"+j+"' required><option value='Cash'>Cash</option><option value='Bank Deposit'>Bank Deposit</option><option value='Cheque'>Cheque</option></select></td><td>  <input class='form-control'  form='acceptPaymentForm' type='text' name='bank_name"+j+"'></td><td><input class='form-control'  form='acceptPaymentForm' type='text' name='cheque_no"+j+"'></td>");


   $('#payment').append('<tr id="payment'+(j+1)+'"></tr>');
   j++;
   document.getElementById('no_of_payments').value = j;

  });

  $("#delete_payment").click(function(){
      if(j>1){
      $("#payment"+(j-1)).html('');
      j--;
      document.getElementById('no_of_payments').value = j;
      }
  });
});
</script>
@endsection



