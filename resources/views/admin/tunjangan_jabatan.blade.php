@extends('master')
@section('content')



<div class="container">

    <h1>Tunjangan Jabatan</h1>

    <a class="btn btn-primary mb-3" href="javascript:void(0)" id="createNewTunjanganJabatan"> Create New Tunjangan Jabatan</a>

    <table class="table table-bordered data-table">

        <thead>

            <tr>
                <th>No</th>
                <th>Tunjangan jabatan</th>
                <th>jenis tunjangan</th>
                <th>karyawan</th>
                <th>besar tunjangan</th>
                <th width="280px">Action</th>

            </tr>

        </thead>
    </table>
</div>



<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" id="modelHeading"></h4>

            </div>

            <div class="modal-body">

                <form id="TunjunganJabatanForm" name="TunjunganJabatanForm" class="form-horizontal">

                    <input type="hidden" name="id_tunjangan_jabatan" id="id_tunjangan_jabatan">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Jenis_tunjangan</label>
                        <div class="col-sm-12">
                        <select name="id_jenis_tunjangan" class="form-control" id="exampleFormControlSelect1">
                            @foreach ($jenis_tunjangan as $item)
                            <option value="{{ $item->id_jenis_tunjangan }}">{{$item->nama_jenis_tunjangan}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nama Karyawan</label>
                        <div class="col-sm-12">
                        <select name="id_karyawan" class="form-control" id="exampleFormControlSelect1">
                            @foreach ($karyawan as $item)
                        <option value="{{ $item->id_karyawan }}">{{$item->nama_karyawan}}-{{$item->nama_jabatan}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">besar_tunjangan</label>
                        <div class="col-sm-12">
                            <input required="required" type="text" class="form-control" id="besar_tunjangan" name="besar_tunjangan" placeholder=" Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>


                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                    </div>
                </form>

            </div>

        </div>

    </div>

</div>

</body>

@endsection
@section('myscript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function() {

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });



        var table = $('.data-table').DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('tunjangan-jabatan.index') }}",

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'id_tunjangan_jabatan',
                    name: 'id tunjangan jabatan'
                },
                {
                    data: 'nama_jenis_tunjangan',
                    name: 'id jenis tunjangan'
                },
                {
                    data: 'nama_karyawan',
                    name: 'id karyawan'
                },
                {
                    data: 'besar_tunjangan',
                    name: 'besar tunjangan'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        $('#createNewTunjanganJabatan').click(function() {
            $('#saveBtn').val("create-tunjangan");
            $('#tunjangan_id').val('');

            $('TunjunganJabatanForm').trigger("reset");

            $('#modelHeading').html("Create New Tunjangan Jabatan");

            $('#ajaxModel').modal('show');

        });



        $('body').on('click', '.editTunjanganJabatan', function() {

            var tunjangan_id = $(this).data('id');

            $.get("{{ route('tunjangan-jabatan.index') }}" + '/' + tunjangan_id + '/edit', function(data) {

                $('#modelHeading').html("Edit Tunjangan Jabatan");

                $('#saveBtn').val("edit-user");

                $('#ajaxModel').modal('show');

                $('#id_tunjangan_jabatan').val(data.id_tunjangan_jabatan);

                $('#id_jenis_tunjangan').val(data.id_jenis_tunjangan);

                $('#id_karyawan').val(data.id_karyawan);

                $('#besar_tunjangan').val(data.besar_tunjangan);

                $('#detail').val(data.detail);

            })

        });



        $('#saveBtn').click(function(e) {

            e.preventDefault();

            $(this).html('Sending..');



            $.ajax({

                data: $('#TunjunganJabatanForm').serialize(),

                url: "{{ route('tunjangan-jabatan.store') }}",

                type: "POST",

                dataType: 'json',

                success: function(data) {

                    $('TunjunganJabatanForm').trigger("reset");

                    $('#ajaxModel').modal('hide');

                    table.draw();
                },

                error: function(data) {

                    console.log('Error:', data);

                    $('#saveBtn').html('Save Changes');

                }

            });

        });

        $('body').on('click', '.deleteTunjanganJabatan', function() {
            var tunjangan_id = $(this).data("id");
            confirm("Are You sure want to delete !"); //DELETE
            $.ajax({
                type: "DELETE",
                url: "{{ route('tunjangan-jabatan.store') }}" + '/' + tunjangan_id,
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
