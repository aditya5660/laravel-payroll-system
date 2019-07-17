@extends('master')
@section('content')
<style>
    .datepicker{z-index:1151 !important;},
 }
</style>

<div class="container">
        @if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<strong>{{ $message }}</strong>
</div>
@endif


@if ($errors->any())
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">×</button>
	Please check the form below for errors
</div>
@endif
    <h1>Presensi </h1>
    <a class="btn btn-primary mb-3" href="javascript:void(0)" id="createNewProduct"> Create New Presensi</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Karyawan</th>
                <th>Nama Karyawan</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="absensiForm" name="absensiForm" class="form-horizontal">
                   <input type="hidden" name="id_absensi" id="id_absensi" >

                   <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Tanggal Absensi</label>
                        <div class="col-sm-12">
                        <input class="form-control" type="text" id="mydate" name="mydate"value="{{ date('Y-m-d')}}"/>
                        </div>
                    </div>

                   <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Nama Karyawan</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="id_karyawan"name="id_karyawan">
                                @foreach ($karyawan as $item)
                            <option value="{{$item->id_karyawan}}">{{($item->id_karyawan)}} - {{($item->nama_karyawan)}}</option>
                                @endforeach
                                </select>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-sm-6 control-label">Kehadiran</label>
                        <div class="col-12">
                            <select name="kehadiran" id="kehadiran" class="form-control">
                                <option value="">Please Select</option>
                                <option value="Hadir">Hadir</option>
                                <option value="Alpha">Alpha</option>
                                <option value="Cuti">Cuti</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                            <label for="name" class="col-sm-6 control-label">Waktu Masuk</label>
                            <div class="col-sm-12">
                                <div class="input-group">

                                    <input  class="form-control timepicker timepickerMasuk" id="masuk" name="masuk" size="16" type="text">
                                    <span class="input-group-append">
                                            <button class="btn btn-secondary" id="buttonTimepickerMasuk" type="button">Current Time!</button>
                                            </span>
                                </div>
                            </div>

                    </div>

                    <div class="form-group">
                            <label for="name" class="col-sm-6 control-label">Waktu Keluar</label>
                            <div class="col-sm-12">
                                <div class="input-group">

                                    <input class="form-control timepicker timepickerKeluar" id="keluar" name="keluar" size="16" type="text">
                                    <span class="input-group-append">
                                            <button class="btn btn-secondary" id="buttonTimepickerKeluar" type="button">Current Time!</button>
                                            </span>
                                </div>
                                {{-- <input type="text" class="form-control timepicker" id="keluar" name="keluar" placeholder="Enter Name" value="" maxlength="50" required=""> --}}
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
<div class="modal fade" id="rekapAbsensi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Rekap Presensi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('absensi.rekap') }}" method="post">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
    crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

    <script type = "text/javascript">

$('#mydate').datepicker().datepicker('setDate', 'today');

$('.timepicker').timepicker({
    timeFormat: 'HH:mm:ss',
    interval: 60,

    defaultTime: 'now',
    startTime: '08:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true,
    zindex: 9999999,
});
$('#buttonTimepickerMasuk').on('click', function (){
	$('.timepickerMasuk').timepicker('setTime', new Date());
});
$('#buttonTimepickerKeluar').on('click', function (){
	$('.timepickerKeluar').timepicker('setTime', new Date());
});

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('absensi.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'id_karyawan',
                        name: 'name'
                    },
                    {
                        data: 'nama_karyawan',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    //{
                    //    data: 'action',
                    //    name: 'action',
                    //    orderable: false,
                    //    searchable: false
                    //},
                ]
            });
            $('#createNewProduct').click(function() {
                $('#saveBtn').val("create-product");
                $('#id_absensi').val('');
                $('#absensiForm').trigger("reset");
                $('#modelHeading').html("Create New Presensi");
                $('#ajaxModel').modal('show');
            });
            $('body').on('click', '.rekapAbsensi', function() {
                var id_karyawan = $(this).data('id');
                $.get("{{ route('absensi.index') }}" + '/' + id_karyawan + '/edit', function(data) {
                    $('#saveBtn').val("create-product");
                    $('#karyawan_id').val(data.id_karyawan);
                    $('#rekapAbsensiForm').trigger("reset");
                    $('#rekapAbsensi').modal('show');
                });
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');
                $.ajax({
                    data: $('#absensiForm').serialize(),
                    url: "{{ route('absensi.store') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function(data) {
                        $('#absensiForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        console.log(data);
                        // table.draw();
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
                    url: "{{ route('absensi.store') }}" + '/' + id_absensi,
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

