<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: "Arial", sans-serif;
            text-align: center;
        }

        h1 {
            text-align: center;
        }

        .receipt {
            width: 100%;
            max-width: 300px; /* Lebar maksimal untuk tampilan struk pada umumnya */
            padding: 20px;
        }

        .receipt-item {
            margin-bottom: 10px;
            text-align: left;
        }

        .item-label {
            font-weight: bold;
        }

        .separator {
            border-top: 1px dashed #000;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .thank-you {
            font-style: italic;
            margin-top: 10px;
        }

        /* Media query untuk mencetak */
        @media print {
            .receipt {
                max-width: none; /* Hilangkan batasan lebar ketika dicetak */
                width: 100%;
            }
        }
    </style>
</head>

<body>

    @foreach($tM as $data)
    <div class="receipt">
        <h1>Quantum Car Wash</h1>
        <div class="separator"></div>
        <div class="receipt-item">
            <span class="item-label">Nama Pelanggan:</span> {{ $data->nama_pelanggan }}
        </div>
        <div class="receipt-item">
            <span class="item-label">Tanggal:</span> {{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}
        </div>
        <div class="separator"></div>
        <div class="receipt-item">
            <span class="item-label">Nomor Unik:</span> {{ $data->nomor_unik }}
        </div>
        <div class="receipt-item">
            <span class="item-label">Nomor Polisi:</span> {{ $data->nomor_polisi }}
        </div>
        <div class="receipt-item">
            <span class="item-label">Paket:</span> {{ $data->nama_produk }}
        </div>
        <div class="receipt-item">
            <span class="item-label">Harga:</span> Rp {{ number_format($data->harga_produk, 0, ',', '.') }}
        </div>
        <div class="receipt-item">
            <span class="item-label">Jumlah:</span> {{ $data->qty }}
        </div>
        <div class="separator"></div>
        <div class="receipt-item">
            <span class="item-label">Total:</span> {{ $data->total }}
        </div>
        <div class="receipt-item">
            <span class="item-label">Bayar:</span> Rp {{ number_format($data->uang_bayar, 0, ',', '.') }}
        </div>
        <div class="receipt-item">
            <span class="item-label">Kembalian:</span> Rp {{ number_format($data->uang_kembali, 0, ',', '.') }}
        </div>
        <div class="separator"></div>
        <div class="thank-you">
            Terima kasih atas kunjungan Anda!
        </div>
    </div>
    @endforeach
</body>

</html>
