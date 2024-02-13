@extends('purple')
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Quantum car Wash</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Edit Data Transaksi</h3>
  </div>

  <div class="card-body">
    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
    <br><br>

    <form action="{{ route('transactions.update', $tM->id) }}" method="POST">
      @csrf
      @method('put')

      <div class="form-group">
        <label for="">Kode Transaksi</label>
        <input name="nomor_unik" type="text" class="form-control" value="{{ $tM->nomor_unik }}" readonly>
        @error('nomor_unik')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label for="">Nomor Polisi</label>
        <input name="nomor_polisi" type="text" class="form-control" value="{{ $tM->nomor_polisi }}" required>
        @error('nomor_polisi')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label for="">Nama Pelanggan</label>
        <input name="nama_pelanggan" type="text" class="form-control" value="{{ $tM->nama_pelanggan }}" required>
        @error('nama_pelanggan')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <!-- Pilihan produk -->
      <label for="id_produk" class="form-label">Nama Produk</label>
      <div class="mb-3 d-flex">
        <select name="id_produk[]" required id="id_produk" class="form-control">
          <option selected>Pilih Produk</option>
          @foreach ($pM as $p)
            @php
              $selectedProdukId = !is_null($tM) && !is_null($tM->produk) && in_array($p->id, array_column($tM->produk, 'produkId')) ? 'selected' : '';
            @endphp
            <option value="{{ $p->id }}" data-harga="{{ $p->harga_produk }}" {{ $selectedProdukId }}>{{ $p->nama_produk }}</option>
          @endforeach
        </select>
        <input type="hidden" id="selectedProdukId" name="selectedProdukId" value="">
        <button type="button" class="btn btn-outline-primary m-1" onclick="addRow()"><i class="mdi mdi-plus"></i></button>
      </div>

      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Produk</th>
              <th scope="col">Harga Produk</th>
              <th scope="col">Qty</th>
              <th scope="col">Total</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody id="tableBody">
            @if (!is_null($tM->id_produk) && is_array($tM->id_produk))
              @foreach ($tM->id_produk as $existingProduk)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $existingProduk['nama_produk'] }}</td>
                  <td>Rp. <span class="harga" data-harga="{{ $existingProduk['total_harga'] }}">{{ $existingProduk['total_harga'] }}</span></td>
                  <td>
                    <input type="number" class="form-control qtyInput" name="qty[]" value="{{ $existingProduk['qty'] }}" min="1">
                    <input type="hidden" name="id_produk[]" value="{{ $existingProduk['id'] }}">
                  </td>
                  <td class="totalRow">Rp. {{ $existingProduk['total_harga'] }}</td>
                  <td><button type="button" class="btn btn-outline-danger m-1" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button></td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>

      <div class="form-group">
        <div class="form-group">
          <label for="total_harga" class="form-label">Total Bayar</label>
          <input type="number" class="form-control" id="total_harga" name="total_harga" value="{{ $tM->total_harga }}" readonly>
        </div>

        <label for="">Uang Bayar</label>
        <input name="uang_bayar" type="number" class="form-control" value="{{ $tM->uang_bayar }}" required>
        @error('uang_bayar')
          <p>{{ $message }}</p>
        @enderror
      </div>

      <button type="submit" class="btn btn-warning" style="margin-left: 3px;" onclick="return confirm('Konfirmasi Edit Transaksi !?')">
        Simpan
      </button>
    </form>
  </div>
  <!-- /.card-body -->
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable();

        // Calculate and display the total sum
        var totalHarga = 0;
        var totalTransaksi = 0;

        $('tbody tr').each(function () {
            var harga = parseFloat($(this).find('td:eq(6)').text().replace('Rp. ', '').replace(',', '')) || 0; // Assuming 'total_harga' is in the 7th column
            var transaksi = 1; // Assuming each row is a transaction

            totalHarga += harga;
            totalTransaksi += transaksi;
        });

        $('#total-harga').text('Rp. ' + totalHarga.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('#total-transaksi').text(totalTransaksi);
    });
</script>


<script>
    
    function addRow() {
        var selectedProduk = $('#id_produk option:selected');
        var produkName = selectedProduk.text();
        var produkId = selectedProduk.val();
        var produkHarga = selectedProduk.data('harga');
        var qty = $('#qty').val();
        var existingProduk = $('#tableBody tr').find('input[value="' + produkId + '"]').length > 0;

        if (!existingProduk) {
            var total = produkHarga * qty;

            var newRow = `
            <tr>
                <td>${$('#tableBody tr').length + 1}</td>
                <td>${produkName}</td>
                <td>Rp. <span class="harga" data-harga="${produkHarga}">${produkHarga}</span></td>
                <td>
                    <input type="number" class="form-control qtyInput" name="qty[]" value="${qty}" min="1">
                    <input type="hidden" name="produkId[]" value="${produkId}">
                </td>
                <td class="totalRow">Rp. ${total}</td>
                <td><button type="button" class="btn btn-outline-danger m-1" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button></td>
            </tr>
            `;

            $('#tableBody').append(newRow);
            updateTotalHarga();
        } else {
            alert('Produk sudah ditambahkan sebelumnya. Untuk mengedit, gunakan fitur edit.');
        }

        // Clear input fields after adding a row
        $('#qty').val('');
        $('#selectedProdukId').val('');
    }

    function removeRow(row) {
        $(row).parent().parent().remove();
        updateTotalHarga();
    }

    function updateTotalHarga() {
        var totalHarga = 0;

        $('#tableBody tr').each(function () {
            var qty = parseFloat($(this).find('.qtyInput').val());
            var harga = parseFloat($(this).find('.harga').data('harga'));
            var totalRow = qty * harga;

            $(this).find('.totalRow').text('Rp. ' + totalRow);
            totalHarga += totalRow;
        });

        $('#total_harga').val(totalHarga);
    }

    $(document).on('input', '.qtyInput', function () {
        updateTotalHarga();
    });

</script>

<!-- /.card -->
<!-- /.content -->
@endsection
