<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketM;
use Illuminate\Support\Facades\Auth;
use App\Models\LogM;
use Barryvdh\DomPDF\Facade\Pdf;


class PaketC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => "User Di Halaman Paket"
        ]);
    
        $sub = "Daftar Paket";
    
        $pM = PaketM::orderBy('created_at', 'asc')->get();
    
        return view('paket', compact('pM', 'sub'));
    }
    
    
    public function pdf()
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()-> id,
            'activity' => "User Mencetak Laporan Paket"
        ]);
        $pM = PaketM::all();
        $pdf = PDF::loadview('paket_pdf',['pM' => $pM]);
        return $pdf->stream('paket.pdf');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()-> id,
            'activity' => "User Di Halaman Edit Paket"
        ]);
        $sub = "Tambah Produk";
        return view('paket_create', compact('sub'));
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
            'id_user' => Auth::user()-> id,
            'activity' => "User Menambahkan Paket"
        ]);
        $request->validate([
            'nama_produk' => 'required',
            'harga_produk' => 'required',
        ]);
        PaketM::create($request->post());
        return redirect()->route('paket.index')->with('success', 'Paket berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'id_user' => Auth::user()-> id,
            'activity' => "User Di Halaman Edit Paket"
        ]);
        $sub ="Edit Paket";
        $pM = PaketM::find($id);

        return view('paket_edit',compact('sub','pM'));
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
            'id_user' => Auth::user()-> id,
            'activity' => "User Mengedit Paket"
        ]);
        $request->validate([
            'nama_produk' => 'required',
            'harga_produk' => 'required',
        ]);
   
        $data = request()->except(['_token', '_method', 'submit']);
   
        PaketM::where('id', $id)->update($data);
        return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbaharui');
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
            'id_user' => Auth::user()-> id,
            'activity' => "User Menghapus Paket"
        ]);
        \DB::table('transactions')->where('id_produk', $id)->delete();
        PaketM::where('id', $id)->delete();
        return redirect()->route('paket.index')->with('success', 'Paket Berhasil Dihapus');
    }
}
