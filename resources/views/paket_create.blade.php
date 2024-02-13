@extends('purple')
@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Quantum car Wash</h1>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>

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
        <label>Nama Paketan</label>
        <input name="nama_produk" type="text" class="form-control" placeholder="..." required>
        @error('nama_produk')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label>Harga</label>
        <input name="harga_produk" type="text" class="form-control" placeholder="..." required>
        @error('harga_produk')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <button type="submit" class="btn btn-success" style="margin-left: 3px;"
        onclick="return confirm('Konfirmasi Tambah Transaksi !?')">
        Tambah
      </button>
    </form>
  </div>
  <!-- /.card-body -->
  <!-- /.card-footer-->
</div>
<!-- /.card -->

@endsection