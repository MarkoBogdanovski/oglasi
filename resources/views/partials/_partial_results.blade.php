            @foreach($ads as $ad)
              <div class="card m-2 shadow-sm mb-5" style="max-width: 20rem;">
                <div class="card-img-top" style="height: 15rem; background-size: cover; background-position: center; background-image: url('{{ $ad->image }}')"></div>
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
           {!! $ads->links() !!}