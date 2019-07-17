@extends('master')
@section('content')


<div class="container">
    <h1>Karyawan</h1>
    <a class="btn btn-primary mb-3" href="javascript:void(0)" id="cerateNewkaryawan"> Tambah Karyawan</a>

        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>no</th>
                    <th>Id</th>
                    <th>Nama</th>

                    <th>Id Jabatan</th>

                    <th>Jenis Kelamin</th>

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
                <form id="karyawanForm" name="karyawanForm" class="form-horizontal">
                   <input type="hidden" name="id_karyawan" id="id_karyawan">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nama</label>
                        <div class="col-sm-12">
                            <input required="required" type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" placeholder="Nama Karyawan" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">NPWP</label>
                        <div class="col-sm-12">
                            <input required="required" type="text" class="form-control" id="npwp_karyawan" name="npwp_karyawan" placeholder="NPWP Karyawan" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">id_Jabatan</label>
                        <div class="col-sm-12">
                            <select name="id_jabatan" class="form-control" id="exampleFormControlSelect1">
                                @foreach ($jabatan as $item)
                                <option value="{{$item->id_jabatan}}">{{$item->nama_jabatan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input required="required" type="text" class="form-control" id="email" name="email" placeholder="Email Karyawan" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Tempat Lahir</label>
                        <div class="col-sm-12">
                            <input required="required" type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal" class="col-sm-12 control-label">Tanggal Lahir</label>
                        <div class="col-sm-8">
                            <input required="required" type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1" class="col-sm-12 control-label">Jenis Kelamin</label>
                        <div class="col-sm-12">
                            <select class=" form-control" id="jenis_kelamin" name="jenis_kelamin" value="" maxlength="50" required="">
                            <option>Laki-Laki</option>
                            <option>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1" class="col-sm-6 control-label">Agama</label>
                        <div class="col-sm-12">
                            <select class=" form-control" id="agama" name="agama" value="" maxlength="50" required="">
                            <option value='islam'>Islam</option>
                            <option value='kristen'>Kristen</option>
                            <option value='katholik'>Katholik</option>
                            <option value='hindu'>Hindu</option>
                            <option value='kristen'>Budha</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Alamat</label>
                        <div class="col-sm-12">
                            <textarea id="alamat" name="alamat" required="" placeholder="Alamat" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">No Telp</label>
                        <div class="col-sm-12">
                            <input required="required" type="text" class="form-control" id="telp" name="telp" placeholder="No Telp" value="" maxlength="50" required="">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
//   $( function() {
//     $( "#datepicker" ).datepicker();
//   } );
    $(document).ready(function () {
    $('#tanggal_lahir').datepicker({
            changeMonth: true,
            changeYear: true,
            format: "DD, d MM, yy",

        });
    });
    </script>
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
        ajax: "{{ route('karyawan.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id_karyawan', name: 'id_karyawan'},
            {data: 'nama_karyawan', name: 'nama_karyawan'}, // ko iki dipas ke ro db

            {data: 'nama_jabatan', name: 'id_jabatan'},

            {data: 'jenis_kelamin', name: 'jenis_kelamin'},

            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#cerateNewkaryawan').click(function () {
        $('#saveBtn').val("create-product");
        $('#karyawan_id').val('');
        $('#karyawanForm').trigger("reset");
        $('#modelHeading').html("Create New Karyawan");
        $('#ajaxModel').modal('show');
    });
    $('body').on('click', '.editKaryawan', function () {
      var karyawan_id = $(this).data('id');
      $.get("{{ route('karyawan.index') }}" +'/' + karyawan_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Product");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#id_karyawan').val(data.id_karyawan);
          $('#nama_karyawan').val(data.nama_karyawan);
          $('#npwp_karyawan').val(data.npwp_karyawan);
          $('#image').val(data.image);
          $('#id_jabatan').val(data.id_jabatan);
          $('#email').val(data.email);
          $('#jenis_kelamin').val(data.jenis_kelamin);
          $('#tempat_lahir').val(data.tempat_lahir);
          $('#tanggal_lahir').val(data.tanggal_lahir);
          $('#agama').val(data.agama);
          $('#alamat').val(data.alamat);
          $('#telp').val(data.telp);
      })
   });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
          data: $('#karyawanForm').serialize(),
          url: "{{ route('karyawan.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#karyawanForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();

          },
          error: function (data) {
            $('#karyawanForm').trigger("reset");
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });

    $('body').on('click', '.deleteKaryawan', function () {

        var karyawan_id = $(this).data("id");
        confirm("Are You sure want to delete !");

        $.ajax({
            type: "DELETE",
            url: "{{ route('karyawan.store') }}"+'/'+karyawan_id,
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

