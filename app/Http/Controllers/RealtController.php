<?php

namespace App\Http\Controllers;

use App\Houses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RealtController extends Controller
{

    public function index()
    {
        $houses = DB::table('houses')->paginate(5);

        return view('houses/index', [
            'houses' => $houses,
        ]);
    }

    public function search(Request $request)
    {
        // Search for a houses

        $priceFrom = $request->input('priceFrom');
        $priceTo = $request->input('priceTo');
        $rooms = $request->input('roomsAmount');

        if ($rooms === 'All') {
            $houses = DB::table('houses')
                ->whereBetween('price_per_day', [$priceFrom,$priceTo])
                ->get();
        } else {
            $houses = DB::table('houses')
                ->whereBetween('price_per_day', [$priceFrom,$priceTo])
                ->where('rooms', $rooms)
                ->get();
        }


//        $houses = DB::table('houses')
//            ->whereBetween('price_per_day', [$priceFrom,$priceTo])
//            ->where('rooms', $rooms)
//            ->get();

        return view('houses/index', [
            'houses' => $houses,
            'from' => $priceFrom,
            'to' => $priceTo,
            'rooms' => $rooms,
        ]);
    }
}
