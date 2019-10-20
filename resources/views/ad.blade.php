@extends('layouts.app')

@section('content')
<div class="container">
    @if (!$ad->approved && $ad->owner_id !== Auth::user()->id)
        <div class="alert alert-danger" role="alert">Invalid product url, you will be redirected to the home page.</div>
        <div class="row justify-content-center mt-5"><img src="/images/not-found.png" width="40%" /></div>
        <script> setTimeout(function(){window.location='/home'}, 5000); </script>
    @endif 

    @if(!$ad->approved && $ad->owner_id === Auth::user()->id)
        <div class="alert alert-primary" role="alert">
            <div class="jumbotron-fluid mt-3 mb-3">
                <div class="container">
                    <h3 class="h3"><i class="fas fa-info-circle"></i> <b>Unlisted</b></h3>
                    <h5 class="mt-3">
                      This ad is currently only visible to you as it's pending approval.
                    </h5>
                </div>
            </div>
        </div>
    @elseif ($ad->approved) 
        <b></b>
    @endif
        <div class="row">
            <div class="col-lg-3">
                <ul class="list-group mr-3">
                    <a href="/home" class="list-group-item list-group-item-action list-group-item-dark"><i class="fas fa-arrow-left"></i> &nbsp;Go Back</a>
                    <a href="/search?category={{ $ad->category()->first()->name }}" class="list-group-item list-group-item-action"><b>Category:</b> {{ $ad->category()->first()->display_name }}</a>
                    <a href="#" class="list-group-item list-group-item-action"><b>Year:</b> {{ $ad->year }}</a>
                </ul>
            </div>

            <div class="col-lg-9">
                <div class="card">
                    <img class="card-img-top img-fluid" src="{{ $ad->image }}" alt="">
                    <div class="card-body">
                        <div class="float-left">
                            <h3 class="card-title"><b>{{ $ad->name }}</b></h3>
                            <h4 class="card-subtitle">${{ $ad->price }}</h4>
                        </div>

                        <ul class="list-group list-group-horizontal float-right mt-2">
                            <li class="list-group-item">{{ $ad->owner()->first()->name ?? 'Unregistered' }}</li>
                            <li class="list-group-item">{{ $ad->range }} Km</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection

