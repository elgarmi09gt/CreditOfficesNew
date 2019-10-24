<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatioController extends Controller
{
    function index_ratio(Request $pays){
        $dbs = getDB($pays);
        $lignebilans = DB::connection($dbs)->table('lignebilan')->groupBy('exercice')->get('exercice');
        $ratios = DB::connection($dbs)->table('ratio')->get(['idRatio','nomRatio']);
        return view('forms.ratios.ratio_form')
            ->with('pays', $pays['pays'])
            ->with('lignebilans', $lignebilans)
            ->with('ratios', $ratios);
    }
    function ratio(Request $request){
        $totalNatureA = $totalNatureAPays = $totalNatureAUEMOA =
        $entreprises = $collectPays = $collectUEMOA = collect();
        $input = $request->all();
        if ($request->get('exercice1') > $request->get('exercice2')){
            $exercice1 = $request->get('exercice2');
            $exercice2 = $request->get('exercice1');
        }else
        {
            $exercice1 = $request->get('exercice1');
            $exercice2 = $request->get('exercice2');
        }

        $dbs = getDB($request);
        $con = 'sensyyg2_umeoabd';
        if ($request->get('naturep') == 'paran'):
            for ($i = $exercice1; $i <= $exercice2; $i++):
                $YEARS [] = $i;
            endfor;
        else:
            $YEARS [] = $exercice1;
            $YEARS [] = $exercice2;
        endif;
        if ($request->localite == 'pays'):
            $pays = DB::connection($dbs)->table('pays')->where('idPays',$request->pays)->get(['idPays','nomPays','bdPays']);
        else:
            $pays = DB::connection($con)->table('pays')
                ->where('cedeao','ce')
                ->get(['idPays','nomPays','bdPays']);
        endif;
        foreach ($pays as $pay):
            $entreprise = DB::connection($pay->bdPays)->table('entreprises')
                ->selectRaw($pay->idPays . ' as idPays ,entreprises.idEntreprise,nomEntreprise,Sigle')
                ->join('lignebilan', 'entreprises.idEntreprise', '=', 'lignebilan.identreprise')
                ->distinct()
                ->whereIn('exercice', $YEARS)
                ->where('type','B')
                ->get();
            $entreprises = $entreprises->concat($entreprise);
        endforeach;
        if ($request->get('naturep') == 'paran'):
            $exercices = DB::connection($dbs)->table('lignebilan')
                ->where('exercice','>=',$exercice1)
                ->where('exercice','<=',$exercice2)
                ->groupBy('exercice')
                ->get('exercice');
        else:
            $exercices = DB::connection($dbs)->table('lignebilan')
                ->where('exercice','=',$exercice1)
                ->orwhere('exercice','=',$exercice2)
                ->groupBy('exercice')
                ->get('exercice');
        endif;
        if ($request->ratio == "COEFFICIENT DE RENTABILITE")
            $view = view('pages.ratios.roe');
        elseif ($request->ratio == 'RENTABILITÉ DES ACTIFS')
            $view = view('pages.ratios.roa');
        elseif ($request->ratio == 'FONDS PROPRES')
            $view = view('pages.ratios.fp');
        elseif($request->ratio == 'COÛT DES COMPTES CRÉDITEURS')
            $view = view('pages.ratios.ccc');
        elseif($request->ratio == 'COÛT DES COMPTES RÉNUMÉRÉS')
            $view = view('pages.ratios.ccr');
        elseif($request->ratio == 'Ratio 1')
            $view = view('pages.ratios.cc');
        
        else
           return $view = view('pages.ratios.404');
        $view->entreprises = $entreprises;
        $view->exercices = $exercices;
        $view->input = $input;
        $view->Countries = $pays;
        return $view;
    }

}
