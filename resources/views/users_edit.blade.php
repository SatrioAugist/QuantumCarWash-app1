@extends('purple')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Quantum car Wash</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Edit Data Pengguna</h3>
    </div>
    <div class="card-body">
      <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
      <br><br>

      <form action="{{ route('users.update', $data->id) }}" method="POST" id="usersEdit">
        @csrf
        @method('put')
        <div class="form-group">
          <label>Username</label>
          <input name="username" type="text" class="form-control" value="{{ $data->username }}">
          @error('username')
          <p>{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label>Nama Lengkap</label>
          <input name="nama" type="text" class="form-control" value="{{ $data->nama }}">
          @error('nama')
          <p>{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label>Role</label>
          <select name="role" class="form-control">
            <option value="-Pilih Role-" {{ $data->role == null ? 'selected' : '' }}>-Pilih Role-</option>
            <option value="kasir" {{ $data->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
            <option value="owner" {{ $data->role == 'owner' ? 'selected' : '' }}>Owner</option>
            <option value="admin" {{ $data->role == 'admin' ? 'selected' : '' }}>Admin</option>
          </select>
          @error('role')
          <p>{{ $message }}</p>
          @enderror
        </div>

          <button type="button" class="btn btn-warning" style="margin-left: 3px;" onclick="confirmSubmit()">
            Simpan
          </button>
      </form>
    </div>
    <!-- /.card-body -->
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function confirmSubmit() {
        Swal.fire({
            title: 'Konfirmasi Dulu!',
            text: 'Apakah Anda yakin ingin mengedit data pengguna?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                // Submit the form when the user confirms
                document.getElementById('usersEdit').submit();
            }
        });
    }
</script>
@endsection
