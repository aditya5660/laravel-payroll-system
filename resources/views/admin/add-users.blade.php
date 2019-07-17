@extends('master')
@section('content')
<div class="container">
    <h1>ADMIN MANAGEMENT</h1>
    <a class="btn btn-primary mb-3" href="javascript:void(0)" id="createNewAdmin"> Create New Admin</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>no</th>
                <th>name</th>
                <th>email</th>
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

                <form  id="usersForm" method="post" name="usersForm" class="form-horizontal">
                    {{ csrf_field() }}
                    <input type="hidden" id="id" name="id">
                    <div class="input-group mb-3">
                      <span class="input-group-addon"><i class="icon-user"></i></span>
                      <input type="text" name="name" class="form-control" placeholder="Username">
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-group-addon">@</span>
                      <input type="text" name="email" class="form-control" placeholder="Email">
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-group-addon"><i class="icon-lock"></i></span>
                      <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-group-addon"><i class="icon-lock"></i></span>
                      <input type="password" name="password_confirmation" class="form-control" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-block btn-warning">Create Account</button>
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
// var email = document.getElementById('email'); email.addEventListener('keyup', function(e){
//                 email.value = formatRupiah(this.value, 'Rp. ');
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
          ajax: "{{ route('users.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

      $('#createNewAdmin').click(function () {
          $('#saveBtn').val("create-jabatan");
          $('#id').val('');
          $('#usersForm').trigger("reset");
          $('#modelHeading').html("Create New Admin");
          $('#ajaxModel').modal('show');
      });



    //   $('body').on('click', '.editJabatan', function () {
    //     var id_jabatan = $(this).data('id');
    //     $.get("{{ route('jabatan.index') }}" +'/' + id_jabatan +'/edit', function (data) {
    //         $('#modelHeading').html("Edit Jabatan");
    //         $('#saveBtn').val("edit-user");
    //         $('#ajaxModel').modal('show');
    //         $('#id_jabatan').val(data.id_jabatan);
    //         $('#name').val(data.name);
    //         $('#email').val(data.email);

    //     })

    //  });

      $('#saveBtn').click(function (e) {
          e.preventDefault();
          $(this).html('Sending..');
          $.ajax({
            data: $('#usersForm').serialize(),
            url: "{{ route('users.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#usersForm').trigger("reset");
                $('#ajaxModel').modal('hide');
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
              url: "{{ route('users.store') }}"+'/'+jabatan_id,
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
