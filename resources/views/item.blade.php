@extends('layouts.admin')


@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection 


@section('bar-title', 'Items')
@section('header-title', 'Items')

@section('content')
<div id="controller">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                <button @click="addData()" class="btn btn-primary">Create New Item</button>

                
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-10">
                <table id="datatable" class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Supplier</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Price From Supplier</th>
                        <th class="text-center">Price To Member</th>
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
    <div class="modal fade" id="modal-supplier">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="post" :action="actionUrl" autocomplete="off" @submit="submitform($event, data.id)">
                <div class="modal-header">
                <h4 class="modal-title">Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                    <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" :value="data.name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Supplier</label>
                        <select name="supplier_id" class="form-control">
                            @foreach($suppliers as $supplier)
                                <option :selected="data.supplier_id == {{ $supplier->id }}" value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                            <label>Supplier Prices</label>
                            <input type="number" class="form-control" :value="data.price_suppliers" name="price_supplier" required>
                    </div>
                    <div class="form-group">
                            <label>Member Prices</label>
                            <input type="number" class="form-control" :value="data.price_members" name="price_member" required>
                    </div>
                    <input type="hidden" class="form-control" value="0" name="qty" required>

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

<script type="text/javascript">
    var actionUrl = '{{ url('items') }}';
    var apiUrl = '{{ url('api/items') }}';

    var columns = [
        {data: 'DT_RowIndex', class:'text-center', orderable: true},
        {data: 'name', class:'text-center', orderable: false},
        {data: 'supplier.name', class:'text-center', orderable: false},
        {data: 'qty', class:'text-center', orderable: false},
        {data: 'price_supplier', class:'text-center', orderable: false},
        {data: 'price_member', class:'text-center', orderable: false},
        {render: function(index, row, data, meta){
            return `
                <button class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">Delete</button>`;
        }, orderable: false, width:'200px', class:'text-center'},
    ];


</script>
<script type="text/javascript">
    var controller = new Vue({
        el: '#controller',
        data: {
            datas: [],
            data: {},
            actionUrl,
            apiUrl,
            editStatus: false,
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
                $('#modal-supplier').modal();
            },
            editData(event, row){
                
                this.data = this.datas[row];
                this.editStatus = true;
                $('#modal-supplier').modal();
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
                    $('#modal-supplier').modal('hide');
                    _this.table.ajax.reload();
                });


            }
        }
    });
</script>
@endsection 