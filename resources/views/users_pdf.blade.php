<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengguna</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 15px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1,
        h2,
        p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody td {
            text-align: center;
        }

        .summary {
            margin-top: 18px;
        }

        .footer {
            margin-top: 25px;
            text-align: right;
        }

        .hp {
            text-align: left;
        }

        .signature {
            margin-top: 70px;
            text-align: right;
        }
        
    </style>
</head>

<body>
    <header>
        <h1>Laporan Pengguna</h1>
        <div class="hp">
            <p>Tanggal:  {{ date('d-m-Y') }}</p>
        </div>
    </header>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
           
            @foreach ($users as $key => $users)
                <tr>
                    <td>{{ (int) $key + 1 }}</td>
                    <td>{{ $users->nama }}</td>
                    <td>{{ $users->username }}</td>
                    <td>{{ $users->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h2>Ringkasan</h2>
        <p>Jumlah Pengguna: {{ \App\Models\User::count() }}</p>
    </div>

    <div class="footer">
        <p>Terima kasih atas kerjasamanya.</p>
    </div>

    <div class="signature">
        <p>___________________________</p>
    </div>
</body>

</html>
