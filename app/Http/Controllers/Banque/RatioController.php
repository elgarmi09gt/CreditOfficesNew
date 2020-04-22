<?php

namespace App\Http\Controllers\Banque;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RatioController extends Controller
{
    function index(Request $pays)
    {
        $dbs = getDB($pays);
        $lignebilans = DB::connection($dbs)->table('lignebilan')->groupBy('exercice')->get('exercice');
        $ratios = DB::connection($dbs)->table('ratio')->get(['idRatio', 'nomRatio']);
        return view('forms.ratios.ratio_form')
            ->with('pays', $pays['pays'])
            ->with('lignebilans', $lignebilans)
            ->with('ratios', $ratios);
    }

}
