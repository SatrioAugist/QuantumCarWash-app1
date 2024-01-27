@extends('purple')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Data Transaksi</h3>
    </div>
        
    <div class="card-body">
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
        <br><br>

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="">Nomor Unik</label>
                <input name="nomor_unik" type="text" class="form-control" value="{{ random_int(1000000000, 9999999999) }}" readonly>
                @error('nomor_unik')
                <p>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Nomor Polisi</label>
                <input name="nomor_polisi" type="text" class="form-control" placeholder="..." required>
                @error('nomor_polisi')
                <p>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Nama Pelanggan</label>
                <input name="nama_pelanggan" type="text" class="form-control" placeholder="..." required>
                @error('nama_pelanggan')
                <p>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="">  Paket + Harga</label>
                <select name="id_produk" class="form-control" required>
                    <option value="">Pilih Produk</option>
                    @foreach ($pM as $data)
                        <option value="{{ $data->id }}">
                            {{ $data->nama_produk }} - {{$data->harga_produk}}
                        </option>
                    @endforeach
                </select>
                @error('id_produk')
                <p>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Jumlah</label>
                <input name="qty" id="qty" type="number" class="form-control" placeholder="..." oninput="calculateTotal()" required>
                @error('qty')
                <p>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-group">
                    <label for="">Total</label>
                    <input name="total_harga" id="total_harga" type="text" class="form-control" readonly>
                </div>
                <label for="">Uang Bayar</label>
                <input name="uang_bayar" type="number" class="form-control" placeholder="..." required>
                @error('uang_bayar')
                <p>{{ $message }}</p>
                @enderror
            </div>

            <!-- Tampilkan Total Harga -->

            <button type="submit" class="btn btn-success" style="margin-left: 3px;"
                onclick="return confirm('Konfirmasi Tambah Transaksi !?')">
                Tambah
            </button>
        </form>
    </div>
    <!-- /.card-body -->

</div>



<!-- /.card -->
<!-- /.content -->
@endsection
