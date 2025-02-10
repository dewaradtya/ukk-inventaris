<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Bukti Peminjaman</title>
    <style>
        @page {
            margin: 2cm;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #fff;
            color: #333;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h4 {
            font-weight: bold;
            margin: 0;
        }

        .header p {
            color: #666;
            margin: 5px 0 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 12px 15px;
            vertical-align: middle;
        }

        .table th,
        .bg-light {
            background-color: #e9ecef;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            page-break-inside: avoid;
        }

        .signature-block {
            width: 40%;
        }

        .signature-block.right {
            text-align: right;
        }

        .signature-line {
            border-bottom: 2px solid #000;
            width: 150px;
            margin: 50px 0 10px;
        }

        .signature-block.right .signature-line {
            margin-left: auto;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <div>
            <h2>BUKTI PEMINJAMAN</h2>
        </div>
    </div>

    <table class="table">
        <tr>
            <td class="bg-light" style="width: 35%"><strong>Nama Peminjam</strong></td>
            <td>{{ $borrowing->employee->name ?? 'Tidak Diketahui' }}</td>
        </tr>
        <tr>
            <td class="bg-light"><strong>Tanggal Peminjaman</strong></td>
            <td>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->translatedFormat('d M Y') }}</td>
        </tr>
        <tr>
            <td class="bg-light"><strong>Tanggal Pengembalian</strong></td>
            <td>{{ $borrowing->return_date ? \Carbon\Carbon::parse($borrowing->return_date)->translatedFormat('d M Y') : '-' }}
            </td>
        </tr>
        <tr>
            <td class="bg-light"><strong>Status</strong></td>
            <td>
                {{ $borrowing->loan_status === 'borrow' ? 'Dipinjam' : 'Dikembalikan' }}
            </td>
        </tr>
    </table>

    <p style="margin-bottom: 10px;">Berikut adalah daftar barang yang dipinjam oleh pegawai
        {{ $borrowing->employee->name ?? 'Tidak Diketahui' }}:</p>

    <table class="table" style="margin-bottom: 10px;">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th>Nama Inventaris</th>
                <th style="width: 20%" class="text-center">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($borrowing->loanDetails as $index => $loanDetail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $loanDetail->inventory->name ?? 'Inventaris Tidak Ditemukan' }}</td>
                    <td class="text-center">{{ $loanDetail->amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div><strong>Note:</strong> Harap mengembalikan barang yang dipinjam tepat waktu sesuai dengan tanggal pengembalian
        yang tertera di atas.</div>

    <div style="margin-top: 80px;">
        <table style="text-align: center; width: 100%;">
            <tr>
                <td style="text-align: center; width: 50%;">
                    <div>Petugas,</div>
                    <div style="margin-top: 80px; font-weight: bold; text-decoration: underline;">
                        {{ optional($borrowing->loanDetails->first()?->inventory?->user)->name ?? 'Tidak Diketahui' }}
                    </div>
                    <div>Admin Inventaris</div>
                </td>
                <td style="text-align: center; width: 50%;">
                    <div>Peminjam,</div>
                    <div style="margin-top: 80px;">
                        <div style="font-weight: bold; text-decoration: underline;">
                            {{ $borrowing->employee->name ?? 'Tidak Diketahui' }}
                        </div>
                        <div>Pegawai</div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
