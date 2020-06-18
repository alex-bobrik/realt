<?php

namespace App\Http\Controllers;

use App\Houses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //

    public function index() {

        $house = new Houses();

        $house->title = '1';
        $house->description = '1';
        $house->image_link = '1';
        $house->updated = '1';
        $house->price_per_day = '1';
        $house->rooms = '1';
        $house->contacts = '1';

        $house->save();

        return view('home');
    }
}
