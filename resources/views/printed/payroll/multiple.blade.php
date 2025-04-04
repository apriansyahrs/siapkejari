<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Penggajian Karyawan - {{ $month }} {{ $year }}</title>
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
        .slip-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .summary {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 10px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .signature {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">KEJAKSAAN NEGERI BARITO UTARA</div>
        <div>Jl. Yetro Sinseng No.32, Lanjas, Teweh Tengah, Kab. Barito Utara</div>
    </div>

    <div class="slip-title">REKAPITULASI PENGGAJIAN KARYAWAN</div>
    <p>Periode: {{ $month }} {{ $year }}</p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan PPH 21</th>
                <th>Potongan PPH 21</th>
                <th>Potongan Absensi</th>
                <th>Iuran Jamkes</th>
                <th>Iuran Jamkes Kel. Lainnya</th>
                <th>Gaji Bersih</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payrolls as $index => $payroll)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $payroll->employee->name }}</td>
                <td>{{ $payroll->employee->position->name ?? '-' }}</td>
                <td style="text-align: right">Rp. {{ number_format($payroll->salary, 0, '', ',') }}</td>
                <td style="text-align: right">Rp. {{ number_format($payroll->pph_21_allowance, 0, '', ',') }}</td>
                <td style="text-align: right">Rp. {{ number_format($payroll->pph_21_deduction, 0, '', ',') }}</td>
                <td style="text-align: right">Rp. {{ number_format($payroll->attendance_deduction, 0, '', ',') }}</td>
                <td style="text-align: right">Rp. {{ number_format($payroll->health_insurance_contribution, 0, '', ',') }}</td>
                <td style="text-align: right">Rp. {{ number_format($payroll->other_family_health_insurance_contribution, 0, '', ',') }}</td>
                <td style="text-align: right">Rp. {{ number_format($payroll->net_salary, 0, '', ',') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p>Total Pengeluaran Gaji: Rp. {{ number_format($totalSalary, 0, '', ',') }}</p>
    </div>

    <div class="footer">
        Barito Utara, {{ date('d F Y') }}<br>
        Kepala Bagian Keuangan,<br><br>
        <br>
        <br>
        <br>
        <div class="signature">
            <p style="margin: 0">IOKPIANNUS S KASUMA S.H., M.H</p>
            <p style="margin: 0">NIP. 198705262006041001</p>
        </div>
    </div>
</body>
</html>
