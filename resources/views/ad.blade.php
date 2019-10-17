@extends('layouts.app')

@section('content')
<div class="container">
    @if (!$ad->approved && $ad->owner_id !== Auth::user()->id)
        <div class="alert alert-danger" role="alert">Invalid product url, you will be redirected to the home page.</div>
        <div class="row justify-content-center mt-5"><img src="/images/not-found.png" width="40%" /></div>
        <script> setTimeout(function(){window.location='/home'}, 5000); </script>
    @elseif (!$ad->approved && $ad->owner_id === Auth::user()->id)
        <div class="alert alert-warning" role="alert">This ad is yet pending for approval</div>

        <div class="row">
            <div class="col-lg-3">
                <nav aria-label="breadcrumb" class="mr-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-arrow-left"></i> &nbsp;Go Back</a></li>
                    </ol>
                </nav>
                <ul class="list-group mt-4 mr-3">
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
                            <li class="list-group-item">{{ $ad->owner()->first()->name }}</li>
                            <li class="list-group-item">{{ $ad->range }} Km</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

