@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif


    <div class="card">
          @foreach($ads as $ad)
          <article class="itemlist">
              <div class="row row-sm">
                <aside class="col-sm-3">
                  <div class="img-wrap p-2"><img src="{{ Storage::url('cars/'.$ad->image) }}" class="img-thumbnail rounded border-0" /></div>
                </aside> <!-- col.// -->
                <div class="col-sm-6 pl-0">
                  <div class="text-wrap p-4">
                    <h4 class="title"> {{ $ad->name }}  </h4>
                    <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, Lorem ipsum dolor sit amet, consectetuer adipiscing elit, Ut wisi enim ad minim veniam </p>
                    <p class="rating-wrap my-0 text-muted">
                      <span class="label-rating">132 reviews</span>
                      <span class="label-rating">154 orders </span>
                    </p> <!-- rating-wrap.// -->
                  </div> <!-- text-wrap.// -->
                </div> <!-- col.// -->
                <aside class="col-sm-3">
                  <div class="border-left p-3">
                    <div class="price-wrap">
                      <span class="h3 price"> {{ $ad->price }} </span><!--<del class="price-old"> $98</del>-->
                    </div> <!-- info-price-detail // -->
                    <p class="text-success">Free shipping</p>
                    <p> 
                    <a href="{{ $ad->id }}/{{ $ad->name }}" class="btn btn-primary stretched-link">Details</a>
                    <a href="#" class="btn btn-light disabled"> Buy now  </a> 
                  </p>
                  </div> <!-- action-wrap.// -->
                </aside> <!-- col.// -->
              </div> <!-- row.// -->
            </article> <!-- itemlist.// -->

        @endforeach
    </div>
</div>
@endsection
