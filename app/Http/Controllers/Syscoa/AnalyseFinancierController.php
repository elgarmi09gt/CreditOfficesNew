<?php

namespace App\Http\Controllers\Syscoa;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AnalyseFinancierController extends Controller
{
    function index(Request $pays)
    {
        $dbs = getDB($pays);
        $lignebilans = DB::connection($dbs)->table('lignebilans')
            ->join('entreprises','entreprises.id','=','idEntreprise')
            ->where('type', '!=', 'B')
            ->where('exercice', '<=', 2017)
            ->groupBy('exercice')
            ->get('exercice');
        $lignebilansNew = DB::connection($dbs)->table('lignebilans')
            ->join('entreprises','entreprises.id','=','idEntreprise')
            ->where('type', '!=', 'B')
            ->where('exercice', '>=', 2017)
            ->groupBy('exercice')->get('exercice');
        return view('forms.syscoa.bilan')
            ->with('pays', $pays->pays)
            ->with('lignebilans', $lignebilans)
            ->with('lignebilansNew', $lignebilansNew);
    }

    function index_bilan_post(Request $request)
    {
        $dbs = getDB($request);
        $lignebilans = DB::connection($dbs)->table('lignebilans')->groupBy('exercice')->get('exercice');
        $view = view('forms.syscoa.poste_bilan');
        $view->pays = $request['pays'];
        $view->lignebilans = $lignebilans;
        return $view;
    }

    function index_bilan_diff(Request $request)
    {
        $dbs = getDB($request);
        $lignebilans = DB::connection($dbs)
            ->table('lignebilans')
            ->where('exercice', '<=', 2017)
            ->groupBy('exercice')
            ->get('exercice');
        $lignebilansNew = DB::connection($dbs)
            ->table('lignebilans')
            ->where('exercice', '>=', 2017)
            ->groupBy('exercice')
            ->get('exercice');

        return view('forms.syscoa.diff_bilan')
            ->with('pays', $request['pays'])
            ->with('lignebilans', $lignebilans)
            ->with('lignebilansNew', $lignebilansNew);
    }




}
