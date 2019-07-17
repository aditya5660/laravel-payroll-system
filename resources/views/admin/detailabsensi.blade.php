@extends('master')
@section('content')
<div class="container">
    <h4>Detail Absensi</h4>
    @foreach ($karyawan as $item)
        <a>Nama Karyawan : {{$item->nama_karyawan }}</a><br>
        <a>E-mail : {{$item->email }}</a>
        <br>
        <br>
    @endforeach
    <table class="table table-bordered data-table" id="myTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kehadiran</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Jumlah Waktu Kerja</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; ?>
            @foreach ($data as $item)

            <tr>

                <td>{{$no++}}</td>
                <td>{{$item->tgl_absensi}}</td>
                <td>{{$item->kehadiran}}</td>
                <td>{{$item->waktu_masuk}}</td>
                <td>{{$item->waktu_keluar}}</td>
                <td>{{$item->jumlah_waktu_kerja}}</td>

            </tr>
            @endforeach
            <?php $no++?>
        </tbody>
    </table>

</div>
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
            $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
@endsection
