@extends('purple')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Pet Shop Lontar</h1>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Edit Transaksi</h3>

    </div>
    <div class="card-body">
      <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
      <br><br>

      <form action="{{ route('transactions.update', $tM->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="form-group">
          <label for="">Nomor Unik</label>
          <input name="nomor_unik" type="text" class="form-control" value="{{ $tM->nomor_unik }}" readonly>
          @error('nomor_unik')
          <p>{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="">Nomor Polisi</label>
          <input name="nomor_polisi" type="text" class="form-control" value="{{ $tM->nomor_polisi }}">
          @error('nomor_polisi')
          <p>{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="">Nama Pelanggan</label>
          <input name="nama_pelanggan" type="text" class="form-control" value="{{ $tM->nama_pelanggan}}">
          @error('nama_pelanggan')
          <p>{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="">Paket + Harga</label>
          <select name="id_produk" class="form-control" required>
            <option value="">Pilih Produk</option>
            @foreach ($pM as $data)
            <?php 
                    if($data->id == $tM->id_produk):
                         $selected = "selected";
                else:
                         $selected = "";
                endif
                ?>
            <option {{ $selected}} value="{{ $data->id }}">
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
          <input name="qty" type="text" class="form-control" value="{{ $tM->qty}}">
          @error('qty')
          <p>{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="">Uang Bayar</label>
          <input name="uang_bayar" type="number" class="form-control" value="{{ $tM->uang_bayar}}">
          @error('uang_bayar')
          <p>{{ $message }}</p>
          @enderror
        </div>

        <button type="submit" class="btn btn-warning" style="margin-left: 3px;"
          onclick="return confirm('Konfirmasi Edit Transaksi !?')">
          Simpan
        </button>

      </form>
    </div>
    <!-- /.card-body -->

  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
@endsection