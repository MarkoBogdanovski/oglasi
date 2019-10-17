@extends('layouts.app')

@section('content')
<div class="container">
            @if (session('success'))
            <div aria-live="assertive" aria-atomic="true" style="position: relative; z-index: 100;">
                <div class="toast"  role="alert"  data-delay="10000" style="position: absolute; top: 0; right: 0px;">
                    <div class="toast-header">
                      <svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"><rect width="100%" height="100%" fill="#007aff"></rect></svg>
                      <strong class="mr-auto">Notification</strong>
                      &nbsp;&nbsp;&nbsp;
                      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="toast-body">
                       {!! session('success') !!}
                    </div>
                </div>
            </div>
        @endif
        
        @if (session('error'))
            <div aria-live="assertive" aria-atomic="true" style="position: relative; z-index: 100;">
                <div class="toast"  role="alert"  data-delay="10000" style="position: absolute; top: 0; right: 0px;">
                    <div class="toast-header">
                      <svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"><rect width="100%" height="100%" fill="#e3342f"></rect></svg>
                      <strong class="mr-auto">Error notification</strong>
                      &nbsp;&nbsp;&nbsp;
                      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="toast-body">
                       {{ session('error') }}
                    </div>
                </div>
            </div>
        @endif
    <div class="row justify-content-center">
        <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/ads"><i class="fas fa-arrow-left"></i> &nbsp;Go Back</a></li>
              </ol>
        </nav>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Category</div>

                <div class="card-body">
                    <form method="post" action="{{url('category')}}">
                        @csrf
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Category name</span>
                            </div>
                            <div class="custom-file">
                                <input type="text" aria-label="Category name" name="name" class="form-control @if (session('error')) is-invalid @endif" required />
                            </div>
                            <div class="file ml-2">
                                <button type="submit" class="btn btn-success pl-4 pr-4"><i class="fas fa-plus"></i> &nbsp;<b>Add</b></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.toast').toast('show');
    })
</script>
@endsection
