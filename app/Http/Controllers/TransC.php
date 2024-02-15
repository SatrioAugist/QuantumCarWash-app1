<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogM;
use App\Models\PaketM;
use App\Models\TransM;
use Barryvdh\DomPDF\Facade\Pdf;



class TransC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $LogM = LogM::create([
            'id_user' => Auth::id(),
            'activity' => "User Di Halaman Transaksi"
        ]);
    
        $sub = "Daftar Transaksi Paket";
    
        $tM = TransM::all();    
        return view('transactions', compact('sub', 'tM'));
    }
    
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $LogM = LogM::create([
            'id_user' => Auth::id(),
            'activity' => "User Di Halaman Tambah Transaksi"
        ]);
        $sub = "Tambah Transaksi";
        $pM = PaketM::all();
        $tM = TransM::all();
        return view('transactions_create', compact('sub', 'pM','tM'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $LogM = LogM::create([
            'id_user' => Auth::id(),
            'activity' => "User Menambahkan Transaksi"
        ]);
        $paket = $request->input('paket');

        $request->validate([
            'nomor_unik' => 'required',
            'nomor_polisi' => 'required',
            'nama_pelanggan' => 'required',
            'id_produk' => 'required|array',
            'uang_bayar' => 'required',
            'total_harga' => 'required',
            'qty' => 'required|array',

        ]);
        $produkId = $request->input('produkId');
        $qty = $request->input('qty');
    
        TransM::create([
            'nomor_unik' => $request->input('nomor_unik'),
            'nomor_polisi' => $request->input('nomor_polisi'),
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'id_produk' => $this->prepareProduk($produkId, $qty),
            'total_harga' => $request->input('total_harga'),
            'uang_bayar' => $request->input('uang_bayar'),
            'uang_kembali' => $request->input('uang_bayar') - $request->input('total_harga'),
        ]);
     
        return redirect()->route('transactions.index')->with('success', 'Transaksi Berhasil Ditambahkan');
    }

    private function prepareProduk($produkIds, $qtys)
{
    $preparedProduk = [];

    foreach ($produkIds as $index => $paket) {
        // Check if the index exists in $qtys
        if (array_key_exists($index, $qtys)) {
            $qty = $qtys[$index];

            // Store a copy of the product information instead of fetching dynamically
            $productInfo = PaketM::find($paket);

            if ($productInfo) {
                $preparedProduk[] = [
                    'id' => $productInfo->id,
                    'paket' => $paket,
                    'nama_produk' => $productInfo->nama_produk,
                    'qty' => $qty,
                    'total_harga' => $qty * $productInfo->harga_produk,
                ];
            }
        } else {
            // Handle the case where $qtys is missing an index
            // You can log or throw an exception based on your application logic.
        }
    }

    return $preparedProduk;
}



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $LogM = LogM::create([
            'id_user' => Auth::id(),
            'activity' => "User Di Halaman Edit Transaksi"
        ]);
        $sub = "Edit Transaksi Produk";
        $tM = TransM::find($id);
        $pM = PaketM::all();

        // $tP = $tM->id_produk;

        // return response()->json($pM);

        return view('transactions_edit',
        compact('sub', 'pM' ,'tM'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $LogM = LogM::create([
        'id_user' => Auth::id(),
        'activity' => "User Mengedit Transaksi"
    ]);

    $request->validate([
        'nomor_unik' => 'required',
        'nomor_polisi' => 'required',
        'nama_pelanggan' => 'required',
        'id_produk' => 'required|array',
        'uang_bayar' => 'required',
        'total_harga' => 'required',
        'qty' => 'required|array',
    ]);

    $produkId = $request->input('id_produk'); // change 'produkId' to 'id_produk'
    $qty = $request->input('qty');

    $trans = TransM::find($id);
    $trans->nomor_unik = $request->input('nomor_unik');
    $trans->nomor_polisi = $request->input('nomor_polisi');
    $trans->nama_pelanggan = $request->input('nama_pelanggan');
    $trans->id_produk = $this->prepareProduk($produkId, $qty); // change 'produkId' to 'id_produk'
    $trans->total_harga = $request->input('total_harga');
    $trans->uang_bayar = $request->input('uang_bayar');
    $trans->uang_kembali = $request->input('uang_bayar') - $request->input('total_harga');
    $trans->save();

    return redirect()->route('transactions.index')->with('success', 'transaksi Berhasil Diperbarui');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $LogM = LogM::create([
            'id_user' => Auth::id(),
            'activity' => "User Menghapus Transaksi"
        ]);
        TransM::where('id', $id)->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi Berhasil Dihapus');
    }
    
    public function struk(String $id)
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Membuat PDF Transaksi'
        ]);

        $tM = TransM::find($id);
        $pdf = Pdf::loadView('transactions_struk', compact('tM'));
        return $pdf->stream();
}

    public function totalJual()
    {
        $totalPenjualan = TransM::sum('total');
    
        return view('transactions_pdf', ['totalPenjualan' => $totalPenjualan]);
    }
    public function pdf(Request $request)
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Membuat PDF Transaksi'
        ]);

        $tM = TransM::all();
        $pdf = Pdf::loadView('transactions_pdf', compact('tM'));
        return $pdf->stream();
}

    
    
public function pdfFilter(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    if (empty($startDate) && empty($endDate)) {
        $lastTransaction = TransM::orderBy('created_at', 'asc')->first();

        if ($lastTransaction) {
            $startDate = $lastTransaction->created_at->format('Y-m-d');
        } else {
            $startDate = now()->format('Y-m-d');
        }

        $endDate = now()->format('Y-m-d');
    }

    $tM = TransM::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->get();

    $totalPendapatan = $tM->sum('total_harga');

    $pdf = PDF::loadView('transactions_pdf', ['tM' => $tM, 'totalPendapatan' => $totalPendapatan]);

    if ($tM->isEmpty()) {
        $pdf->getDomPDF()->set_option("isHtml5ParserEnabled", true);
        $pdf->getDomPDF()->set_option("isPhpEnabled", true);
    }

    return $pdf->stream('transactions.pdf');
}


}

