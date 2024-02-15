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
                </div>

                @if (in_array(Auth::user()->role, ['kasir']))
                <a href="{{ route('transactions.create') }}" class="btn btn-outline-success"><i
                        class="mdi mdi-plus"></i>Tambah</a>
                <br><br>
                @endif
                @if (in_array(Auth::user()->role, ['owner']))
                <form action="{{ route('transactions.pdfFilter') }}" method="GET" style="font-size: 12px;">
                    <div class="form-group" id="dateRangePicker">
                        <label for="dateRangePicker">Pilih Rentang Tanggal Unduh Laporan:</label>
                        <div class="input-daterange input-group">
                            <input type="date" class="input-sm form-control" name="start_date"
                                style="font-size: 12px;" />
                            <div class="input-group-prepend ">
                                <span class="input-group-text"
                                    style="font-size: 12px; background-color: #4A1CA6;">Sampai</span>
                            </div>
                            <input type="date" class="input-sm form-control" name="end_date" style="font-size: 12px;" />
                            <button type="submit" class="btn btn-outline-primary"
                                style="margin-left: 10px; font-size: 12px;">
                                <i class="mdi mdi-download"></i>Laporan
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="resetDates()"
                                style="margin-left: 10px;">
                                <i class="mdi mdi-replay"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <script>
                    function resetDates() {
                        document.getElementsByName('start_date')[0].value = ''; // Reset nilai start_date
                        document.getElementsByName('end_date')[0].value = '';   // Reset nilai end_date
                    }
                </script>

                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="myTableT">
                        <thead class="table-purple table-light">
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Nomor Unik</th>
                                <th style="text-align: center;">Nomor Polisi</th>
                                <th style="text-align: center;">Nama Pelanggan</th>
                                <th style="text-align: center;">Paket</th>
                                <th style="text-align: center;">Total</th>
                                <th style="text-align: center;">Bayar</th>
                                <th style="text-align: center;">Kembali</th>
                                <th style="text-align: center;">Tanggal</th>
                                @if (in_array(Auth::user()->role, ['kasir','']))
                                <th style="text-align: center;">Aksi</th>
                                @endif
                            </tr>
                            <thead>
                            <tbody>
                                @foreach ($tM as $key => $trans)
                                <tr>
                                    <td style="text-align: center;">{{ (int) $key + 1 }}</td>
                                    <td style="text-align: center;">{{ $trans->nomor_unik }}
                                    </td>
                                    <td style="text-align: center;">{{ $trans->nomor_polisi }}
                                    </td>
                                    <td style="text-align: center;">{{ $trans->nama_pelanggan }}
                                    </td>
                                    <td style="text-align: left;">
                                        <ol class="list-item">
                                            @php
                                            $counter = 1; // variabel untuk nomor urut
                                            @endphp
                                            @foreach ($trans->id_produk as $produk)
                                            @php
                                            $produkName = \App\Models\PaketM::find($produk['id']);
                                            @endphp

                                            @if(isset($produkName))
                                            @php
                                            $totalProduk = $produkName->harga_produk * $produk['qty'];
                                            @endphp
                                            <li>{{ $produkName->nama_produk }} 
                                                <br>{{ $produk['qty'] }} x {{ number_format($produkName->harga_produk, 0, ',', '.') }}
                                            </li>
                                            @php
                                            $counter++; // increment nomor urut
                                            @endphp
                                            @endif
                                            @endforeach
                                        </ol>
                                    </td>

                                    <td style="text-align: center;">Rp {{
                                        number_format($trans->total_harga, 0, ',', '.')}}
                                    </td>
                                    <td style="text-align: center;">Rp {{
                                        number_format($trans->uang_bayar, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: center;">Rp {{
                                        number_format($trans->uang_kembali, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: center;">{{ $trans->created_at }}
                                    </td>
                                    @if (in_array(Auth::user()->role, ['kasir','']))
                                    <td style="text-align: center;">
                                        @endif
                                        @if (in_array(Auth::user()->role, ['kasir']))
                                        <a href="{{ url('transactions/struk', $trans->id) }}"
                                            class="btn btn-outline-primary btn-xs" title="print struk"
                                            style="border-radius: 10px; margin-right: 5px;">
                                            <i class="mdi mdi-cloud-print"></i>
                                        </a>
                                        @endif
                                        @if (in_array(Auth::user()->role, ['']))
                                        <div class="btn-group">
                                            <a href="{{ route('transactions.edit',$trans->id)}}"
                                                class="btn btn-outline-warning btn-xs"
                                                style="border-radius: 10px; margin-right: 5px;">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            @endif
                                            @if (in_array(Auth::user()->role, ['']))
                                            <form action="{{ route('transactions.destroy', $trans->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-outline-danger btn-xs"
                                                    title="Hapus" style="border-radius: 10px; margin-left: 5px;"
                                                    onclick="confirmDelete()">
                                                    <i class="mdi mdi-delete-forever"></i>
                                                </button>
                                            </form>

                                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                                <script type="text/javascript">
                                                    function confirmDelete() {
                                                        Swal.fire({
                                                            title: 'Konfirmasi Dulu!',
                                                            text: 'Apakah Anda yakin ingin menghapus transaksi?',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#d33',
                                                            cancelButtonColor: '#3085d6',
                                                            confirmButtonText: 'Ya',
                                                            cancelButtonText: 'Batal'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // Submit the form when user confirms
                                                                $('form').submit();
                                                            }
                                                        });
                                                    }
                                                </script>

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
        background-color: #4A1CA6;
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
    $(document).ready(function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ $message }}",
            showConfirmButton: false,
            timer: 2000
        });
    });
</script>
@endif
@endsection