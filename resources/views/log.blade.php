@extends('purple')
@section('content')

<!-- Content Header (Page header) -->

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card-body">
        <h4 class="card-title">Aktivitas</h4>
        <br><br>
        <form action="{{ route('log.filter') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="start_date">Dari Tanggal</label>
                    <input type="date" class="form-control" name="start_date">
                </div>
                <div class="col-md-4">
                    <label for="end_date">Sampai Tanggal</label>
                    <input type="date" class="form-control" name="end_date">
                </div>
                <div class="col-md-4 mt-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <div class="card-body">
            @if($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
            @endif
            <div class="table-responsive"> 
                <table class="table table-striped table-bordered" id="myTable">
                    <thead class="table-purple">
                        <tr>
                            <th style="text-align: center; vertical-align: middle;">Nama User & Role</th>
                            <th style="text-align: center; vertical-align: middle;">Activity</th>
                            <th style="text-align: center; vertical-align: middle;">Tanggal & Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($LogM as $data)
                        <tr>
                            <td style="text-align: center; vertical-align: middle;">{{ $data->nama }},{{ $data->role }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $data->activity }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $data->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->

<style>
    /* Gaya khusus untuk warna border hitam */
    table {
        margin-top: 1rem;
    }

    th, td {
        text-align: center;
        vertical-align: middle;
        color: black; /* Tambahkan baris ini untuk mengubah warna teks */
    }

    th {
        background-color: #6f42c1; /* Warna latar header */
    }

    .btn-primary {
        background-color: #6f42c1; /* Warna latar tombol filter */
        border-color: #6f42c1;
    }

    .btn-primary:hover {
        background-color: #563d7c; /* Warna latar tombol filter saat dihover */
        border-color: #563d7c;
    }

    /* Gaya tambahan untuk responsivitas tabel */
    @media (max-width: 768px) {
        table {
            width: 100%;
        }
    }
    /* Warna latar belakang dan teks untuk header tabel */
    .table-purple th {
        background-color: #800080; /* Warna ungu */
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



@endsection
