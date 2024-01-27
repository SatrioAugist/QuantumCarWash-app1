@extends('purple')
@section('content')

<div class="card">
    <div class="card-header">
      <h3 class="card-title">Tambah Data Meja</h3>
    </div>
    <div class="card-body">
      <a href="{{ route('paket.index') }}" class="btn btn-secondary">Kembali</a>
      <br><br>

      <form action="{{ route('paket.store') }}" method="POST">
        @csrf


        <div class="form-group">
          <label>Nama Produk</label>
          <input name="nama_produk" type="text" class="form-control" placeholder="..." required>
          @error('nama_produk')
          <p>{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label>Harga Produk</label>
          <input name="harga_produk" type="text" class="form-control" placeholder="..." required>
          @error('harga_produk')
          <p>{{ $message }}</p>
          @enderror
        </div>

        <button type="submit" class="btn btn-success" style="margin-left: 3px;"
                onclick="return confirm('Konfirmasi Tambah Transaksi !?')">
                <i class="mdi mdi-plus"> Tambah</i>
            </button>
      </form>
    </div>
    <!-- /.card-body -->
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

@endsection