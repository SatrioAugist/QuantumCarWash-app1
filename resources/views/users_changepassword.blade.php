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
        <h3 class="card-title">Ubah Password Pengguna</h3>
      </div>
      <div class="card-body">
      <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
    <br><br>
      <form action="{{ route('users.change', $users->id) }}" method="POST" id="usersChange">
        @csrf
        @method('put')
        <div class="form-group">
            <label>Username</label>
            <input name="username" type="text" class="form-control" placeholder="..." value="{{ $users->username }}" readonly>
            @error('username')
                <p>{{ $message }}</p>
            @enderror
        </div>

        {{-- <div class="form-group">
            <label>Password Lama</label>
            <input name="password_old" type="password" class="form-control" placeholder="...">
            @error('password_old')
                <p>{{ $message }}</p>
            @enderror
        </div> --}}

        <div class="form-group">
            <label>Password Baru</label>
            <input name="password_new" type="password" class="form-control" placeholder="...">
            @error('password_new')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>Ulangi Password</label>
            <input name="password_confirm" type="password" class="form-control" placeholder="...">
            @error('password_confirm')
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
            text: 'Apakah Anda yakin ingin mengubah sandi pengguna?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                // Submit the form when the user confirms
                document.getElementById('usersChange').submit();
            }
        });
    }
</script>
@endsection

