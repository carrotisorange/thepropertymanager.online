@extends('layouts.argon.main')

@section('title', 'Blogs')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Blogs</h6>
    
  </div>

</div>
<div class="row">
          
    <br>
      <div class="col-md-11 mx-auto">
        <form action="/property/{{Session::get('property_id')}}/blog" method="POST">
          @csrf
          <input class="form-control" type="text" name="title" placeholder="Title" required>
          <br>
          <select class="form-control" name="category" id="" required>
            <option value="">Please select category</option>
            <option value="Condominium & Homeowners Associations">Condominium & Homeowners Associations</option>
            <option value="Investment Property">Investment Property</option>
            <option value="Maintenance & Repair">Maintenance & Repair</option>
            <option value="Property Management">Property Management</option>
            <option value="Real Estate Trends">Real Estate Trends</option>
            <option value="Tenants">Tenants</option>
            <option value="Taxes & Finances">Taxes & Finances</option>
    
          </select>
          <br>
          <p>Body</p>
          <textarea class="form-control" name="body" id="body" cols="20" rows="30" placeholder="Body" required></textarea>
          
          <br>
          
           <input type="hidden" name="property" value="{{Session::get('property_id')}}" class="form-control">
          
          <p class="text-right">                
            <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-share fa-sm text-white-50"></i> share </button>
          </p>
        </form>
      </div>
      <br>
      @foreach ($blogs as $item)
      <div class="col-md-11 mx-auto">
       
        <div class="jumbotron bg-transparent">
          <header class="blockquote-header text-right">{{ $item->category }}</header>
          <h3 class="">{{ $item->title }}</h3>
          <p class="">{!! $item->body !!}</p>
        
          <footer class="blockquote-footer">{{ $item->name }} <cite title="Source Title">on {{ Carbon\Carbon::parse($item->created_at)->format('M d Y') }}</cite></footer>
         
        </div>
      </div>
      @endforeach
</div>

@endsection

@section('main-content')


@section('scripts')
  
@endsection



