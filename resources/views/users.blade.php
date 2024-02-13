@extends('purple')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quantum Car Wash</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Pengguna</h4>
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        </div>
        <div class="card-body">
        <div id="success-message" class="alert alert-success" style="display: none;">
    <!-- Success message content -->
        </div>

            <a href="{{ route('users.create') }}" class="btn btn-outline-success"><i class="mdi mdi-plus"></i>Tambah</a>
            <a href="{{ route('users.pdf') }}" class="btn btn-outline-success"><i class="mdi mdi-download"></i>Laporan</a>
            <br>
            <br>

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="myTable">
                    <thead class="table-purple">
                        <tr>
                            <th style="text-align: center; vertical-align: middle;">No</th>
                            <th style="text-align: center; vertical-align: middle;">Nama Lengkap</th>
                            <th style="text-align: center; vertical-align: middle;">Username</th>
                            <th style="text-align: center; vertical-align: middle;">Role</th>
                            <th style="text-align: center; vertical-align: middle;">Aksi</th>
                        </tr>
                        <thead>
                        <tbody>
                            @foreach ($usersM as $key => $users)
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">{{ (int) $key + 1 }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $users->nama }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $users->username }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $users->role }}</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <div class="btn-group">
                                        <a title="Edit" href="{{ route('users.edit', $users->id)}}"
                                            class="btn btn-outline-warning btn-xs"
                                            style="border-radius: 10px; margin-right: 5px;">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                    <div class="btn-group">
                                        <a title="Ganti Sandi" href="{{ route('users.changepassword', $users->id)}}"
                                            class="btn btn-outline-info btn-xs"
                                            style="border-radius: 10px; margin-right: 5px;">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>

                                        <form action="{{ route('users.destroy', $users->id)}}" method="POST"
                                            title="Hapus" style="display: inline;">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-outline-danger btn-xs"
                                                style="border-radius: 10px; margin-left: 5px;"
                                                onclick="return confirm('Konfirmasi Hapus Data !?')">
                                                <i class="mdi mdi-delete-forever"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<style> 

    /* Warna latar belakang dan teks untuk header tabel */
    .table-purple th {
        background-color: #4A1CA6; /* Warna ungu */
        color: #ffffff; /* Warna teks putih */
    }

    /* Warna latar belakang dan teks untuk baris tabel ganjil */
    #myTable tbody tr:nth-child(odd) {
        background-color: #f2f2f2; /* Warna abu-abu muda */
        color: #000000; /* Warna teks hitam */
    }

    /* Warna latar belakang dan teks untuk baris tabel genap */
    #myTable tbody tr:nth-child(even) {
        background-color: #ffffff; /* Warna putih */
        color: #000000; /* Warna teks hitam */
    }
</style>
<script type="text/javascript">
    let table = new DataTable('#myTable');
</script>
@if($message = Session::get('success'))
    <script>
        // Display the success message
        $(document).ready(function(){
            $("#success-message").html("{{ $message }}").fadeIn(1).delay(3000).fadeOut(); // 3000 milliseconds (3 seconds)
            @if(Session::has('success'))
        {{ Session::forget('success') }}
    @endif
        });
    </script>
@endif
@endsection