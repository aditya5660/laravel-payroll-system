<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
        .span
        {
          color: #8c8b8b;
          font-size:10px ;
        }
        .table {
          font-size:12px ;
        }
        </style>
<body>

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">

                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card invoice1">
                        <div class="body">
                            <div class="invoice-top clearfix">
                                {{-- <div class="logo">
                                    <img src="../assets/images/logo-blak.svg" alt="user" class="img-fluid">
                                </div> --}}
                                <div class="" style="float:left">
                                    <h6>CV. CODEINAJA</h6>
                                    <p>Jl. Prawiro Kuat 129B Sleman YK</p>
                                </div>
                                <div class="" style="float:right">
                                    <h4>SALARY INVOICE</h4>
                                    <p>Bulan {{$bulan}} {{ $tahun}}</p>
                                </div>
                            </div>
                            <hr style="border-top: 3px double #8c8b8b;">
                            <div class="invoice-mid clearfix mb-0"">
                                <div class="info ">
                                    <h5>{{$karyawan->nama_karyawan}}</h5>
                                    <p class="mb-0">{{$karyawan->nama_jabatan}}<br>ID Karyawan : {{ $karyawan->id_karyawan }}</p>
                                </div>
                            </div>
                            <hr style="border-top: 3px double #8c8b8b;">
                            <div class="invoice-mid clearfix mb-0"">
                                <div class="info ">
                                    <p class="m-0"> Jumlah Hari Kerja : {{$count_hadir_absensi}} Hari <br><span class="span"><i>Dari Jumlah Hari Kerja Normal 20 Hari/Bulan</i></span></p>

                                    <p class="m-0"> Jumlah Jam Kerja  : {{$jml_jam}} Jam <br><span class="span"><i>Dari Jumlah Jam Kerja Normal 160 Jam/Bulan</i></span></p>
                                </div>
                            </div>
                            <hr style="border-top: 3px double #8c8b8b;">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6">
                                    <div class="table">
                                        <table class="table table-striped" style="width:50%;">
                                            <thead class="thead-success">
                                                <tr>
                                                    <th>#</th>
                                                    <th>PENDAPATAN</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Gaji Pokok</td>
                                                    <td>Rp. {{ number_format($karyawan->gaji_pokok)}}</td>
                                                </tr>
                                                @foreach ($tunj_jabatan as $item)
                                                <tr>
                                                    <td>2</td>
                                                    <td>Tunjangan {{$item->nama_jenis_tunjangan }}</td>
                                                    <td>Rp {{number_format( $tot_tunjangan= $item->besar_tunjangan) }}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td>3</td>
                                                    <td>Gaji Lembur {{ $jumlah_jam_lembur }} Jam</td>
                                                    <td>Rp {{ number_format($gaji_lembur) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="table">
                                        <table class="table table-striped" style="width:50%;float:right">
                                            <thead class="thead-success">
                                                <tr>
                                                    <th>#</th>
                                                    <th>PEMOTONGAN</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $pot_cuti = ($karyawan->gaji_pokok/160)*($get_cuti*8);
                                                    $pot_sakit = ($karyawan->gaji_pokok/160)*($get_sakit*8);
                                                    $pot_ijin = ($karyawan->gaji_pokok/160)*($get_ijin*8);
                                                    $pot_alpha = ($karyawan->gaji_pokok/160)*($get_alpha*8);
                                                    $tot_potongan = ($pot_alpha+$pot_sakit+$pot_ijin+$pot_cuti);
                                                @endphp
                                                <tr>
                                                    <td>1</td>
                                                    <td>Cuti ( {{$get_cuti}} Hari )</td>
                                                    <td>Rp. {{ number_format($pot_cuti) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Sakit ( {{$get_sakit}} Hari )</td>
                                                    <td>Rp {{ number_format($pot_sakit) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Ijin ( {{$get_ijin}} Hari )</td>
                                                    <td>Rp {{ number_format($pot_ijin) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>T. Keterangan ( {{$get_alpha}} Hari )</td>
                                                    <td>Rp {{ number_format($pot_alpha) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row clearfix">

                                <div class="col-md-6 text-right">
                                <p class="m-b-0"><b>Total Pendapatan:</b> Rp {{ number_format($jumlah_gaji = ($karyawan->gaji_pokok + $jumlah_tunjangan + $gaji_lembur))}}</p>
                                    <p class="m-b-0"><b>Total Pemotongan:</b> Rp {{ number_format($tot_potongan) }}</p>
                                <h5 class="m-b-0 m-t-10">Gaji Bersih: Rp {{ number_format($jumlah_gaji-$tot_potongan)}} </h5>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer m-0 p-0">
                <p>Dibuat otomatis oleh Sistem Penggajian Karyawan CV. CODEINAJA pada {{date("d-m-Y")}}</p>
                </div>
    </div>
</body>
</html>
