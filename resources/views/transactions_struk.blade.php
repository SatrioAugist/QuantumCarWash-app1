<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: "Arial", sans-serif;
            text-align: center;
        }

        .receipt {
            width: 100%;
            max-width: 300px; /* Lebar maksimal untuk tampilan struk pada umumnya */
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #000;
            box-sizing: border-box;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .separator {
            border-top: 1px dashed #000;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .receipt-item {
            margin-bottom: 5px;
            text-align: left;
        }

        .item-label {
            display: inline-block;
            width: 170px; 
            text-align: left;
        }
        
        
        .product-list {
            text-align: left;
            margin: 10px 0 ;
        }

        .product-item {
            font-size: 14px;
            margin-bottom: 5px;
            display: inline-block;
            width: 100%;
        }

        .product-price {
            display: inline-block;
            width: 170px; 
            text-align: left; 
        }

        

        .thank-you {
            font-style: italic;
            margin-top: 10px;
            font-size: 14px;
        }

        .footer {
            margin-top: 15px;
            font-size: 12px;
        }

        /* Media query untuk mencetak */
        @media print {
            .receipt {
                max-width: none; /* Hilangkan batasan lebar ketika dicetak */
                width: 100%;
                border: none;
            }
        }
    </style>
</head>

<body>

    <div class="receipt">
        <br>
        <h1>Quantum Car Wash</h1>
        <br>
        <div class="receipt-item">
            <span class="item-label">Pelanggan</span> : {{ $tM->nama_pelanggan }}
        </div>
        <div class="receipt-item">
            <span class="item-label">Tanggal</span> : {{ \Carbon\Carbon::parse($tM->created_at)->format('d-m-Y') }}
        </div>
        <div class="receipt-item">
            <span class="item-label">Kode Transaksi</span> : {{ $tM->nomor_unik }}
        </div>
        <div class="receipt-item">
            <span class="item-label">Nomor Polisi</span> : {{ $tM->nomor_polisi }}
        </div>
        <div class="separator"></div>
        <div class="product-list">
            @if(isset($tM->id_produk) && is_array($tM->id_produk))
                @php
                    $counter = 1; // variabel untuk nomor urut
                @endphp
                @foreach ($tM->id_produk as $produk)
                    @php
                        $produkName = \App\Models\PaketM::find($produk['paket']);
                    @endphp

                    @if(isset($produkName))
                        <div class="product-item">{{ $counter }}. {{ $produkName->nama_produk }}  </div>
                        <span class="product-price">{{ $produk['qty'] }} x {{ number_format($produkName->harga_produk, 0, ',', '.') }} </span>: Rp {{ number_format($produk['total_harga'], 0, ',', '.') }}
                        @php
                            $counter++; // increment nomor urut
                        @endphp
                    @endif
                @endforeach
            @endif
        </div>
        <div class="separator"></div>
        <div class="receipt-item total">
            <span class="item-label">Total</span> : Rp {{ number_format($tM->total_harga, 0, ',', '.') }}
        </div>
        <div class="receipt-item">
            <span class="item-label">Bayar</span> : Rp {{ number_format($tM->uang_bayar, 0, ',', '.') }}
        </div>
        <div class="receipt-item">
            <span class="item-label">Kembalian</span> : Rp {{ number_format($tM->uang_kembali, 0, ',', '.') }}
        </div>
        <div class="separator"></div>
        <div class="thank-you">
            Terima kasih atas kunjungan Anda!
        </div>
        <div class="footer">
            Layanan Pelanggan: +62 899-7318-350
        </div>
    </div>

</body>

</html>
