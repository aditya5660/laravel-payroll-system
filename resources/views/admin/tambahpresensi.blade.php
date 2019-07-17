@extends('master')
@section('content')
<div class="container">

    <h1>Presensi </h1>
    <a class="btn btn-primary mb-3" href="javascript:void(0)" id="createNewProduct"> Create New Presensi</a>
    <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="ui-state-default" rowspan="1" colspan="1" style="width: 7%;">
                        No.
                    </th>
                    <th class="ui-state-default" rowspan="1" colspan="1" style="width: 10%;">
                        NIP
                    </th>
                    <th class="ui-state-default" rowspan="1" colspan="1" style="width: 15%;">
                        Nama Karyawan
                    </th>
                    <th class="ui-state-default" rowspan="1" colspan="1" style="width: 20%;">
                        Kehadiran
                    </th>
                    <th class="ui-state-default" rowspan="1" colspan="1" style="width: 10%;">
                        Jam Masuk
                    </th>
                    <th class="ui-state-default" rowspan="1" colspan="1" style="width: 10%;">
                        Jam Keluar
                    </th>
                </tr>
            </thead>
            <tbody>
                <form action="{{route('absensi.store') }}" method="post"></form>
                @foreach ($karyawan as $item)

                    <tr>
                            <th class="ui-state-default" rowspan="1" colspan="1" style="width: 7%;">
                                No.
                            </th>
                            <th class="ui-state-default" rowspan="1" colspan="1" style="width: 10%;">
                                {{ $item->id_karyawan }}
                            </th>
                            <th class="ui-state-default" rowspan="1" colspan="1" style="width: 15%;">
                                {{ $item->nama_karyawan }}
                            </th>
                            <th class="ui-state-default" rowspan="1" colspan="1" style="width: 20%;">
                                <div class="radio">
                                    <label><input value="masuk" type="radio" name="radio{{$item->id_karyawan}}" checked="checked">Masuk</label>
                                    <label><input value="sakit" type="radio" name="radio{{$item->id_karyawan}}">Sakit</label>
                                    <label><input value="ijin" type="radio" name="radio{{$item->id_karyawan}}">ijin</label>
                                    <label><input value="dispen" type="radio" name="radio{{$item->id_karyawan}}">Dispen</label>
                                </div>
                            </th>
                            <th class="ui-state-default" rowspan="1" colspan="1" style="width: 10%;">
                                Jam Masuk
                            </th>
                            <th class="ui-state-default" rowspan="1" colspan="1" style="width: 10%;">
                                Jam Keluar
                            </th>
                        </tr>
                        @endforeach
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes

                            </button>
                    </form>
            </tbody>
        </table>

            </div>






            <div class="col-sm-offset-2 col-sm-10">



            </div>

        </form>
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                   <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-2 control-label">Details</label>

                        <div class="col-sm-12">

                            <textarea id="detail" name="detail" required="" placeholder="Enter Details" class="form-control"></textarea>

                        </div>

                    </div>



                    <div class="col-sm-offset-2 col-sm-10">

                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes

                     </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



</body>
@endsection
@section('myscript')
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type = "text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('ajaxproducts.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'detail',
                        name: 'detail'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            $('#createNewProduct').click(function() {
                $('#saveBtn').val("create-product");
                $('#product_id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Create New Product");
                $('#ajaxModel').modal('show');
            });
            $('body').on('click', '.editProduct', function() {
                var product_id = $(this).data('id');
                $.get("{{ route('ajaxproducts.index') }}" + '/' + product_id + '/edit', function(data) {
                    $('#modelHeading').html("Edit Product");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#product_id').val(data.id);
                    $('#name').val(data.name);
                    $('#detail').val(data.detail);
                })
            });
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');
                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('ajaxproducts.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#productForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });
            $('body').on('click', '.deleteProduct', function() {
                var product_id = $(this).data("id");
                confirm("Are You sure want to delete !");
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('ajaxproducts.store') }}" + '/' + product_id,
                    success: function(data) {
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });
        });
        </script>
@endsection

