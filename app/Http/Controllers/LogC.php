<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogM;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LogC extends Controller
{
    public function index()
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => "User Di Halaman Activity"
        ]);
        $subtitle = "Daftar Activity";
        $LogM = LogM::select('users.nama', 'users.role', 'log.*','log.created_at as jam')
            ->join('users', 'users.id', '=', 'log.id_user')
            ->orderBy('jam', 'desc') // Order by created_at in descending order
            ->get();

        return view('log', compact('subtitle', 'LogM'));
    }
    public function filter(Request $request)
    {
        $start_date = Carbon::parse($request->input('start_date'))->startOfDay();
        $end_date = Carbon::parse($request->input('end_date'))->endOfDay();
    
        $LogM = LogM::select('users.nama', 'users.role', 'log.*')
            ->join('users', 'users.id', '=', 'log.id_user')
            ->whereBetween('log.created_at', [$start_date, $end_date])
            ->orderBy('log.created_at', 'desc')
            ->get();
    
        return view('log', compact('LogM'));
    }
    
    public function show($id)
    {
        // LogC show logic
    }
}
