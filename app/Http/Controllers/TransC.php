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
        $tM = TransM::select('transactions.*', 'products.*','transactions.created_at AS tanggal', 'transactions.id AS id_trans')->join('products', 'products.id', '=', 'transactions.id_produk')->get();
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
        $paket = PaketM::
        where("id", $request->input ('id_produk'))->first();
        $request->validate([
            'nomor_unik' => 'required',
            'nomor_polisi' => 'required',
            'nama_pelanggan' => 'required',
            'id_produk' => 'required',
            'qty' => 'required',
            'uang_bayar' => 'required',
        ]);


        $trans = new TransM;
        $trans->nomor_unik = $request->input('nomor_unik');
        $trans->nomor_polisi = $request->input('nomor_polisi');
        $trans->nama_pelanggan = $request->input('nama_pelanggan');
        $trans->id_produk = $request->input('id_produk');
        $trans->qty = $request->input('qty');
        $trans->total = 
        $paket->harga_produk * $request->input('qty');
        $trans->uang_bayar = $request->input('uang_bayar');
        $trans->uang_kembali = 
        $request->input('uang_bayar') - ($paket->harga_produk * $request->input('qty'));
        $trans->save();
        return redirect()->route('transactions.index')->with('success', 'Transaksi Berhasil Ditambahkan');
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
        $pM = PaketM::
        where("id", $request->input ('id_produk'))->first();
        $request->validate([
            'nomor_unik' => 'required',
            'nomor_polisi' => 'required',
            'nama_pelanggan' => 'required',
            'id_produk' => 'required',
            'qty' => 'required',
            'uang_bayar' => 'required',
        ]);

        
        $trans = TransM::find($id);
        $trans->nomor_unik = $request->input('nomor_unik');
        $trans->nomor_polisi = $request->input('nomor_polisi');
        $trans->nama_pelanggan = $request->input('nama_pelanggan');
        $trans->id_produk = $request->input('id_produk');
        $trans->qty = $request->input('qty');
        $trans->uang_bayar = $request->input('uang_bayar');
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
        return redirect()->route('transactions.index')->with('success', 'berhasil dihapus');
    }

    public function struk($id){ 
        $LogM = LogM::create([ 
            'id_user' => Auth::user()->id, 
            'activity' => 'User Mencetak Struk Transaksi' 
        ]); 
        
        $tM = TransM::select('products.*','transactions.*', 'transactions.id AS id_trans')
        ->join('products', 'products.id', '=', 'transactions.id_produk')->where('transactions.id', $id)->get();
        $pdf = PDF::loadview('transactions_struk',['tM' => $tM]);
        return $pdf->stream('transactions.struk');
    }

    public function totalJual()
    {
        $totalPenjualan = TransM::sum('total');
    
        return view('transactions_pdf', ['totalPenjualan' => $totalPenjualan]);
    }
    public function pdf(){ 
        $LogM = LogM::create([ 
            'id_user' => Auth::user()->id, 
            'activity' => 'User Mencetak Laporan Transaksi' 
        ]); 
        
        $tM = TransM::select('products.*','transactions.*', 'transactions.id AS id_trans')
        ->join('products', 'products.id', '=', 'transactions.id_produk')->get();
        $pdf = PDF::loadview('transactions_pdf',['tM' => $tM]);
        return $pdf->stream('transactions.pdf');
    }
    
    public function pdfFilter(Request $request) 
    { 
        $LogM = LogM::create([ 
            'id_user' => Auth::user()->id, 
            'activity' => 'User Membuat PDF Transaksi' 
        ]); 
 
        // Ambil tanggal awal dan akhir dari request 
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date'); 
 
        // Jika kedua tanggal kosong, atur tanggal dari transaksi terakhir dan terbaru 
        if (empty($startDate) && empty($endDate)) { 
            $lastTransaction = TransM::orderBy('created_at', 'asc')->first(); 
 
            // Periksa apakah ada data transaksi 
            if ($lastTransaction) { 
                $startDate = $lastTransaction->created_at->format('Y-m-d'); 
            } else { 
                // Atur tanggal default jika tidak ada transaksi 
                $startDate = now()->format('Y-m-d'); 
            } 
 
            $endDate = now()->format('Y-m-d'); 
        } 
 
        // Query untuk mengambil data transaksi berdasarkan rentang tanggal 
        $tM = TransM::select('transactions.*', 'products.nama_produk', 'products.harga_produk', 'transactions.id AS id_trans') 
            ->join('products', 'products.id', '=', 'transactions.id_produk') 
            ->whereBetween('transactions.created_at', [$startDate, $endDate . ' 23:59:59']) 
            ->get(); 
 
        // Load view dan buat PDF 
        $pdf = PDF::loadview('transactions_pdf', ['tM' => $tM]); 
 
        // Jika tidak ada data dalam rentang tanggal, set PDF ke mode tolerant 
        if ($tM->isEmpty()) { 
            $pdf->getDomPDF()->set_option("isHtml5ParserEnabled", true); 
            $pdf->getDomPDF()->set_option("isPhpEnabled", true); 
        } 
 
        // Kembalikan response PDF 
        return $pdf->stream('transactions.pdfFilter'); 
    }
}

