@extends('master')
@section('content')
<div class="container">
    <h1>Gaji </h1>
    <br>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Karyawan</th>
                <th>Name</th>
                <th>Jabatan</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="slipGaji" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Cetak Slip Gaji</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('gaji.slip-gaji') }}" method="post">
                @csrf
                <input type="hidden" name="id_karyawan" id="karyawan_id">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Bulan</label>
                            <select name="bulan_start" id="bulan_start" class="form-control">
                                <option value="01">01 - Januari</option>
                                <option value="02">02 - Februari</option>
                                <option value="03">03 - Maret</option>
                                <option value="04">04 - April</option>
                                <option value="05">05 - Mei</option>
                                <option value="06">06 - Juni</option>
                                <option value="07">07 - Juli</option>
                                <option value="08">08 - Agustus</option>
                                <option value="09">09 - September</option>
                                <option value="10">10 - Oktober</option>
                                <option value="11">11 - November</option>
                                <option value="12">12 - Desember</option>]
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Tahun</label>
                            <select name="tahun_start" id="tahun_start" class="form-control">
                                @for ( $i = 2018; $i <= 2050; $i ++) { ?>
                                    <option value="{{$i }}">{{$i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                ajax: "{{ route('gaji.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'id_karyawan',
                        name: 'id_karyawan'
                    },
                    {
                        data: 'nama_karyawan',
                        name: 'name'
                    },
                    {
                        data: 'nama_jabatan',
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
            $('body').on('click', '.slipGaji', function() {
                var id_karyawan = $(this).data('id');
                $.get("{{ route('gaji.index') }}" + '/' + id_karyawan + '/edit', function(data) {
                    $('#saveBtn').val("create-product");
                    $('#karyawan_id').val(data.id_karyawan);
                    $('#rekapAbsensiForm').trigger("reset");
                    $('#slipGaji').modal('show');
                });
            });


        });
        </script>
@endsection

