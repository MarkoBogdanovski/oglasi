@extends('layouts.app')

@section('content')
<div class="container justify-content-center">
        @if (session('success'))
                    <div aria-live="assertive" aria-atomic="true" style="position: relative; z-index: 100; width: 100%;">
                        <div class="toast ml-auto mr-auto mb-4"  role="alert"  data-delay="5000">
                            <div class="toast-header">
                                <svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"><rect width="100%" height="100%" fill="#38c172"></rect></svg>
                                <strong class="mr-auto">Success</strong>
                                <button type="button" class="ml-5 mb-1 close" data-dismiss="toast" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="toast-body">
                                {!! session('success') !!}
                            </div>
                        </div>
                    </div>
                @elseif (session('error'))
                    <div aria-live="assertive" aria-atomic="true" style="position: relative; z-index: 100; width: 100%;">
                        <div class="toast ml-auto mr-auto mb-4"  role="alert"  data-delay="5000">
                            <div class="toast-header">
                                <svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"><rect width="100%" height="100%" fill="#e3342f"></rect></svg>
                                <strong class="mr-auto">Error</strong>
                                <button type="button" class="ml-5 mb-1 close" data-dismiss="toast" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="toast-body">
                                {{ session('error') }}
                            </div>
                        </div>
                    </div>
                @endif

        <div class="d-flex flex-row flex-wrap justify-content-start" id="ads">
            @foreach($ads as $ad)
                <div class="card shadow-sm mb-5 mr-5">
                    <div class="card-img-top" style="height: 15rem; background-size: cover; background-position: center; background-image: url('{{ $ad->image }}')"></div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $ad->name }}</h4>
                        <h5 class="card-subtitle text-muted mt-3">{{ $ad->category()->first()->display_name }}</h5>
                        <div class="d-flex justify-content-end align-items-right">
                            <h5 class="card-subtitle text-primary float-left m-2 ">${{ $ad->price }}</h5>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="/{{$ad->id}}/{{$ad->name}}" class="btn btn-light stretched-link pl-5 pr-5 float-right">View</a>
                        <h7 class="text-muted float-left mt-2">{{  strftime("%d %b %Y",strtotime($ad->created_at)) }}</h7>
                    </div>
                </div>
            @endforeach
            {{ $ads->links() }}
        </div>
</div>
@endsection
