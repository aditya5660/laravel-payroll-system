@extends('master')
@section('content')
<div class="container">

    <h1>JABATAN</h1>

    <a class="btn btn-primary mb-3" href="javascript:void(0)" id="createNewJabatan"> Create New Jabatan</a>

    <table class="table table-bordered data-table">

        <thead>

            <tr>
                <th>no</th>

                {{-- <th>id_jabatan</th> --}}

                <th>nama_jabatan</th>

                <th>gaji_pokok</th>

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
                <form id="jabatanForm" name="jabatanForm" class="form-horizontal">
                   <input type="hidden" name="id_jabatan" id="id_jabatan">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">nama_jabatan</label>
                        <div class="col-sm-12">
                            <input required="required" type="text" id="nama_jabatan" name="nama_jabatan" required="" placeholder=" " class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">gaji_pokok</label>
                        <div class="col-sm-12">
                            <input required="required" type="number" id="gaji_pokok" name="gaji_pokok" required="" placeholder="" class="form-control"  value="" >
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
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
{{-- <script src="{{asset('js/numberic.js') }}"></script>  --}}

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

  <script type="text/javascript">

// var gaji_pokok = document.getElementById('gaji_pokok'); gaji_pokok.addEventListener('keyup', function(e){
//                 gaji_pokok.value = formatRupiah(this.value, 'Rp. ');
//             });

    $(function () {



        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

      });



      var table = $('.data-table').DataTable({

          processing: true,

          serverSide: true,

          ajax: "{{ route('jabatan.index') }}",

          columns: [

              {data: 'DT_RowIndex', name: 'DT_RowIndex'},

            //   {data: 'id_jabatan', name: 'id_jabatan'},//diganti sesuai db

              {data: 'nama_jabatan', name: 'nama_jabatan'},

              {data: 'gaji_pokok', name: 'gaji_pokok'},


              {data: 'action', name: 'action', orderable: false, searchable: false},

          ]

      });



      $('#createNewJabatan').click(function () {

          $('#saveBtn').val("create-jabatan");

          $('#id_jabatan').val('');

          $('#jabatanForm').trigger("reset");

          $('#modelHeading').html("Create New Jabatan");

          $('#ajaxModel').modal('show');

      });



      $('body').on('click', '.editJabatan', function () {
        var id_jabatan = $(this).data('id');
        $.get("{{ route('jabatan.index') }}" +'/' + id_jabatan +'/edit', function (data) {
            $('#modelHeading').html("Edit Jabatan");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#id_jabatan').val(data.id_jabatan);
            $('#nama_jabatan').val(data.nama_jabatan);
            $('#gaji_pokok').val(data.gaji_pokok);

        })

     });



      $('#saveBtn').click(function (e) {

          e.preventDefault();

          $(this).html('Sending..');



          $.ajax({

            data: $('#jabatanForm').serialize(),

            url: "{{ route('jabatan.store') }}",

            type: "POST",

            dataType: 'json',

            success: function (data) {

                $('#jabatanForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                // toastr.success('Successfully Saved Category!', 'Success Alert', {timeOut: 5000});
                // notify.success('Have fun storming the castle!', 'Miracle Max Says');
                table.draw();



            },

            error: function (data) {

                console.log('Error:', data);

                $('#saveBtn').html('Save Changes');

            }

        });

      });



      $('body').on('click', '.deleteJabatan', function () {



          var jabatan_id = $(this).data("id");

          confirm("Are You sure want to delete !");

          $.ajax({

              type: "DELETE",

              url: "{{ route('jabatan.store') }}"+'/'+jabatan_id,

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
