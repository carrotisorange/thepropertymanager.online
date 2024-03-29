@extends('layouts.argon.main')

@section('title', $tenant->first_name.' '.$tenant->last_name)

@section('css')

@endsection

@section('upper-content')
<div class="row align-items-center py-4">
    <div class="col-lg-6 text-left">
        <h6 class="h2 text-dark d-inline-block mb-0">Edit tenant</h6>
    </div>
</div>
{{-- <div class="row align-items-center py-4">
  <div class="col-auto text-left">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}/#profile">{{ $tenant->first_name.' '.$tenant->last_name }}</a>
</li>

<li class="breadcrumb-item active" aria-current="page">Edit Tenant</li>
</ol>
</nav>


</div>

</div> --}}

<form id="editTenantForm" action="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}"
    method="POST">
    @method('put')
    {{ csrf_field() }}
</form>

<div class="form-group row">
    <div class="col">
        <label>First Name</label>
        <input form="editTenantForm" class="form-control" type="text" name="first_name"
            value="{{ $tenant->first_name }}">
    </div>
    <div class="col">
        <label>Middle Name</label>
        <input form="editTenantForm" class="form-control" type="text" name="middle_name"
            value="{{ $tenant->middle_name }}">
    </div>
    <div class="col">
        <label>Last Name</label>
        <input form="editTenantForm" class="form-control" type="text" name="last_name" value="{{ $tenant->last_name }}">
    </div>
</div>


<div class="form-group row">
    <div class="col">
        <label for="">Mobile</label>
        <input form="editTenantForm" class="form-control" type="text" name="contact_no"
            value="{{ $tenant->contact_no }}">
    </div>
    {{-- <div class="col" id="email_address">
                  <label for="">Email</label>
                  <input form="editTenantForm" class="form-control" type="text" name="email_address" value="{{ $tenant->email_address }}">
    @if($tenant->email_address === null)
    <small class="text-danger">Please add an email</small>
    @endif
</div> --}}
<div class="col">
    <label for="">Type</label>
    <select form="editTenantForm" name="type_of_tenant" id="type_of_tenant" class="form-control" onchange="openForm()"
        required>
        <option value="{{ $tenant->type_of_tenant }}">{{ $tenant->type_of_tenant }}</option>
        <option value="studying">studying</option>
        <option value="working">working</option>
    </select>
</div>

</div>

<div class="form-group row">
    <div class="col">
        <label>Gender</label>
        <select form="editTenantForm" class="form-control" name="gender" id="">
            <option value="{{ $tenant->gender }}">{{ $tenant->gender }}</option>
            <option value="female">female</option>
            <option value="male">male</option>
        </select>
    </div>
    <div class=" col">
        <label>Birthdate</label>
        <input form="editTenantForm" class="form-control" type="date" name="birthdate" value="{{ $tenant->birthdate }}">
    </div>
    <div class="col">
        <label>Civil Status</label>
        <select form="editTenantForm" id="civil_status" name="civil_status" class="form-control">
            <option value="{{ $tenant->civil_status }}" selected>{{ $tenant->civil_status }}</option>
            <option value="single" selected>single</option>
            <option value="married">married</option>
        </select>
    </div>
    <div class=" col">
        <label>ID/ID number</label>
        <input form="editTenantForm" class="form-control" type="text" name="id_number" value="{{ $tenant->id_number }}">
    </div>
</div>

<div class="form-group row">
    <div class=" col-md-8">
        <label for="">Barangay</label>
        <input form="editTenantForm" class="form-control" type="text" name="barangay" value="{{ $tenant->barangay }}">
    </div>
    <div class=" col-md-4">
        <label for="">City</label>
        <input form="editTenantForm" class="form-control" type="text" name="city" value="{{ $tenant->city }}">
    </div>

</div>
<div class="form-group row">
    <div class=" col-md-4">
        <label for="">Province</label>
        <input form="editTenantForm" class="form-control" type="text" name="province" value="{{ $tenant->province }}">
    </div>
    <div class=" col-md-4">
        <label for="">Country</label>
        <select form="editTenantForm" class="form-control" name="country">
            <option value="{{$tenant->country}}">{{$tenant->country}}</option>
            <option value="Afganistan">Afghanistan</option>
            <option value="Albania">Albania</option>
            <option value="Algeria">Algeria</option>
            <option value="American Samoa">American Samoa</option>
            <option value="Andorra">Andorra</option>
            <option value="Angola">Angola</option>
            <option value="Anguilla">Anguilla</option>
            <option value="Antigua & Barbuda">Antigua & Barbuda</option>
            <option value="Argentina">Argentina</option>
            <option value="Armenia">Armenia</option>
            <option value="Aruba">Aruba</option>
            <option value="Australia">Australia</option>
            <option value="Austria">Austria</option>
            <option value="Azerbaijan">Azerbaijan</option>
            <option value="Bahamas">Bahamas</option>
            <option value="Bahrain">Bahrain</option>
            <option value="Bangladesh">Bangladesh</option>
            <option value="Barbados">Barbados</option>
            <option value="Belarus">Belarus</option>
            <option value="Belgium">Belgium</option>
            <option value="Belize">Belize</option>
            <option value="Benin">Benin</option>
            <option value="Bermuda">Bermuda</option>
            <option value="Bhutan">Bhutan</option>
            <option value="Bolivia">Bolivia</option>
            <option value="Bonaire">Bonaire</option>
            <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
            <option value="Botswana">Botswana</option>
            <option value="Brazil">Brazil</option>
            <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
            <option value="Brunei">Brunei</option>
            <option value="Bulgaria">Bulgaria</option>
            <option value="Burkina Faso">Burkina Faso</option>
            <option value="Burundi">Burundi</option>
            <option value="Cambodia">Cambodia</option>
            <option value="Cameroon">Cameroon</option>
            <option value="Canada">Canada</option>
            <option value="Canary Islands">Canary Islands</option>
            <option value="Cape Verde">Cape Verde</option>
            <option value="Cayman Islands">Cayman Islands</option>
            <option value="Central African Republic">Central African Republic</option>
            <option value="Chad">Chad</option>
            <option value="Channel Islands">Channel Islands</option>
            <option value="Chile">Chile</option>
            <option value="China">China</option>
            <option value="Christmas Island">Christmas Island</option>
            <option value="Cocos Island">Cocos Island</option>
            <option value="Colombia">Colombia</option>
            <option value="Comoros">Comoros</option>
            <option value="Congo">Congo</option>
            <option value="Cook Islands">Cook Islands</option>
            <option value="Costa Rica">Costa Rica</option>
            <option value="Cote DIvoire">Cote DIvoire</option>
            <option value="Croatia">Croatia</option>
            <option value="Cuba">Cuba</option>
            <option value="Curaco">Curacao</option>
            <option value="Cyprus">Cyprus</option>
            <option value="Czech Republic">Czech Republic</option>
            <option value="Denmark">Denmark</option>
            <option value="Djibouti">Djibouti</option>
            <option value="Dominica">Dominica</option>
            <option value="Dominican Republic">Dominican Republic</option>
            <option value="East Timor">East Timor</option>
            <option value="Ecuador">Ecuador</option>
            <option value="Egypt">Egypt</option>
            <option value="El Salvador">El Salvador</option>
            <option value="Equatorial Guinea">Equatorial Guinea</option>
            <option value="Eritrea">Eritrea</option>
            <option value="Estonia">Estonia</option>
            <option value="Ethiopia">Ethiopia</option>
            <option value="Falkland Islands">Falkland Islands</option>
            <option value="Faroe Islands">Faroe Islands</option>
            <option value="Fiji">Fiji</option>
            <option value="Finland">Finland</option>
            <option value="France">France</option>
            <option value="French Guiana">French Guiana</option>
            <option value="French Polynesia">French Polynesia</option>
            <option value="French Southern Ter">French Southern Ter</option>
            <option value="Gabon">Gabon</option>
            <option value="Gambia">Gambia</option>
            <option value="Georgia">Georgia</option>
            <option value="Germany">Germany</option>
            <option value="Ghana">Ghana</option>
            <option value="Gibraltar">Gibraltar</option>
            <option value="Great Britain">Great Britain</option>
            <option value="Greece">Greece</option>
            <option value="Greenland">Greenland</option>
            <option value="Grenada">Grenada</option>
            <option value="Guadeloupe">Guadeloupe</option>
            <option value="Guam">Guam</option>
            <option value="Guatemala">Guatemala</option>
            <option value="Guinea">Guinea</option>
            <option value="Guyana">Guyana</option>
            <option value="Haiti">Haiti</option>
            <option value="Hawaii">Hawaii</option>
            <option value="Honduras">Honduras</option>
            <option value="Hong Kong">Hong Kong</option>
            <option value="Hungary">Hungary</option>
            <option value="Iceland">Iceland</option>
            <option value="Indonesia">Indonesia</option>
            <option value="India">India</option>
            <option value="Iran">Iran</option>
            <option value="Iraq">Iraq</option>
            <option value="Ireland">Ireland</option>
            <option value="Isle of Man">Isle of Man</option>
            <option value="Israel">Israel</option>
            <option value="Italy">Italy</option>
            <option value="Jamaica">Jamaica</option>
            <option value="Japan">Japan</option>
            <option value="Jordan">Jordan</option>
            <option value="Kazakhstan">Kazakhstan</option>
            <option value="Kenya">Kenya</option>
            <option value="Kiribati">Kiribati</option>
            <option value="Korea North">Korea North</option>
            <option value="Korea Sout">Korea South</option>
            <option value="Kuwait">Kuwait</option>
            <option value="Kyrgyzstan">Kyrgyzstan</option>
            <option value="Laos">Laos</option>
            <option value="Latvia">Latvia</option>
            <option value="Lebanon">Lebanon</option>
            <option value="Lesotho">Lesotho</option>
            <option value="Liberia">Liberia</option>
            <option value="Libya">Libya</option>
            <option value="Liechtenstein">Liechtenstein</option>
            <option value="Lithuania">Lithuania</option>
            <option value="Luxembourg">Luxembourg</option>
            <option value="Macau">Macau</option>
            <option value="Macedonia">Macedonia</option>
            <option value="Madagascar">Madagascar</option>
            <option value="Malaysia">Malaysia</option>
            <option value="Malawi">Malawi</option>
            <option value="Maldives">Maldives</option>
            <option value="Mali">Mali</option>
            <option value="Malta">Malta</option>
            <option value="Marshall Islands">Marshall Islands</option>
            <option value="Martinique">Martinique</option>
            <option value="Mauritania">Mauritania</option>
            <option value="Mauritius">Mauritius</option>
            <option value="Mayotte">Mayotte</option>
            <option value="Mexico">Mexico</option>
            <option value="Midway Islands">Midway Islands</option>
            <option value="Moldova">Moldova</option>
            <option value="Monaco">Monaco</option>
            <option value="Mongolia">Mongolia</option>
            <option value="Montserrat">Montserrat</option>
            <option value="Morocco">Morocco</option>
            <option value="Mozambique">Mozambique</option>
            <option value="Myanmar">Myanmar</option>
            <option value="Nambia">Nambia</option>
            <option value="Nauru">Nauru</option>
            <option value="Nepal">Nepal</option>
            <option value="Netherland Antilles">Netherland Antilles</option>
            <option value="Netherlands">Netherlands (Holland, Europe)</option>
            <option value="Nevis">Nevis</option>
            <option value="New Caledonia">New Caledonia</option>
            <option value="New Zealand">New Zealand</option>
            <option value="Nicaragua">Nicaragua</option>
            <option value="Niger">Niger</option>
            <option value="Nigeria">Nigeria</option>
            <option value="Niue">Niue</option>
            <option value="Norfolk Island">Norfolk Island</option>
            <option value="Norway">Norway</option>
            <option value="Oman">Oman</option>
            <option value="Pakistan">Pakistan</option>
            <option value="Palau Island">Palau Island</option>
            <option value="Palestine">Palestine</option>
            <option value="Panama">Panama</option>
            <option value="Papua New Guinea">Papua New Guinea</option>
            <option value="Paraguay">Paraguay</option>
            <option value="Peru">Peru</option>
            <option value="Phillipines">Philippines</option>
            <option value="Pitcairn Island">Pitcairn Island</option>
            <option value="Poland">Poland</option>
            <option value="Portugal">Portugal</option>
            <option value="Puerto Rico">Puerto Rico</option>
            <option value="Qatar">Qatar</option>
            <option value="Republic of Montenegro">Republic of Montenegro</option>
            <option value="Republic of Serbia">Republic of Serbia</option>
            <option value="Reunion">Reunion</option>
            <option value="Romania">Romania</option>
            <option value="Russia">Russia</option>
            <option value="Rwanda">Rwanda</option>
            <option value="St Barthelemy">St Barthelemy</option>
            <option value="St Eustatius">St Eustatius</option>
            <option value="St Helena">St Helena</option>
            <option value="St Kitts-Nevis">St Kitts-Nevis</option>
            <option value="St Lucia">St Lucia</option>
            <option value="St Maarten">St Maarten</option>
            <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
            <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
            <option value="Saipan">Saipan</option>
            <option value="Samoa">Samoa</option>
            <option value="Samoa American">Samoa American</option>
            <option value="San Marino">San Marino</option>
            <option value="Sao Tome & Principe">Sao Tome & Principe</option>
            <option value="Saudi Arabia">Saudi Arabia</option>
            <option value="Senegal">Senegal</option>
            <option value="Seychelles">Seychelles</option>
            <option value="Sierra Leone">Sierra Leone</option>
            <option value="Singapore">Singapore</option>
            <option value="Slovakia">Slovakia</option>
            <option value="Slovenia">Slovenia</option>
            <option value="Solomon Islands">Solomon Islands</option>
            <option value="Somalia">Somalia</option>
            <option value="South Africa">South Africa</option>
            <option value="Spain">Spain</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="Sudan">Sudan</option>
            <option value="Suriname">Suriname</option>
            <option value="Swaziland">Swaziland</option>
            <option value="Sweden">Sweden</option>
            <option value="Switzerland">Switzerland</option>
            <option value="Syria">Syria</option>
            <option value="Tahiti">Tahiti</option>
            <option value="Taiwan">Taiwan</option>
            <option value="Tajikistan">Tajikistan</option>
            <option value="Tanzania">Tanzania</option>
            <option value="Thailand">Thailand</option>
            <option value="Togo">Togo</option>
            <option value="Tokelau">Tokelau</option>
            <option value="Tonga">Tonga</option>
            <option value="Trinidad & Tobago">Trinidad & Tobago</option>
            <option value="Tunisia">Tunisia</option>
            <option value="Turkey">Turkey</option>
            <option value="Turkmenistan">Turkmenistan</option>
            <option value="Turks & Caicos Is">Turks & Caicos Is</option>
            <option value="Tuvalu">Tuvalu</option>
            <option value="Uganda">Uganda</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="Ukraine">Ukraine</option>
            <option value="United Arab Erimates">United Arab Emirates</option>
            <option value="United States of America">United States of America</option>
            <option value="Uraguay">Uruguay</option>
            <option value="Uzbekistan">Uzbekistan</option>
            <option value="Vanuatu">Vanuatu</option>
            <option value="Vatican City State">Vatican City State</option>
            <option value="Venezuela">Venezuela</option>
            <option value="Vietnam">Vietnam</option>
            <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
            <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
            <option value="Wake Island">Wake Island</option>
            <option value="Wallis & Futana Is">Wallis & Futana Is</option>
            <option value="Yemen">Yemen</option>
            <option value="Zaire">Zaire</option>
            <option value="Zambia">Zambia</option>
            <option value="Zimbabwe">Zimbabwe</option>
        </select>
    </div>
    <div class=" col-md-4">
        <label for="">Zip</label>
        <input form="editTenantForm" class="form-control" type="number" name="zip_code" value="{{ $tenant->zip_code }}">
    </div>
</div>



<hr>
<h3>For student...</h3>
<div class="form-group row studying">
    <div class="col">
        <label for="">High School</label>
        <input form="editTenantForm" class="form-control" type="text" name="high_school"
            value="{{ $tenant->high_school }}">
    </div>
    <div class="col">
        <label for="">Adddress</label>
        <input form="editTenantForm" class="form-control" type="text" name="high_school_address"
            value="{{ $tenant->high_school_address }}">
    </div>
</div>
<div class="form-group row studying">
    <div class="col">
        <label for="">College/University</label>
        <input form="editTenantForm" class="form-control" type="text" name="college_school"
            value="{{ $tenant->college_school }}">
    </div>
    <div class="col">
        <label for="">Address</label>
        <input form="editTenantForm" class="form-control" type="text" name="college_school_address"
            value="{{ $tenant->college_school_address }}">
    </div>
</div>
<div class="form-group row studying">
    <div class="col">
        <label for="">Course</label>
        <input form="editTenantForm" class="form-control" type="text" name="course" value="{{ $tenant->course }}">
    </div>
    <div class="col">
        <label for="">Year Level</label>
        <select form="editTenanForm" class="form-control" name="year_level" id="">
            <option value="{{ $tenant->year_level }}">{{ $tenant->year_level }}</option>
            <option value="senior high">junior high</option>
            <option value="first year">first year</option>
            <option value="second year">second year</option>
            <option value="third year">third year</option>
            <option value="fourth year">fourth year</option>
            <option value="fifth year">fifth year</option>
            <option value="graduate student">graduate student</option>
        </select>
    </div>
</div>
<hr>
<h3>For working...</h3>
<div class="form-group row working">
    <div class="col">
        <label for="">Employer/Company</label>
        <input form="editTenantForm" class="form-control" type="text" name="employer" value="{{ $tenant->employer }}">
    </div>
    <div class="col">
        <label for="">Position/Job description</label>
        <input form="editTenantForm" class="form-control" type="text" name="job" value="{{ $tenant->job }}">
    </div>
    <div class="col">
        <label for="">Years of Employment</label>
        <input form="editTenantForm" class="form-control" type="number" name="years_of_employment"
            value="{{ $tenant->years_of_employment }}">
    </div>
</div>
<div class="form-group row working">
    <div class="col">
        <label for="">Address</label>
        <input form="editTenantForm" class="form-control" type="text" name="employer_address"
            value="{{ $tenant->employer_address }}">
    </div>
    <div class="col">
        <label for="">Mobile</label>
        <input form="editTenantForm" class="form-control" type="number" name="employer_contact_no"
            value="{{ $tenant->employer_contact_no }}">
    </div>

</div>
<div class="form-group">
    <button type="submit" form="editTenantForm" class="btn btn-primary btn-block"
        onclick="this.form.submit(); this.disabled = true;"> Save</button>
    <br>
    <p class="text-center">
        <a class="text-center text-dark"
            href="/property/{{ Session::get('property_id') }}/tenant/{{ $tenant->tenant_id }}">Cancel</a>
    </p>
</div>
@endsection

@section('main-content')

@endsection

@section('scripts')
<script>
    function openForm(){
  $type_of_tenant = document.getElementById('type_of_tenant').value;

  if($type_of_tenant === 'studying')
     alert()
  }else{
      $(".studying").hide();

 }
</script>
@endsection