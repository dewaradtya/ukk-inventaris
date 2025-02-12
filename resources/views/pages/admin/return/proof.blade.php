<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Bukti Pengembalian</title>
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

        .header h2 {
            font-weight: bold;
            margin: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 12px 15px;
            vertical-align: middle;
        }

        .table th, .bg-light {
            background-color: #e9ecef;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>BUKTI PENGEMBALIAN</h2>
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
            <td>{{ \Carbon\Carbon::parse($borrowing->return_date)->translatedFormat('d M Y') }}</td>
        </tr>
        <tr>
            <td class="bg-light"><strong>Status</strong></td>
            <td><strong>Dikembalikan</strong></td>
        </tr>
    </table>

    <p>Barang-barang berikut telah dikembalikan dalam kondisi yang sesuai:</p>

    <table class="table">
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

    <p><strong>Note:</strong> Semua barang telah diterima kembali dalam kondisi baik oleh Admin Inventaris.</p>

    <div style="margin-top: 80px;">
        <table style="text-align: center; width: 100%;">
            <tr>
                <td style="text-align: center; width: 50%;">
                    <div>Admin Inventaris,</div>
                    <div style="margin-top: 80px; font-weight: bold; text-decoration: underline;">
                        {{ optional($borrowing->loanDetails->first()?->inventory?->user)->name ?? 'Tidak Diketahui' }}
                    </div>
                </td>
                <td style="text-align: center; width: 50%;">
                    <div>Peminjam,</div>
                    <div style="margin-top: 80px; font-weight: bold; text-decoration: underline;">
                        {{ $borrowing->employee->name ?? 'Tidak Diketahui' }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
