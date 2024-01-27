<?php

namespace App\Http\Controllers;

use App\Models\TransM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogM;

class DashboardC extends Controller
{
    public function dashboard()
{
    $LogM = LogM::create([
        'id_user' => Auth::user()-> id,
        'activity' => "User Di Halaman Dashboard"
    ]);
    $totalPenjualan = TransM::sum('total');

    return view('dashboard', ['totalPenjualan' => $totalPenjualan]);
}   
}
