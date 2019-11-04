<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\GisMap;

class MapController extends Controller
{
    //

        function index(){
            return view("map");
        }     

        function add(Request $request){
            $this->insert_data($request);
            return redirect()->route('gempa');
        }

        // method untuk edit data gempa
        public function edit(Request $request)
        {
            $mytime = Carbon::now();
            // mengambil data gempa berdasarkan id yang dipilih
            $gempa = DB::table('gis_maps')->where('id',$request->id)->update([
                'Lintang' => $request->Lintang,
                'Bujur' => $request->Bujur,
                'Kedalaman' => $request->Kedalaman,
                'Magnitude' => $request->Magnitude,
                'Audio_Link' => $request->Audio_Link,
                'Video_Link' => $request->Video_Link,
                'updated_at' => $mytime->toDateTimeString()
            ]);
            // passing data gempa yang didapat ke view edit.blade.php
            return redirect()->route('gempa');
        }

        public function delete(Request $request)
        {   
            if($request->id!=null){
                $gempa = DB::table('gis_maps')->where('id',$request->id)->delete();

                return redirect()->route('gempa');
            }
            else{
                foreach($request->input('options') as $o){
                    $gempa = DB::table('gis_maps')->where('id',$o)->delete();
                }
                return redirect()->route('gempa');
            }
        }

        public function getGempa(){
            $gempa = GisMap::select(['id', 'Lintang as lat', 'Bujur as lng', 'Kedalaman', 'Magnitude', 'Audio_Link', 'Video_Link'])->get();

            return response()
                ->json($gempa);
        }

        private function insert_data($request){
                    // insert data ke table 
            $mytime = Carbon::now();
            
            DB::table('gis_maps')->insert([
                'Lintang' => $request->Lintang,
                'Bujur' => $request->Bujur,
                'Kedalaman' => $request->Kedalaman,
                'Magnitude' => $request->Magnitude,
                'Audio_Link' => $request->Audio_Link,
                'Video_Link' => $request->Video_Link,
                'created_at' => $mytime->toDateTimeString()
            ]);
        }

}
