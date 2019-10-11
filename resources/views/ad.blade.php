@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif


    <div class="row">
       <div class="col-lg-4">
            <ul class="list-group mt-4 mr-5">
              <li class="list-group-item">{{ $ad['owner']['name'] }}</li>
              <li class="list-group-item">{{ $ad['category'][0]['display_name'] }}</li>
              <li class="list-group-item">{{ $ad['year'] }}</li>
              <li class="list-group-item">{{ $ad['range'] }}</li>
            </ul>
        </div>

        <div class="col-lg-8">
          <div class="card mt-4">
            <img class="card-img-top img-fluid" src="{{ Storage::url('cars/'.$ad['image']) }}" alt="">
            <div class="card-body">
              <h3 class="card-title">{{ $ad['name'] }}</h3>
              <h4>${{ $ad['price'] }}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

