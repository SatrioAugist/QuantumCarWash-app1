<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 15px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1,
        h2,
        p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 5px;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody td {
            text-align: center;
        }

        .summary {
            margin-top: 18px;
        }

        .footer {
            margin-top: 25px;
            text-align: right;
        }

        .hp {
            text-align: left;
        }

        .signature {
            margin-top: 70px;
            text-align: right;
        }
    </style>
</head>

<body>
    <header>
        <h1>Laporan Transaksi</h1>
        <div class="hp">
            <p>Tanggal: {{ date('Y-m-d') }}</p>
        </div>
    </header>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Unik</th>
                <th>Nomor Polisi</th>
                <th>Nama Pelanggan</th>
                <th>Paketan</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php
            $totalPendapatan = 0;
            @endphp
            @foreach ($tM as $key => $trans)
            <tr>
                <td style="text-align: center;">{{ (int) $key + 1 }}</td>
                <td style="text-align: center;">{{ $trans->nomor_unik }}</td>
                <td style="text-align: center;">{{ $trans->nomor_polisi }}</td>
                <td style="text-align: center;">{{ $trans->nama_pelanggan }}</td>
                <td style="text-align: left;">
                      
                            @if(isset($trans->id_produk) && is_array($trans->id_produk))
                                @php $counter = 1; @endphp
                                @foreach ($trans->id_produk as $produk)
                                    @php
                                        $produkName = \App\Models\PaketM::find($produk['paket']);
                                    @endphp

                                    @if(isset($produkName))
                                        <p>{{ $counter }}. {{ $produkName->nama_produk }} - {{ $produk['qty'] }} x <br> Rp. {{ number_format($produk['total_harga'], 0, ',', '.') }}</p>
                                        @php
                                            $counter++;
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                     
                    </td>
                <td style="text-align: center;">Rp {{ number_format($trans->total_harga, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ $trans->created_at }}</td>
            </tr>
            @php
            $totalPendapatan += $trans->total_harga;
            @endphp
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h2>Ringkasan</h2>
        <p>Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }} </p>
    </div>

    <div class="footer">
        <p>Terima kasih atas kerjasamanya.</p>
    </div>

    <div class="signature">
        <p>___________________________</p>
    </div>
</body>

</html>