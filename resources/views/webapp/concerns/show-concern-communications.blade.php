@extends('layouts.argon.main')

@section('title', 'Concerns')

@section('css')
<style>
    /*This will work on every browser*/
    thead tr:nth-child(1) th {
        background: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }
</style>
@endsection

@section('upper-content')
<div class="row align-items-center py-4">
    <div class="col-lg-6">
        <h6 class="h2 text-dark d-inline-block mb-0">Communications</h6>

    </div>

</div>

<p class="text-center"> <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addResponse"><i
            class="fas fa-plus"></i>
        Add</a> </p>

<div class="row">
    <div class="col">
        <div class="list-group list-group-flush">
            <span class="list-group-item list-group-item-action">
                <div class="row align-items-center">

                    <div class="col">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 text-sm">Tenant {{ $tenant->tenant_id }}</h4>
                            </div>
                            <div class="text-right text-muted">

                                <small>{{ Carbon\Carbon::parse($concern->reported_at)->diffForHumans() }} </small>


                            </div>
                        </div>
                        <p class="text-sm text-muted mb-0"> {{ $concern->details  }} </p>

                    </div>
                </div>
            </span>
            @foreach ($responses as $item)

            <span class="list-group-item list-group-item-action">
                <div class="row align-items-center">

                    <div class="col">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 text-sm">{{ $item->posted_by }}</h4>
                            </div>
                            <div class="text-right text-muted">

                                <small>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }} </small>


                            </div>
                        </div>
                        <p class="text-sm text-muted mb-0"> {!! $item->response !!}</p>

                    </div>
                </div>
            </span>

            @endforeach

        </div>
        <br>

    </div>

</div>

<div class="modal fade" id="addResponse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content  text-center">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enter your response</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/concern/{{ $concern->concern_id }}/response" method="POST">
                    @csrf
                    <input type="hidden" name="concern_id" value={{ $concern->concern_id }}>

                    <textarea class="form-control" name="response" id="" cols="30" rows="8"
                        placeholder="type your response here..."></textarea required>
          
      
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-block" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check"></i> Submit</button>
        </form>
        </div>
    </div>
    </div>
  
  </div>

@endsection

@section('scripts')

@endsection