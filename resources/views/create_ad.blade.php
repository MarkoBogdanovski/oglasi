@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
      <div class="alert alert-success" role="alert">
        {!! session('success') !!}
      </div>
    @endif
        
    @if (session('error'))
      <div class="alert alert-danger" role="alert">
        {{ session('error') }}
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
                <div class="card-header">New Advertisment</div>

                <div class="card-body">
                    <form method="post" action="{{url('ad')}}" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf

                                <div class="form-group">
                                  <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text">Name</span>
                                      </div>
                                      <input type="text" aria-label="Name" name="name" class="form-control @if (session('error')) is-invalid @endif" required />
                                  </div>
                                </div>


                                <div class="form-group">
                                  <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text">Category</span>
                                      </div>
                                      <select class="custom-select"   name="category" id="category" data-allow-clear="1" required></select>
                                  </div>
                                </div>

                        <div class="form-row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Year</span>
                                    </div>
                                    <input type="text" aria-label="year" name="year" class="form-control @if (session('error')) is-invalid @endif" required />
                                </div>
                              </div>
                            </div>

                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Range</span>
                                    </div>
                                    <input type="text" aria-label="range" name="range" class="form-control @if (session('error')) is-invalid @endif" required />
                                </div>
                              </div>
                            </div>

                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend"><span class="input-group-text">Price</span></div>
                                        <input type="text" aria-label="Price" name="price" class="form-control @if (session('error')) is-invalid @endif"  aria-label="Amount (to the nearest dollar)" required />
                                        <div class="input-group-append"><span class="input-group-text">.00</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                          <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                  <span class="input-group-text">Choose image</span>
                              </div>
                              <div class="custom-file">
                                  <input type="file" id="image" name="image" class="custom-file-input @if (session('error')) is-invalid @endif" required />
                                  <label class="custom-file-label" for="image"> </label>
                              </div>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $("#category").select2({
    placeholder: "Select category",
    theme: 'bootstrap4',
    ajax: {
      url: "/categories",
      dataType: "json",
      processResults: function(data) {
        return {
          results: $.map(data, function(category) {
            return {
              text: category.display_name,
              id: category.id
            };
          })
        };
      },
      cache: true
    }
  });
</script>
@endsection
