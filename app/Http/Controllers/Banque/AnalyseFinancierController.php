<?php

namespace App\Http\Controllers\Banque;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\LigneBilan;

class AnalyseFinancierController extends Controller
{
    function index(Request $pays)
        {
            $dbs = getDB($pays);
            $lignebilans = DB::connection($dbs)->table('lignebilans')
                ->join('entreprises','entreprises.id','=','idEntreprise')
                ->where('type', '=', 'B')
                ->where('exercice', '<=', 2017)
                ->groupBy('exercice')
                ->get('exercice');
            $lignebilansNew = DB::connection($dbs)->table('lignebilans')
                ->join('entreprises','entreprises.id','=','idEntreprise')
                ->where('type', '=', 'B')
                ->where('exercice', '>=', 2017)
                ->groupBy('exercice')->get('exercice');
            return view('forms.banques.bilan')
                ->with('pays', $pays->pays)
                ->with('lignebilans', $lignebilans)
                ->with('lignebilansNew', $lignebilansNew);
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

            return view('forms.banques.diff_bilan')
                ->with('pays', $request['pays'])
                ->with('lignebilans', $lignebilans)
                ->with('lignebilansNew', $lignebilansNew);
        }

    function index_bilan_post(Request $request)
    {
        $dbs = getDB($request);
        $lignebilans = DB::connection($dbs)->table('lignebilans')->groupBy('exercice')->get('exercice');
        // $natures = DB::connection($dbs)->table('classes')->groupBy('nature')->get('nature');
        // $postes = DB::connection($dbs)->table('rubriques')->get(['nomRubrique', 'idRubrique']);
        $view = view('forms.banques.poste_bilan');
        $view->pays = $request['pays'];
        $view->lignebilans = $lignebilans;
        // $view->natures = $natures;
        // $view->postes = $postes;
        return $view;
    }

}