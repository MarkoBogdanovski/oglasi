@extends('layouts.app')

@section('content')
<div class="container justify-content-center">
    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif

        <div class="d-flex flex-row flex-wrap justify-content-center" id="ads">
            @foreach($ads as $ad)
              <div class="card m-2 shadow-sm mb-5 ml-3 mr-3">
                <div class="card-img-top" style="max-height: 15rem; position: relative;overflow: hidden;">
                  <img src="{{ $ad['image'] }}" class="img-fluid"/>
                </div>
                <div class="card-body">
                <h5 class="card-title">{{$ad['name']}}</h5>
                <h6 class="card-subtitle mb-2 text-muted">${{$ad['price']}}</h6>
                  <div class="d-flex justify-content-end align-items-right">
                    <a href="/{{$ad['id']}}/{{$ad['name']}}" class="btn btn-light stretched-link pl-5 pr-5">View</a>
                  </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted"><td>{{  strftime("%d %b %Y",strtotime($ad->created_at)) }}</td></small>
                </div>
              </div>
            @endforeach
            {{ $ads->links() }}
        </div>
</div>
@endsection
