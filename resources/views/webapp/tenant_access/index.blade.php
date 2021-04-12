@extends('webapp.tenant_access.template')

@section('title', 'Dashboard')

@section('upper-content')
<div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Dashboard</h6>
    
  </div>


@endsection

@section('main-content')
<div class="card">
  <div class="card-body">
    <?php $explode = explode(" ", Auth::user()->name);?>
    Dear {{ $explode[0] }},
    <p class="text-justify">
        
    <br>
    We value our relationships with our tenants and wanted to reach out to you in these difficult and uncertain times. The COVID-19 pandemic, and the measures being taken to reduce transmission of the virus, will mean adjustments and challenges for all of us. We want to assure you the health and safety of our tenants and employees are our top priorities. We also want you to know that we will be working with you to ensure your housing is secure, despite the challenges ahead.
    <br><br>
    We have asked our maintenance staff to take extra steps to sanitize high-touch surfaces, including door handles, railings etc. in common areas. As a safety precaution, we are reviewing the delivery of in-suite maintenance and repairs to occupied units, to reduce risk to you and to our staff and contractors. We will prioritize urgent repair requests but defer non-urgent in-suite repairs and maintenance, to reduce exposure.
    <br><br>
    We encourage you to use this portal as to transact business with us. Most especially, in reporting your concerns. 
    <br><br>
    Sincerely, 
    <br>
    The Management
  </p>
  </div>
</div>
@endsection

@section('scripts')
  
@endsection



