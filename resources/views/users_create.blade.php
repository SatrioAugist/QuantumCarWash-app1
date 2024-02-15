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
            <h3 class="card-title">Tambah Data Pengguna</h3>
        </div>
        <div class="card-body">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
            <br><br>

            <form action="{{ route('users.store') }}" method="POST" id="usersForm">
                @csrf

                <div class="form-group">
                    <label>Username</label>
                    <input name="username" type="text" class="form-control" placeholder="..." required>
                    @error('username')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input name="nama" type="text" class="form-control" placeholder="..." required>
                    @error('nama')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input name="password" type="password" class="form-control" placeholder="..." required>
                    @error('password')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Ulangi Password</label>
                    <input name="password_confirm" type="password" class="form-control" placeholder="..." required>
                    @error('password_confirm')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option>-Pilih Role</option>
                        <option value="kasir">Kasir</option>
                        <option value="owner">Owner</option>
                        <option value="admin">Admin</option>
                    </select>
                    @error('role')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <button type="button" class="btn btn-success" style="margin-left: 3px;" onclick="confirmSubmit()">
                    <i class="mdi mdi-plus"> Tambah</i>
                </button>
            </form>
        </div>
        <!-- /.card-body -->
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function confirmSubmit() {
        Swal.fire({
            title: 'Konfirmasi Dulu!',
            text: 'Apakah Anda yakin ingin menambahkan data pengguna?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form when the user confirms
                document.getElementById('usersForm').submit();
            }
        });
    }
</script>


@endsection
