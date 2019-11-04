<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\GisMap;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $gempa = DB::table('gis_maps')->paginate(10);

        // mengirim data gempa ke view index
        return view('gempa',['gempa' => $gempa]);
    }

    public function add(){
        return view('addGempa');
    }


}
