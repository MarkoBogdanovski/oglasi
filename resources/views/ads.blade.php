@extends('layouts.app')

@section('js')
<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.4/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.4/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.4/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script type="text/javascript">
    var $table = $('#table')
    var $remove = $('#remove')
    var $approve = $('#approve')

    function getIdSelections() {
        return $.map($table.bootstrapTable('getSelections'), function (row) {
            return row.id
        })
    }

    function responseHandler(res) {
        $.each(res.rows, function (i, row) {
            row.state = $.inArray(row.id, selections) !== -1
        })
        return res
    }

    function handleAds(ids, status) {
        $.ajax({
            url: '/ads/handle',
            type: 'post',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                "_token": "{{ csrf_token() }}",
                ids: ids,
                status: status
            }),
            success: function(response){
                $table.bootstrapTable('remove', {
                    field: 'id',
                    values: ids
                })
            }
        });

        $remove.prop('disabled', true)
        $approve.prop('disabled', true)
    }

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable({
            height: 550,
            columns: [
                [{
                    field: 'state',
                    checkbox: true,
                    rowspan: 2,
                    align: 'center',
                    valign: 'middle'
                }, {
                    title: '#',
                    field: 'id',
                    rowspan: 2,
                    align: 'center',
                    valign: 'middle',
                    sortable: true
                }, {
                    title: 'Details',
                    colspan: 4,
                    align: 'center'
                }], [{
                    field: 'name',
                    title: 'Name',
                    sortable: true,
                    align: 'left'
                }, {
                    field: 'price',
                    title: 'Price',
                    sortable: true,
                    align: 'center'
                }, {
                    field: 'category',
                    title: 'Category',
                    align: 'center',
                    sortable: true,
                    align: 'center'
                }, {
                    field: 'status',
                    title: 'Status',
                    align: 'center',
                    sortable: true,
                    align: 'center'
                }]
            ]
        })

        $table.on('centerheck.bs.table uncheck.bs.table ' + 'check-all.bs.table uncheck-all.bs.table', function () {
            $remove.prop('disabled', !$table.bootstrapTable('getSelections').length)
            $approve.prop('disabled', !$table.bootstrapTable('getSelections').length)
        })

        $table.on('all.bs.table', function (e, name, args) {})

        $remove.click(function () {
            var ids = getIdSelections()
            handleAds(ids, false)
        })

        $approve.click(function () {
            var ids = getIdSelections()
            handleAds(ids, true)
        })
    }

    $(function() {
        initTable();        
    })
</script>
@append

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if (empty($list))
            <div class="col-md-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-arrow-left"></i> &nbsp;&nbsp;Go Back</a></li>
                    </ol>
                </nav>
            </div>

            <div class="col-md-10">
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
                <div class="d-flex">
                    @foreach($onHold as $ad)
                        <div class="flex-fill ml-2 mr-2">
                            <div class="card shadow-sm">
                                <div class="card-img-top" style="height: 13rem; background-size: cover; background-position: center; background-image: url('{{ $ad->image }}')"></div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $ad->price }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $ad->category()->first()->display_name }}</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a  href="/ad/{{$ad['id']}}/1" class="btn btn-sm btn-outline-success">&nbsp;&nbsp;<i class="fas fa-check"></i>&nbsp;&nbsp;</a>
                                            <a  href="/ad/{{$ad['id']}}/0" class="btn btn-sm btn-outline-danger">&nbsp;&nbsp;<i class="far fa-trash-alt"></i>&nbsp;&nbsp;</a>
                                        </div>
                                        <small class="text-muted"><td>{{  strftime("%d %b %Y",strtotime($ad->created_at)) }}</td></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if (!empty($onHold))
                    <div class="d-block m-2 pt-4 pb-4"> 
                        <a href="/ads/all" class="btn btn-secondary float-right" style="width:  100%;">  Show all  </a>
                    </div>
                @endif

                @if (!empty($approved))
                    <div class="card ml-2 mr-2 mt-5 shadow-sm">
                        <div class="card-header"><b>Approved advertisments</b></div>
                        <div class="card-body">
                            <div id="toolbar">
                                <button type="button"  id="remove" class="btn btn-outline-danger">
                                    <b style="font-weight: 600;">Reject</b>&nbsp;&nbsp;<i class="far fa-trash-alt"></i>
                                </button>
                            </div>

                            <table  id="table"
                                      data-toggle="table"  
                                      data-toolbar="#toolbar"
                                      data-show-refresh="true"
                                      data-show-fullscreen="true"
                                      data-click-to-select="true"
                                      data-minimum-count-columns="2"
                                      data-pagination="true"
                                      data-id-field="id"
                                      data-pagination="true"
                                      data-search="true"
                                      data-response-handler="responseHandler">
                                <thead>
                                    <tr>
                                        <th rowspan="2"></th>
                                        <th rowspan="2">Id</th>
                                        <th colspan="4">Details</th>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($approved as $ad)
                                        <tr>
                                            <td></td>
                                            <td>{{ $ad->id }}</td>
                                            <td>{{ $ad->name }}</td>
                                            <td>{{ $ad->price }}</td> 
                                            <td>{{ $ad->category()->first()->display_name }}</td>
                                            @if (empty($ad->updated_at))
                                                <td><b class="text-secondary">Recent</b></td>
                                            @else
                                                <td><b class="text-secondary">Republish</b></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        @else 
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/ads"><i class="fas fa-arrow-left"></i> &nbsp;Go back</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Ads</li>
                </ol>
            </nav>
            
            <div class="col-md-10">
                @if (empty($onHold))
                    <div class="alert alert-light shadow-sm" role="alert">
                        <blockquote class="blockquote text-center">
                            <p class="mt-3 mb-0">No pending ads.</p>
                        </blockquote>
                    </div>
                @else 
                    <div class="card p-4 shadow-sm">
                        <div id="toolbar">
                            <div class="btn-group">
                                <button type="button" id="approve"  class="btn btn-outline-success">
                                    <b style="font-weight: 600;">Approve</b>&nbsp;&nbsp;<i class="fas fa-check"></i>
                                </button>
                                <button type="button"  id="remove" class="btn btn-outline-danger">
                                    <b style="font-weight: 600;">Reject</b>&nbsp;&nbsp;<i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                        <table  id="table"
                                  data-toggle="table"  
                                  data-toolbar="#toolbar"
                                  data-show-refresh="true"
                                  data-show-fullscreen="true"
                                  data-click-to-select="true"
                                  data-minimum-count-columns="2"
                                  data-pagination="true"
                                  data-id-field="id"
                                  data-pagination="true"
                                  data-search="true"
                                  data-response-handler="responseHandler">
                            <thead>
                                <tr>
                                    <th rowspan="2"></th>
                                    <th rowspan="2">Id</th>
                                    <th colspan="4">Details</th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($onHold as $ad)
                                    <tr>
                                        <td></td>
                                        <td>{{ $ad->id }}</td>
                                        <td>{{ $ad->name }}</td>
                                        <td>{{ $ad->price }}</td> 
                                        <td>{{ $ad->category()->first()->display_name }}</td>
                                        @if (empty($ad->updated_at))
                                            <td><b class="text-primary">NEW</b></td>
                                        @else
                                            <td><b class="text-secondary">Republish</b></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

