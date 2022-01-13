@extends('layouts.admin')


@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection 


@section('bar-title', 'Items')
@section('header-title', 'Items')

@section('content')
<div id="controller">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <button @click="addData()" class="btn btn-primary">Create New Transaction</button>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="transaction">
                                <option value="0">All Transaction</option>
                                <option value="in">Transaction In</option>
                                <option value="out">Transaction Out</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-10">
                <table id="datatable" class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th class="text-code">#</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Total Price</th>
                        <th class="text-center">Desc</th>
                        <th class="text-center">Action</th>

                    </tr>
                    </thead>
                </table>
                </div>
                <!-- /.card-body -->
            </div>
        <!-- /.card -->
        </div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="modal-transaction">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="post" :action="actionUrl" autocomplete="off" @submit="submitform($event, data.id)">
                <div class="modal-header">
                <h4 class="modal-title">Transaction</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                    
                    
                   
                    <div class="form-group">
                        <label>Item</label>
                        <select name="item_id" class="form-control" :readonly="editStatus">
                            @foreach($items as $item)
                                <option :selected="data.itemId == {{ $item->id }}" value="{{ $item->id }}">{{ $item->name }} ({{ $item->qty }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Members <p class="text-danger">(Leave Blank If Transaction In)</p></label>
                        <select name="member_id" class="form-control" :readonly="editStatus">
                            <option value="0">Select..</option>
                            @foreach($members as $member)
                                <option :selected="data.member_id == {{ $member->id }}" value="{{ $member->id }}">{{ $member->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control"  :value="data.qty" name="qty" required>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->
      <div class="modal fade" id="modal-detailTransaction">
        <div class="modal-dialog">
          <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Detail Transaction</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label v-if="detailStatusIn" >Supplier Name</label>
                        <label v-if="detailStatusIn == false" >Member Name</label>
                        <input class="form-control" :value="data.memberOrSupplier" disabled>
                    </div>
                    <div class="form-group">
                        <label >Status</label>
                        <input class="form-control" :value="data.historiesStatus" disabled>
                    </div>
                    <div class="form-group">
                        <label >Price / Pcs</label>
                        <input class="form-control" :value="data.price" disabled>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>


@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
    $(function () {
        $('.select2').select2()
    });
</script>

<script type="text/javascript">
    var actionUrl = '{{ url('transactions') }}';
    var apiUrl = '{{ url('api/transactions') }}';

    var columns = [
        {data: 'DT_RowIndex', class:'text-left', orderable: true},
        {data: 'itemName', class:'text-center', orderable: true},
        {data: 'qty', class:'text-center', orderable: true},
        {data: 'totalPrice', class:'text-center', orderable: true},
        {data: 'historiesStatus', class:'text-center', orderable: true},
        {render: function(index, row, data, meta){
            return `
                <button class="btn btn-info btn-sm" onclick="controller.detailData(event, ${meta.row})">Detail</button>
                <button class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">Delete</button>`;
        }, orderable: false, width:'200px', class:'text-center'},
    ];


    var controller = new Vue({
        el: '#controller',
        data: {
            datas: [],
            data: {},
            actionUrl,
            apiUrl,
            editStatus: false,
            detailStatusIn: false,
        },
        mounted: function(){
            this.datatable();
        },
        methods: {
            datatable() {
                const _this = this;
                _this.table = $('#datatable').DataTable({
                    ajax: {
                        url: _this.apiUrl,
                        type: 'GET',
                    },
                    columns
                }).on('xhr', function () {
                    _this.datas = _this.table.ajax.json().data;
                });
            },
            addData(){
                this.data = {};
                this.editStatus = false;
                $('#modal-transaction').modal();
            },
            editData(event, row){
                
                this.data = this.datas[row];
                this.editStatus = true;
                $('#modal-transaction').modal();
            },
            detailData(event, row){
                
                this.data = this.datas[row];
                if(this.data.historiesStatus == 'Transaction Out'){
                    this.detailStatusIn = false;
                } else {
                    this.detailStatusIn = true;
                }
                $('#modal-detailTransaction').modal();
            },
            deleteData(event, id){
                if(confirm('Are you sure ?')){
                    $(event.target).parents('tr').remove();
                    axios.post(this.actionUrl+'/'+id, {_method: 'DELETE'}).then(response => {
                    alert('Data has been removed');
                    });
                }
            }, 
            submitform(event, id){
                event.preventDefault();
                const _this = this;
                var actionUrl = ! this.editStatus ? this.actionUrl : this.actionUrl + '/' + id;
                axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                    $('#modal-transaction').modal('hide');
                    _this.table.ajax.reload();
                });


            }
        }
    });
    $('select[name=transaction]').on('change', function(){
        transactions = $('select[name=transaction]').val();
        if(transactions == 0){
            controller.table.ajax.url(apiUrl).load();
        } else {
            controller.table.ajax.url(apiUrl+'?transaction='+transactions).load();
        }
    });
</script>
@endsection 