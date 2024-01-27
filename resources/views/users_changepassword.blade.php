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
        <h3 class="card-title">Ganti Kata Sandi Pengguna</h3>
      </div>
      <div class="card-body">
      <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
    <br><br>
      <form action="{{ route('users.change', $users->id) }}" method="POST">
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

        <input type="submit" name="submit" class="btn btn-success" value="Simpan" onclick="return confirm('Konfirmasi Edit Kata Sandi Pengguna !?')">
      </form>
    </div>
      <!-- /.card-body -->
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
@endsection
