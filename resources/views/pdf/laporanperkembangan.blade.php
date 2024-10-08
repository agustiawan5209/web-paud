<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pencapaian Perkembangan Anak Usia Dini</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1,
        h2,
        h3 {
            text-align: center;
        }

        .centered {
            text-align: center;
        }

        .section-title {
            margin-top: 30px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        * img {
            text-align: center;
            width: 200px;
        }

        * p :not(img) {
            text-align: justify;
        }

        .page-break {
            page-break-after: auto;
        }
    </style>
</head>

<body>

    <center>
        <img src="{{ public_path('images/logo/image.png') }}" width="200" alt="">
    </center>
    <h1>YAYASAN ANAK MADANI MASAGENA</h1>
    <h2>PAUD INSAN MASAGENA</h2>
    <h3>LAPORAN PENCAPAIAN PERKEMBANGAN ANAK USIA DINI</h3>

    <div class="centered">
        <p><strong>{{ $data['siswa']['nama'] }}</strong></p>
        <p>NISN: 3175288440</p>
        <p>Jl. Hertasning Blok E10 No.11 RT 005/RW 006 Kelurahan Tidung, Kecamatan Rappocini, Kota Makassar</p>
    </div>

    <h2 class="section-title">Identitas Peserta Didik</h2>
    <table >
        <tr>
            <th>Nama Peserta Didik</th>
            <td>{{ $data['siswa']['nama'] }}</td>
        </tr>
        <tr>
            <th>NISN/NIS</th>
            <td>{{ $data['siswa']['nisn'] }}</td>
        </tr>
        <tr>
            <th>Tempat Tanggal Lahir</th>
            <td>{{ $data['siswa']['tempat_lahir'] }}/ {{ $data['siswa']['tgl_lahir'] }}</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>{{ $data['siswa']['jenkel'] }}</td>
        </tr>
        <tr>
            <th>Agama</th>
            <td>{{ $data['siswa']['agama'] }}</td>
        </tr>
        <tr>
            <th>Alamat Peserta Didik</th>
            <td>{{ $data['siswa']['alamat'] }}</td>
        </tr>
        <tr>
            <th>Nama Orang Tua/Wali</th>
            <td> :
                {{ $data['siswa']['nama_orang_tua'] }}
            </td>
        </tr>
    </table>
    <div class="page-break"></div>
    <h2 class="section-title">Pendahuluan</h2>
    <p
        style="column-count: 2;
-webkit-column-count: 2;
-moz-column-count: 2;
column-gap: 20px;
-webkit-column-gap: 20px;
-moz-column-gap: 20px;
column-rule: 1px none #000000;
-webkit-column-rule: 1px none #000000;
-moz-column-rule: 1px none #000000;">
        {!! $data['text1'] !!}</p>

    <h2 class="section-title">Perkembangan Nilai Agama dan Moral</h2>
    <p
        style="column-count: 2;
-webkit-column-count: 2;
-moz-column-count: 2;
column-gap: 20px;
-webkit-column-gap: 20px;
-moz-column-gap: 20px;
column-rule: 1px none #000000;
-webkit-column-rule: 1px none #000000;
-moz-column-rule: 1px none #000000;">
        {!! $data['text2'] !!}</p>


    <h2 class="section-title">Perkembangan Fisik Motorik</h2>
    <p
        style="column-count: 2;
-webkit-column-count: 2;
-moz-column-count: 2;
column-gap: 20px;
-webkit-column-gap: 20px;
-moz-column-gap: 20px;
column-rule: 1px none #000000;
-webkit-column-rule: 1px none #000000;
-moz-column-rule: 1px none #000000;">
        {!! $data['text3'] !!}</p>


    <h2 class="section-title">Perkembangan Sosial Emosional</h2>
    <p
        style="column-count: 2;
-webkit-column-count: 2;
-moz-column-count: 2;
column-gap: 20px;
-webkit-column-gap: 20px;
-moz-column-gap: 20px;
column-rule: 1px none #000000;
-webkit-column-rule: 1px none #000000;
-moz-column-rule: 1px none #000000;">
        {!! $data['text4'] !!}</p>


    <h2 class="section-title">Perkembangan Bahasa</h2>
    <p
        style="column-count: 2;
-webkit-column-count: 2;
-moz-column-count: 2;
column-gap: 20px;
-webkit-column-gap: 20px;
-moz-column-gap: 20px;
column-rule: 1px none #000000;
-webkit-column-rule: 1px none #000000;
-moz-column-rule: 1px none #000000;">
        {!! $data['text5'] !!}</p>


    <h2 class="section-title">Perkembangan Kognitif</h2>
    <p
        style="column-count: 2;
-webkit-column-count: 2;
-moz-column-count: 2;
column-gap: 20px;
-webkit-column-gap: 20px;
-moz-column-gap: 20px;
column-rule: 1px none #000000;
-webkit-column-rule: 1px none #000000;
-moz-column-rule: 1px none #000000;">
        {!! $data['text6'] !!}</p>
    <h2 class="section-title">Perkembangan Seni</h2>
    <p
        style="column-count: 2;
-webkit-column-count: 2;
-moz-column-count: 2;
column-gap: 20px;
-webkit-column-gap: 20px;
-moz-column-gap: 20px;
column-rule: 1px none #000000;
-webkit-column-rule: 1px none #000000;
-moz-column-rule: 1px none #000000;">
        {!! $data['text7'] !!}</p>

        <div class="page-break"></div>

    <h2 class="section-title">Rekapitulasi Kehadiran</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Absensi</th>
            <th>Jumlah</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Sakit</td>
            <td> {{ $absensi_sakit }} Hari</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Izin</td>
            <td>{{ $absensi_Izin }} Hari</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Tanpa Keterangan</td>
            <td> {{ $absensi_tanpa_keterangan }} Hari</td>
        </tr>
    </table>

    <div class="signature">
        <p>Makassar, {{ $data['tanggal'] }}</p>
        <p><strong>Kepala Sekolah</strong></p>
        <p>PAUD Insan Masagena</p>
        <br><br>
        <p><strong>Syahrina Zulfitriyanti S.S S.Pd</strong></p>
    </div>

</body>

</html>
