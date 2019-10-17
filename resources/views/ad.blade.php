@extends('layouts.app')

@section('content')
<div class="container">
    @if (empty($ad))
      <div class="alert alert-danger" role="alert">
        Invalid product url, you will be redirected to the home page.
      </div>

      <div class="row justify-content-center mt-5">
        <img src="/images/not-found.png" width="40%" />
      </div>
      <script> setTimeout(function(){window.location='/home'}, 5000); </script>
    @else

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-arrow-left"></i> &nbsp;Go Back</a></li>
      </ol>
    </nav>

      <div class="row">
         <div class="col-lg-4">
              <ul class="list-group mt-4 mr-5">
                <li class="list-group-item"><b>Owner:</b> {{ $ad['owner']['name'] }}</li>
                <li class="list-group-item"><b>Category:</b> {{ $ad['category'][0]['display_name'] }}</li>
                <li class="list-group-item"><b>Year:</b> {{ $ad['year'] }}</li>
                <li class="list-group-item"><b>Range:</b> {{ $ad['range'] }}</li>
              </ul>
          </div>

          <div class="col-lg-8">
            <div class="card mt-4">
              <img class="card-img-top img-fluid" src="{{ $ad['image'] }}" alt="">
              <div class="card-body">
                <h3 class="card-title">{{ $ad['name'] }}</h3>
                <h4>${{ $ad['price'] }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
</div>
@endsection

