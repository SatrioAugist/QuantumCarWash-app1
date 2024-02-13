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
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Paket</h4>
        </div>
        <div class="card-body">
            <div id="success-message" class="alert alert-success" style="display: none;">
                <!-- Success message content -->
            </div>

            @if (in_array(Auth::user()->role, ['admin']))
            <a href="{{ route('paket.create') }}" class="btn btn-outline-success"><i class="mdi mdi-plus"></i>Tambah</a>
            <a href="{{ route('paket.pdf') }}" class="btn btn-outline-success"><i class="mdi mdi-download"></i>Laporan</a>
            <br>
            <br>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="myTable">
                    <thead class="table-purple table-light">
                        <tr>
                            <th style="text-align: center; vertical-align: middle;">No</th>
                            <th style="text-align: center; vertical-align: middle;">Paket</th>
                            <th style="text-align: center; vertical-align: middle;">Harga</th>
                            @if (in_array(Auth::user()->role, ['admin']))

                            <th style="text-align: center; vertical-align: middle;">Aksi</th>
                            @endif
                        </tr>
                        <thead>
                        <tbody>
                            @foreach ($pM as $key => $paket)
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">{{ (int) $key + 1 }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $paket->nama_produk }}</td>
                                <td style="text-align: center; vertical-align: middle;">Rp {{
                                    number_format($paket->harga_produk, 0, ',', '.') }}</td>
                                @if (in_array(Auth::user()->role, ['admin']))
                                <td style="text-align: center; vertical-align: middle;">
                                    <div class="btn-group">
                                        <a href="{{ route('paket.edit', $paket->id)}}"
                                            class="btn btn-outline-warning btn-xs"
                                            style="border-radius: 10px; margin-right: 5px;" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>

                                        <form action="{{ route('paket.destroy', $paket->id)}}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-outline-danger btn-xs"
                                                style="border-radius: 10px; margin-left: 5px;"
                                                title="Hapus"
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
    #myTable tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
        /* Warna abu-abu muda */
        color: #000000;
        /* Warna teks hitam */
    }

    /* Warna latar belakang dan teks untuk baris tabel genap */
    #myTable tbody tr:nth-child(even) {
        background-color: #ffffff;
        /* Warna putih */
        color: #000000;
        /* Warna teks hitam */
    }
</style>
<script type="text/javascript">
    let table = new DataTable('#myTable');
</script>

@if($message = Session::get('success'))
<script>
    // Display the success message
    $(document).ready(function () {
        $("#success-message").html("{{ $message }}").fadeIn().delay(3000).fadeOut(); // 3000 milliseconds (3 seconds)
        @if (Session:: has('success'))
    { { Session:: forget('success') } }
    @endif
        });
</script>
@endif
@endsection