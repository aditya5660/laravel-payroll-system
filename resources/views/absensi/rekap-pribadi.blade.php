<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Absensi CV. Codeinaja Solusi Digital</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
        .footer {
          position: fixed;
          left: 0;
          bottom: 0;
          width: 100%;
          color: #8c8b8b;
          text-align: center;
          font-size: 12px;
        }

        </style>
<body>

        <h3 class="text-center">REKAPITULASI ABSENSI</h3>
        <h5 class="text-center">Bulan {{ $bulan }} {{$tahun}}</h5>
        <hr class="" style="border-top: 3px double #8c8b8b;">
        <div class="m-0 ">
        <p>Nama Karyawan   : {{ $karyawan->nama_karyawan}}</p><p>Jabatan   : {{ $karyawan->nama_jabatan}}</p>
        </div>
        <hr class="" style="border-top: 3px double #8c8b8b;">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Kehadiran</th>
                    <th scope="col">Jam Masuk</th>
                    <th scope="col">Jam Keluar</th>
                </tr>
            </thead>
            <tbody>
                @php $no =1; @endphp
                @foreach ($data as $item)
                <tr>
                    <th scope="row">{{$no++ }}</th>
                    <td>{{$item->tgl_absensi}}</td>
                    <td>{{$item->kehadiran}}</td>
                    <td>{{$item->waktu_masuk}}</td>
                    <td>{{$item->waktu_keluar}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="footer m-0 p-0">
        <p>Dibuat otomatis oleh Sistem Penggajian Karyawan CV. CODEINAJA pada {{date("d-m-Y")}}</p>
        </div>
    </body>

</html>
