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

      <form action="{{ route('paket.update', $pM->id) }}" method="POST" id="paketEdit">
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
        <button type="button" class="btn btn-warning" style="margin-left: 3px;" onclick="confirmSubmit()">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function confirmSubmit() {
        Swal.fire({
            title: 'Konfirmasi Dulu!',
            text: 'Apakah Anda yakin ingin mengedit paket?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                // Submit the form when the user confirms
                document.getElementById('paketEdit').submit();
            }
        });
    }
</script>
@endsection