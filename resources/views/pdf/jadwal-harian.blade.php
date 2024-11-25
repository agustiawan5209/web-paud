<!DOCTYPE html>
<html>

<head>
    <title>Data Penyewaan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .header h2,
        .header h3,
        .header p {
            margin: 0;
            padding: 0;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        .content table,
        .content th,
        .content td {
            border: 1px solid black;
        }

        .content th,
        .content td {
            padding: 8px;
            text-align: left;
        }

        .title-card {
            width: 100%;
            text-align: center;
            margin: 0;
        }

        .title-card * {
            margin: 0;
        }

        .content-head {
            background-color: #ffbf8e;
        }

        .ttd {
            border: 0;
            width: 100%;
            position: relative;
            text-align: right;
            font-size: 12px;

        }

        .ttd table {
            position: absolute;
            right: 0;
        }

        .ttd table td {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        {{-- <img src="{{ asset('path/to/logo.png') }}" alt="Logo Perusahaan"> --}}
        <h2>YAYASAN ANAK MADANI MASAGENA</h2>
        <h3>PAUD INSAN MASAGENA</h3>
        <p>Jalan Hertasning Bok E10 Noor 11 RT/RW 00/006 Kelurahan Tidung</p>
        <p>Kecamatan Rappocini, Kota Makassar. Telp: 0411-869762</p>
        <p>email: insanmasagena@gmail.com</p>
        <hr>
    </div>
    <div class="content">
        <div class="title-card">
            <h5>KEGIATAN HARIAN PAUD INSAN MASAGENA</h5>
            <h5>PAUD INSAN MASAGENA</h5>
            <h5>KELAS: {{ $kelas->kode }}</h5>
        </div>
        <table>
            <thead class="content-head">
                <tr>
                    <th>Jam</th>
                    <th>Kegiatan</th>
                    <th>Program Pengembangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwal->jadwal as $item)
                    <tr>
                        <td>{{ $item['jam'] }}</td>
                        <td>{{ $item['kegiatan'] }}</td>
                        <td>{{ $item['pengembangan'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <br><br>
    <div class="ttd">
        <table>
            <tr>
                <td>Makassar, <span>&nbsp;&nbsp;</span> {{ date(' F Y') }} <br>
                    Kepala Sekolah
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <span>Kepala Sekolah</span>


                </td>
            </tr>
        </table>
    </div>
</body>

</html>
