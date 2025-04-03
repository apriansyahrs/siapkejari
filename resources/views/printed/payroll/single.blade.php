<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji Pegawai &mdash; {{ $payroll->employee->name }}</title>
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
        .compensation-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .compensation-table th,
        .compensation-table td {
            border: 1px solid #000;
            padding: 5px;
        }
        .compensation-table th {
            background-color: #f0f0f0;
        }
        .total-section {
            border-top: 2px solid #000;
            padding-top: 10px;
            text-align: right;
        }
        .signature-section {
            margin-top: 30px;
            text-align: right;
        }
        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 200px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">KEJAKSAAN NEGERI BARITO UTARA</div>
        <div>Jl. Yetro Sinseng No.32, Lanjas, Teweh Tengah, Kab. Barito Utara</div>
    </div>

    <div class="slip-title">SLIP GAJI PEGAWAI</div>
    <div class="info-section">
        <table class="info-table">
            <tr>
                <td width="120">Nama Pegawai</td>
                <td width="10">:</td>
                <td>{{ $payroll->employee->name }}</td>
                <td width="120">Periode</td>
                <td width="10">:</td>
                <td>{{ \Carbon\Carbon::parse($payroll->period)->translatedFormat('F Y') }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $payroll->employee->nik }}</td>
                <td>No. Rekening</td>
                <td>:</td>
                <td>{{ $payroll->account_number }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $payroll->employee->position->name }}</td>
            </tr>
        </table>
    </div>

    <table class="compensation-table">
        <tr>
            <th colspan="2" style="width: 50%;">PENGHASILAN</th>
            <th colspan="2" style="width: 50%;">POTONGAN</th>
        </tr>
        <tr>
            <td>Gaji Pokok</td>
            <td style="text-align: right">Rp. {{ number_format($payroll->salary, 0, '', ',') }}</td>
            <td>BPJS Kesehatan</td>
            <td style="text-align: right">Rp. {{ number_format($payroll->health_insurance_contribution + $payroll->other_family_health_insurance_contribution, 0, '', ',') }}</td>
        </tr>
        <tr>
            <td>Tunjangan Pph 21</td>
            <td style="text-align: right">Rp. {{ number_format($payroll->pph_21_allowance, 0, '', ',') }}</td>
            <td>PPh 21</td>
            <td style="text-align: right">Rp. {{ number_format($payroll->pph_21_deduction, 0, '', ',') }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>Potongan Absensi</td>
            <td style="text-align: right">Rp. {{ number_format($payroll->attendance_deduction, 0, '', ',') }}</td>
        </tr>
        <tr>
            <td><strong>Total Penghasilan</strong></td>
            <td style="text-align: right"><strong>Rp. {{ number_format($payroll->salary, 0, '', ',') }}</strong></td>
            <td><strong>Total Potongan</strong></td>
            <td style="text-align: right"><strong>Rp. {{ number_format($payroll->total_deduction, 0, '', ',') }}</strong></td>
        </tr>
    </table>

    <div class="total-section">
        <strong>Total Gaji Diterima: Rp. {{ number_format($payroll->net_salary, 0, '', ',') }}</strong>
    </div>

    <div class="signature-section">
        Barito Utara, {{ \Carbon\Carbon::parse($payroll->payment_date)->translatedFormat('d F Y') }}<br>
        Pejabat Pembuat Komitmen,<br><br>
        <br>
        <br>
        <br>
        <br>
        <p style="margin: 0">
            IOKPIANNUS S KASUMA S.H., M.H
        </p>
        <p style="margin: 0">
            NIP. 198705262006041001
        </p>
    </div>
</body>
</html>
