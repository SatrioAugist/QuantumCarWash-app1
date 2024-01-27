@extends('purple')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quantum Car Wash</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Transaksi</h4>
            </div>

            <div class="card-body">
                <div id="success-message" class="alert alert-success" style="display: none;">
                    <!-- Success message content -->
                </div>

                @if (in_array(Auth::user()->role, ['kasir']))
                <a href="{{ route('transactions.create') }}" class="btn btn-outline-success">Tambah Data</a>
                <br><br>
                @endif
                @if (in_array(Auth::user()->role, ['owner']))
                <form action="{{ route('transactions.pdfFilter') }}" method="GET" style="font-size: 12px;">
                    <div class="form-group" id="dateRangePicker">
                        <label for="dateRangePicker">Pilih Range Tanggal Unduh PDF:</label>
                        <div class="input-daterange input-group">
                            <input type="date" class="input-sm form-control" name="start_date"
                                style="font-size: 12px;" />
                            <div class="input-group-prepend ">
                                <span class="input-group-text"
                                    style="font-size: 12px; background-color: #800080;">Sampai</span>
                            </div>
                            <input type="date" class="input-sm form-control" name="end_date" style="font-size: 12px;" />
                            <button type="submit" class="btn btn-primary"
                                style=" margin-left: 10px; font-size: 12px;"><i class="mdi mdi-download"></i> Unduh
                                PDF</button>
                        </div>
                    </div>
                </form>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="myTableT">
                        <thead class="table-purple table-light">
                            <tr>
                                <th style="text-align: center; vertical-align: middle;">No</th>
                                <th style="text-align: center; vertical-align: middle;">Nomor Unik</th>
                                <th style="text-align: center; vertical-align: middle;">Nomor Polisi</th>
                                <th style="text-align: center; vertical-align: middle;">Nama Pelanggan</th>
                                <th style="text-align: center; vertical-align: middle;">Paket</th>
                                <th style="text-align: center; vertical-align: middle;">Harga</th>
                                <th style="text-align: center; vertical-align: middle;">Jumlah</th>
                                <th style="text-align: center; vertical-align: middle;">Total</th>
                                <th style="text-align: center; vertical-align: middle;">Bayar</th>
                                <th style="text-align: center; vertical-align: middle;">Kembali</th>
                                <th style="text-align: center; vertical-align: middle;">Tanggal</th>
                                @if (in_array(Auth::user()->role, ['kasir','admin']))
                                <th style="text-align: center; vertical-align: middle;">Aksi</th>
                                @endif
                            </tr>
                            <thead>
                            <tbody>
                                @foreach ($tM as $key => $trans)
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;">{{ (int) $key + 1 }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $trans->nomor_unik }}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $trans->nomor_polisi }}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $trans->nama_pelanggan }}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $trans->nama_produk }}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">Rp {{
                                        number_format($trans->harga_produk, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $trans->qty }}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">Rp {{
                                        number_format($trans->total, 0, ',', '.')}}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">Rp {{
                                        number_format($trans->uang_bayar, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">Rp {{
                                        number_format($trans->uang_kembali, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $trans->tanggal }}
                                    </td>
                                    @if (in_array(Auth::user()->role, ['kasir','admin']))
                                    <td style="text-align: center; vertical-align: middle;">
                                    @endif
                                    @if (in_array(Auth::user()->role, ['kasir']))
                                    <a href="{{ url('transactions/struk', $trans->id_trans) }}"
                                        class="btn btn-outline-primary btn-xs"
                                        style="border-radius: 10px; margin-right: 5px;">
                                        <i class="mdi mdi-cloud-print"></i>
                                    </a>
                                    @endif
                                    @if (in_array(Auth::user()->role, ['admin']))
                                        <div class="btn-group">
                                            <a href="{{ route('transactions.edit',$trans->id_trans)}}"
                                                class="btn btn-outline-warning btn-xs"
                                                style="border-radius: 10px; margin-right: 5px;">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            
                                            <form action="{{ route('transactions.destroy', $trans->id_trans) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-outline-danger btn-xs"
                                                    style="border-radius: 10px; margin-left: 5px;"
                                                    onclick="return confirm('Konfirmasi Hapus Data !?')">
                                                    <i class="mdi mdi-delete-forever"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    /* Warna latar belakang dan teks untuk header tabel */
    .table-purple th {
        background-color: #800080;
        /* Warna ungu */
        color: #ffffff;
        /* Warna teks putih */
    }

    /* Warna latar belakang dan teks untuk baris tabel ganjil */
    #myTableT tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
        /* Warna abu-abu muda */
        color: #000000;
        /* Warna teks hitam */
    }

    /* Warna latar belakang dan teks untuk baris tabel genap */
    #myTableT tbody tr:nth-child(even) {
        background-color: #ffffff;
        /* Warna putih */
        color: #000000;
        /* Warna teks hitam */
    }
</style>

<script type="text/javascript">
    let table = new DataTable('#myTableT');
</script>
@if($message = Session::get('success'))
<script>
    // Display the success message
    $(document).ready(function () {
        $("#success-message").html("{{ $message }}").fadeIn().delay(3000).fadeOut(); // 3000 milliseconds (3 seconds)
    });
</script>
@endif
@endsection