<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Presensi - {{ $employee->name }} {{ \Carbon\Carbon::parse('01-'.$period)->translatedFormat('F Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
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
        .info-section {
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 3px 0;
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
        .summary-table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
            float: right;
        }
        .summary-table th,
        .summary-table td {
            border: 1px solid #000;
            padding: 5px;
        }
        .summary-table th {
            background-color: #f0f0f0;
            text-align: left;
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
        REKAP PRESENSI PEGAWAI<br>
        Periode: {{ \Carbon\Carbon::parse('01-'.$period)->translatedFormat('F Y') }}
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td width="120">Nama Pegawai</td>
                <td width="10">:</td>
                <td>{{ $employee->name }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $employee->nik }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $employee->position->name }}</td>
            </tr>
        </table>
    </div>

    <table class="attendance-table">
        <thead>
            <tr>
                <th rowspan="2">Tanggal</th>
                <th colspan="2">Jam Kerja</th>
                <th colspan="2">Aktual</th>
                <th rowspan="2">Total<br>Jam</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th>Masuk</th>
                <th>Pulang</th>
                <th>Masuk</th>
                <th>Pulang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->checkin_date)->format('d-m-Y') }}</td>
                <td>{{ $item->status === 'Libur' ? '-' : '08:00' }}</td>
                <td>{{ $item->status === 'Libur' ? '-' : '16:00' }}</td>
                <td>{{ $item->checkin_time ? \Carbon\Carbon::parse($item->checkin_time)->format('H:i') : '-' }}</td>
                <td>{{ $item->checkout_time ? \Carbon\Carbon::parse($item->checkout_time)->format('H:i') : '-' }}</td>
                <td>{{ $item->working_hour ? \Carbon\Carbon::createFromTimestamp($item->working_hour * 60)->format('H:i') : '-' }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->note ?: '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary-table">
        <tr>
            <th>Hadir</th>
            <td align="center">{{ $totalAttended }} hari</td>
        </tr>
        <tr>
            <th>Terlambat</th>
            <td align="center">{{ $totalCheckinLate }} kali</td>
        </tr>
        <tr>
            <th>Pulang Awal</th>
            <td align="center">{{ $totalCheckoutEarly }} kali</td>
        </tr>
        <tr>
            <th>Sakit</th>
            <td align="center">{{ $totalSick }} hari</td>
        </tr>
        <tr>
            <th>Izin</th>
            <td align="center">{{ $totalPermission }} hari</td>
        </tr>
        <tr>
            <th>Tanpa Keterangan</th>
            <td align="center">{{ $totalWithoutExplanation }} hari</td>
        </tr>
        <tr>
            <th>Tidak Absen Pulang</th>
            <td align="center">{{ $totalNoAttendanceCheckout }} kali</td>
        </tr>
        <tr>
            <th>Total Jam Kerja</th>
            <td align="center">{{ $totalWorkingHour }}</td>
        </tr>
    </table>

    <div class="legend">
        <div class="legend-item">Dicetak pada : {{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</div>
    </div>
</body>
</html>
