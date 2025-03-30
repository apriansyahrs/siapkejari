<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Presensi - {{ \Carbon\Carbon::parse('01-'.$period)->translatedFormat('F Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .text-left {
            text-align: left !important;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        .attendance-table th,
        .attendance-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        .attendance-table th {
            background-color: #f0f0f0;
        }
        .signature-section {
            clear: both;
            margin-top: 30px;
            text-align: right;
        }
        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 200px;
            display: inline-block;
        }
        .weekend {
            background-color: #f0f0f0;
        }
        .holiday {
            background-color: #ffe4e4;
        }
        .late {
            color: red;
        }
        .early {
            color: orange;
        }
        .legend {
            margin-top: 20px;
            font-size: 10px;
        }
        .legend-item {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">KEJAKSAAN NEGERI BARITO UTARA</div>
        <div>Jl. Yetro Sinseng No.32, Lanjas, Teweh Tengah, Kab. Barito Utara</div>
    </div>

    <div class="report-title">
        REKAP PRESENSI<br>
        Periode: {{ \Carbon\Carbon::parse('01-'.$period)->translatedFormat('F Y') }}
    </div>

    <table class="attendance-table">
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Pegawai</th>
                <th>HADIR</th>
                <th>IZIN</th>
                <th>SAKIT</th>
                <th>CUTI</th>
                <th>TK</th>
                <th>TAP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $index => $item)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $item->employee->nik }}</td>
                <td class="text-left">{{ strtoupper($item->employee->name) }}</td>
                <td>{{ $item->hadir }}</td>
                <td>{{ $item->izin }}</td>
                <td>{{ $item->sakit }}</td>
                <td>{{ $item->cuti }}</td>
                <td>{{ $item->tanpa_keterangan }}</td>
                <td>{{ $item->tidak_absen_pulang }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="legend">
        <div class="legend-item">Dicetak pada : {{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</div>
    </div>
</body>
</html>
