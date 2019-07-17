@extends('master')
@section('content')

<div class="container">
    <h1>Jenis Tunjangan</h1>
    <a class="btn btn-primary mb-3" href="javascript:void(0)" id="createNewTunjangan"> Tambah Jenis Tunjangan</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Tunjangan</th>

                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                   <input type="hidden" name="id_jenis_tunjangan" id="id_jenis_tunjangan">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Jenis Tunjangan</label>
                        <div class="col-sm-12">
                            <input required="required" type="text" class="form-control" id="nama_jenis_tunjangan" name="nama_jenis_tunjangan" placeholder="Masukkan Nama jenis Tunjangan" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">

  $(function () {

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('jenis-tunjangan.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            // {data: 'id_jenis_tunjangan', name: 'id_jenis_tunjangan'}, // ko iki dipas ke ro db
            {data: 'nama_jenis_tunjangan', name: 'nama_jenis_tunjangan'},// ko iki dipas ke ro db
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewTunjangan').click(function () {
        $('#saveBtn').val("create-product");
        $('#id_jenis_tunjangan').val('');
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Tambah Jenis Tunjangan");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editTunjangan', function () {
      var id_jenis_tunjangan = $(this).data('id');
      $.get("{{ route('jenis-tunjangan.index') }}" +'/' + id_jenis_tunjangan +'/edit', function (data) {
          $('#modelHeading').html("Edit Tunjangan");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#id_jenis_tunjangan').val(data.id_jenis_tunjangan);
          $('#nama_jenis_tunjangan').val(data.nama_jenis_tunjangan);
        //   $('#detail').val(data.detail);
      })
   });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Send');

        $.ajax({
          data: $('#productForm').serialize(),
          url: "{{ route('jenis-tunjangan.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#productForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();

          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });

    $('body').on('click', '.deleteTunjangan', function () {

        var id_jenis_tunjangan = $(this).data("id");
        confirm("Are You sure want to delete !");

        $.ajax({
            type: "DELETE",
            url: "{{ route('jenis-tunjangan.store') }}"+'/'+id_jenis_tunjangan,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

  });
</script>
@endsection

