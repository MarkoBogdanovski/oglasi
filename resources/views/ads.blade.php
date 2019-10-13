@extends('layouts.app')

@section('content')
<div class="container">
        @if (session('status'))
            <div aria-live="assertive" aria-atomic="true" style="position: relative; z-index: 100;">
                <div class="toast"  role="alert"  data-delay="10000" style="position: absolute; top: 0; right: 40%;">
                    <div class="toast-header">
                      <svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"><rect width="100%" height="100%" fill="#007aff"></rect></svg>
                      <strong class="mr-auto">{{ session('status')[0] }}</strong>
                      &nbsp;&nbsp;&nbsp;
                      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="toast-body">
                       {{ session('status')[1] }}
                    </div>
                </div>
            </div>
        @endif

    @if(!isset($list) && empty($list) && ($list != "all"))
        <div class="d-flex">
            @foreach($onHold as $ad)
            <div class="flex-fill">
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
                    <small class="text-muted"><td>{{  strftime("%d %b %Y",strtotime($ad['created_at'])) }}</td></small>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
        </div>
        <br/>
        <div class="d-block  m-2"> 
            <a href="/ads/all" class="btn btn-secondary float-right" style="width:  100%;">  Show all  </a>
        </div>
        <br/>
        @if(isset($approved) && !empty($approved))
            <div class="container-fluid mt-5">
              <div class="card p-4">
                <div id="toolbar">
                    <div class="btn-group">
                        <button type="button" id="approve"  class="btn btn-sm btn-success">
                            Approve
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button"  id="remove" class="btn btn-sm btn-danger">
                            Ignore
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                </div>

                  <table  id="table"
                              data-toggle="table"  
                              data-toolbar="#toolbar"
                              data-search="true"
                              data-show-refresh="true"
                              data-show-fullscreen="true"
                              data-click-to-select="true"
                              data-minimum-count-columns="2"
                              data-pagination="true"
                              data-id-field="id"
                              data-show-footer="true"
                              data-pagination="true"
                              data-search="true"
                              data-response-handler="responseHandler">
                              <thead>
                    </thead>
                    <tbody>
                       @foreach($approved as $ad)
                          <tr>
                            <td></td>
                            <td>{{ $ad['id'] }}</td>
                            <td>{{ $ad['name']}}</td>
                            <td>{{ $ad['price'] }}</td> 
                            <td>{{ $ad['category'][0]['display_name'] }}</td>
                      @endforeach
                    </tbody>
                  </table>
              </div>
            </div>
        @endif

    @else 
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/ads"><i class="fas fa-arrow-left"></i> &nbsp;Go Back</a></li>
              </ol>
            </nav>

          <div class="card p-4  shadow">
            <div id="toolbar">
                <div class="btn-group">
                        <button type="button" id="approve" class="btn btn-success shadow-sm">
                           <strong>Approve</strong>
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button" id="remove" class="btn btn-danger shadow-sm">
                            <b>Ignore</b>
                            <i class="far fa-trash-alt"></i>
                        </button>
                </div>
            </div>

              <table  id="table"
                          data-toggle="table"  
                          data-toolbar="#toolbar"
                          data-search="true"
                          data-show-refresh="true"
                          data-show-fullscreen="true"
                          data-click-to-select="true"
                          data-minimum-count-columns="2"
                          data-pagination="true"
                          data-id-field="id"
                          data-show-footer="true"
                          data-pagination="true"
                          data-search="true"
                          data-response-handler="responseHandler">
                          <thead>
                </thead>
                <tbody>
                   @foreach($onHold as $ad)
                      <tr>
                        <td></td>
                        <td>{{ $ad['id'] }}</td>
                        <td>{{ $ad['name']}}</td>
                        <td>{{ $ad['price'] }}</td> 
                        <td>{{ $ad['category'][0]['display_name'] }}</td>
                        </tr>
                  @endforeach
                </tbody>
              </table>
          </div>
        </div>
    @endif


    <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.15.4/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.15.4/dist/bootstrap-table-locale-all.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.15.4/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script>

        var $table = $('#table')
        var $remove = $('#remove')
        var $approve = $('#approve')
        var selections = []

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

        function operateFormatter(value, row, index) {
          return [
            '<a class="like" href="javascript:void(0)" title="Approve">',
            '<i class="fas fa-check"></i>',
            '</a>  ',
            '<a class="remove" href="javascript:void(0)" title="Remove">',
            '<i class="fas fa-times"></i>',
            '</a>'
          ].join('')
        }

        window.operateEvents = {
          'click .like': function (e, value, row, index) {
            alert('You click like action, row: ' + JSON.stringify(row))
          },
          'click .remove': function (e, value, row, index) {
            $table.bootstrapTable('remove', {
              field: 'id',
              values: [row.id]
            })
          }
        }

        function totalTextFormatter(data) {
          return 'Total'
        }

        function totalNameFormatter(data) {
          return data.length
        }

        function totalCategoryFormatter(data) {
          return data.length
        }

        function totalPriceFormatter(data) {
          var field = this.field
          return '$' + data.map(function (row) {
            return +row[field].substring(1)
          }).reduce(function (sum, i) {
            return sum + i
          }, 0)
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
                sortable: true,
                footerFormatter: totalTextFormatter
              }, {
                title: 'Details',
                colspan: 4,
                align: 'center'
              }],
              [{
                field: 'name',
                title: 'Name',
                sortable: true,
                footerFormatter: totalNameFormatter,
                align: 'left'
              }, {
                field: 'price',
                title: 'Price',
                sortable: true,
                align: 'center',
                footerFormatter: totalPriceFormatter
              }, {
                field: 'category',
                title: 'Category',
                align: 'center',
                sortable: true,
                align: 'center',
                footerFormatter: totalCategoryFormatter
              }, 
              {
                field: 'operate',
                title: 'Action',
                align: 'center',
                clickToSelect: false,
                events: window.operateEvents,
                formatter: operateFormatter
              }]
            ]
          })

          $table.on('centerheck.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table',
          function () {
            $remove.prop('disabled', !$table.bootstrapTable('getSelections').length)
            selections = getIdSelections()
          })
          $table.on('all.bs.table', function (e, name, args) {

          })

          $remove.click(function () {
            var ids = getIdSelections()
            $table.bootstrapTable('remove', {
              field: 'id',
              values: ids
            })

            $.ajax({
                url: '/ads/handle',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    ids: ids,
                    status: false
                },
                dataType: 'JSON',
                success: function(response){
                    
                }
            });

            $remove.prop('disabled', true)
          })

          $approve.click(function () {
            var ids = getIdSelections()
            $.ajax({
                url: '/ads/handle',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    ids: ids,
                    status: true
                },
                dataType: 'JSON',
                success: function(response){
                    $table.bootstrapTable('remove', {
                      field: 'id',
                      values: ids
                    })
                }
            });

            $remove.prop('disabled', true)
          })
        }

        $(function() {
            $('.toast').toast('show');
            initTable();        
        })
      </script>
</div>
@endsection

