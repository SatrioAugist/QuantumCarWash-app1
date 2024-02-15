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
        <h3 class="card-title">Tambah Data Transaksi</h3>
    </div>

    <div class="card-body">
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
        <br><br>

        <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
            @csrf

            <div class="form-group">
                <label for="">Kode Transaksi</label>
                <input name="nomor_unik" type="text" class="form-control"
                    value="{{ random_int(1000000000, 9999999999) }}" readonly>
                @error('nomor_unik')
                <p>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Nomor Polisi</label>
                <input name="nomor_polisi" type="text" class="form-control" placeholder="..." required>
                @error('nomor_polisi')
                <p>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Nama Pelanggan</label>
                <input name="nama_pelanggan" type="text" class="form-control" placeholder="..." required>
                @error('nama_pelanggan')
                <p>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">

                <label for="id_produk" class="form-label">Pilihan Paket</label>
                <div class="mb-3 d-flex">
                    <select name="id_produk[]" id="id_produk" class="form-control select2" required>
                        <option selected>-Pilih Paket-</option>
                        @foreach ($pM as $p)
                        <option value="{{ $p->id }}" data-harga="{{ $p->harga_produk }}">{{ $p->nama_produk }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-primary m-1" onclick="addRow()"><i
                            class="mdi mdi-plus"></i></button>
                </div>
                <div class="table-responsive ">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Paketan</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody"></tbody>
                    </table>
                </div>
            </div>

            <div class="form-group">
                <div class="form-group">
                    <label for="total_harga" class="form-label">Total Bayar</label>
                    <input type="number" class="form-control" id="total_harga" name="total_harga" readonly>

                </div>

                <label for="">Uang Bayar</label>
                <input name="uang_bayar" type="number" class="form-control" placeholder="..." required>
                @error('uang_bayar')
                <p>{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-success" style="margin-left: 3px;"
                onclick="confirmTransaction()">
                Tambah
            </button>
        </form>
    </div>
    <!-- /.card-body -->

</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function confirmTransaction() {
        Swal.fire({
            title: 'Konfirmasi Dulu!',
            text: 'Apakah Anda yakin ingin menambahkan transaksi?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Trigger the form submission
                $('#transactionForm').submit();
            }
        });
    }

    // Attach the confirmTransaction function to the button click event
    $(document).ready(function () {
        $('.btn-success').on('click', function (e) {
            e.preventDefault(); // Prevent the default form submission
            confirmTransaction(); // Call the custom confirmation function
        });
    });
</script>

    <script>
        $(document).ready(function () {
            // Get the select element and options
            var select = $('#products');
            var options = select.find('option');

            // Get the search input element
            var searchInput = $('#searchInput');

            // Add input event listener to the search input
            searchInput.on('input', function () {
                var searchQuery = $(this).val().toLowerCase();

                // Filter options based on the search query
                var filteredOptions = options.filter(function () {
                    var optionText = $(this).text().toLowerCase();
                    return optionText.indexOf(searchQuery) > -1;
                });

                // Update the select element with filtered options
                select.html(filteredOptions);
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: 'Pilih Produk',
                allowClear: true
            });
        });
    </script>
<script>
    function addRow() {
        var selectedProduk = $('#id_produk option:selected');
        var produkName = selectedProduk.text();
        var produkId = selectedProduk.val();
        var produkHarga = selectedProduk.data('harga');
        var qty = 1; // Set nilai default qty menjadi 1

        var total = produkHarga * qty;

        var newRow = `
            <tr>
                <td>${$('#tableBody tr').length + 1}</td>
                <td>${produkName}</td>
                <td>Rp. <span class="harga">${produkHarga}</span></td>
                <td>
                <input type="number" class="form-control form-control-sm qtyInput" name="qty[]" value="${qty}" min="1" data-harga="${produkHarga}">
                <input type="hidden" name="produkId[]" value="${produkId}">
                </td>

                <td class="totalRow">Rp. ${total}</td>
                <td><button type="button" class="btn btn-outline-danger m-1" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button></td>
            </tr>`;
        $('#tableBody').append(newRow);

        updateTotalHarga();
    }
</script>
<script>
    function removeRow(row) {
        $(row).closest('tr').remove();
        updateTotalHarga();
    }

    function updateTotalHarga() {
        var totalHarga = 0;

        $('#tableBody tr').each(function () {
            var qty = parseFloat($(this).find('.qtyInput').val());
            var harga = parseFloat($(this).find('.harga').text());
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
@endsection