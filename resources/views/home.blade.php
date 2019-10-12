@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif

        <div class="card-columns">
            @foreach($ads as $ad)
              <div class="card m-2 shadow-sm">
                <img src="{{ $ad['image'] }}" class="card-img-top"/>
                <div class="card-body">
                <h5 class="card-title">{{$ad['price']}}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{$ad['category'][0]['display_name']}}</h6>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a  href="/ad/{{$ad['id']}}/approve" class="btn btn-sm btn-outline-success">Approve</a>
                      <a  href="/ad/{{$ad['id']}}/ignore" class="btn btn-sm btn-outline-danger">Ignore</a>
                    </div>
                    <small class="text-muted"><td>{{  strftime("%d %b %Y",strtotime($ad->created_at)) }}</td></small>
                  </div>
                </div>
              </div>
            @endforeach
            {{ $ads->links() }}
        </div>
</div>
@endsection
