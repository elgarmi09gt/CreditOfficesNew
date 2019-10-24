<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HController extends Controller
{
    function index(Request $request){
        if (!$request->pays)
            $pays = 201;
        else
            $pays = $request->pays;
        return view('welcome',['pays'=>$pays]);
    }
}
