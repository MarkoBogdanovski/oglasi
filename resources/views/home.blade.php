@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif

        <div class="card-columns" id="ads">
            @foreach($ads as $ad)
              <div class="card m-2 shadow-sm mb-5">
                <img src="{{ $ad['image'] }}" class="card-img-top"/>
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

            function renderCard(data) {
                return [
                    '<div class="card m-2 shadow-sm mb-5"><img src="'+data.image+'" class="card-img-top"/><div class="card-body"><h5 class="card-title">'+data.name+'</h5><h6 class="card-subtitle mb-2 text-muted">$'+data.price+'</h6><div class="d-flex justify-content-end align-items-right"><a href="/'+data.id+'/'+data.name+'" class="btn btn-light stretched-link pl-5 pr-5">View</a></div></div><div class="card-footer"><small class="text-muted"><td>'+data.created_at+'</td></small></div></div>'
                ].join('')
            }

            $("#category").on('change', function() {
                var q = $("#search").val();
                var category = $("#category").val();

                $.ajax({
                    url: '/search',
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        category: category,
                        q: q
                    },
                    dataType: 'JSON',
                    success: function(response){
                        $("#ads").html('');
                        $.each(response.data, function(index, value){
                            $("#ads").append(renderCard(value));
                        });
                        console.log(response.links);
                        $("#ads").append(response.links);
                    }
                });
            });
        </script>
</div>
@endsection
