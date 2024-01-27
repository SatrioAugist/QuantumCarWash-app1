@extends('purple')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Quantum Car Wash</h1>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Edit Data Paket</h3>
    </div>
    <div class="card-body">
      <a href="{{ route('paket.index') }}" class="btn btn-secondary">Kembali</a>
      <br><br>

      <form action="{{ route('paket.update', $pM->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="form-group">
          <label>Nama Paket</label>
          <input name="nama_produk" type="text" class="form-control" value="{{ $pM->nama_produk}}">
          @error('nama_produk')
          <p>{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label>Harga Paket</label>
          <input name="harga_produk" type="number" class="form-control" value="{{ $pM->harga_produk}}">
          @error('harga_produk')
          <p>{{ $message }}</p>
          @enderror
        </div>
        <button type="submit" class="btn btn-success" style="margin-left: 3px; font-family: Arial; font-size: 14px;"
          onclick="return confirm('Konfirmasi Edit Produk ?')">
          Simpan
        </button>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
@endsection