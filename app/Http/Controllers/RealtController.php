<?php

namespace App\Http\Controllers;

use App\Houses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RealtController extends Controller
{
    public function index()
    {
        return view('houses/index');
    }

    public function search(Request $request)
    {
        $priceFrom = $request->input('priceFrom');
        $priceTo = $request->input('priceTo');
        $rooms = $request->input('roomsAmount');

        // Search for a houses
        if ($rooms === 'No reason') {
            $houses = DB::table('houses')
                ->whereBetween('price_per_day', [$priceFrom,$priceTo])
                ->get();
        } else {
            $houses = DB::table('houses')
                ->whereBetween('price_per_day', [$priceFrom,$priceTo])
                ->where('rooms', $rooms)
                ->get();
        }

        return response()->json($houses);
    }
}
