<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LogM;
use Barryvdh\DomPDF\Facade\Pdf;


class UsersR extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()-> id,
            'activity' => "User Di Halaman Pengguna"
        ]);
        $subtitle = "Daftar Pegguna";
        $usersM = User::all();
        return view('users', compact('subtitle', 'usersM'));
    }

    public function pdf()
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()-> id,
            'activity' => "User Mencetak Laporan Pengguna"
        ]);
        $users = User::all();
        $pdf = PDF::loadView('users_pdf', compact('users')); // Correcting the loadview method
        return $pdf->stream('users.pdf');
    }
    public function error()
    {
        $subtitle = "Error";
        return view('error', compact('subtitle'));
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
            'activity' => "User Di Halaman Tambah Pengguna"
        ]);
        $subtitle = "Tambah Data Pengguna";
        return view('users_create', compact('subtitle'));
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
            'activity' => "User Menambahkan Pengguna"
        ]);
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
            'role' => 'required',
        ]);

        $user = new User([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna Berhasil Ditambahkan');
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
            'activity' => "User Di Halaman Edit Pengguna"
        ]);
        $subtitle = "Edit Data Pengguna";
        $data = User::find($id);
        return view('users_edit', compact('subtitle', 'data'));
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
            'activity' => "User Mengedit Pengguna"
        ]);
        $request->validate([
            'nama' => 'required',
            'role' => 'required',
        ]);

        $data = request()->except(['_token', '_method', 'submit']);

        User::where('id', $id)->update($data);
        return redirect()->route('users.index')->with('success', 'Data Pengguna berhasil diperbaharui');
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
            'activity' => "User Menghapus Pengguna"
        ]);
        User::where('id', $id)->delete();
        return redirect()->route('users.index')->
            with('success', 'Pengguna Berhasil Dihapus');
    }

    public function changepassword($id)
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()-> id,
            'activity' => "User Di Halaman Ganti Password Pengguna"
        ]);
        $subtitle = "Edit Kata Sandi Pengguna";
        $users = User::find($id);
        return view('users_changepassword', compact('subtitle', 'users'));
    }

    public function change(Request $request, $id)
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()-> id,
            'activity' => "User Merubah Password Pengguna"
        ]);
        $request->validate([
            'password_new' => 'required',
            'password_confirm' => 'required|same:password_new',
        ]);
        $users = User::where("id", $id)->first();
        $users->update([
            'password' => Hash::make($request->password_new),
        ]);
        return redirect()->route('users.index')
            ->with('success', 'Kata Sandi berhasil diperbaharui !');
    }

 

}

