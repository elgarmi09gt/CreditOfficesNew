<?php

namespace App\Http\Controllers\Secteur;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Secteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyseFinancierController extends Controller
{
    function index(Request $pays)
    {
        $dbs = getDB($pays);
        $lignebilans = DB::connection($dbs)->table('lignebilans')
            ->where('exercice', '<=', 2017)
            ->groupBy('exercice')
            ->get('exercice');
        $lignebilansNew = DB::connection($dbs)->table('lignebilans')
            ->where('exercice', '>=', 2017)
            ->groupBy('exercice')->get('exercice');
        return view('forms.secteurs.bilan')
            ->with('pays', $pays->pays)
            ->with('lignebilans', $lignebilans)
            ->with('lignebilansNew', $lignebilansNew);
    }

    public function bilan(Request $request)
    {
        // Analyse période and type
        $typeClasse = $request->get('annee');
        if ($typeClasse == 'new') {
            $exercice1 = $request->get('exercice1');
            $exercice2 = $request->get('exercice2');
        } else {
            $exercice1 = $request->get('exercice3');
            $exercice2 = $request->get('exercice4');
        }
        // Normalise years
        if ($exercice1 > $exercice2) {
            $exo = $exercice1;
            $exercice1 = $exercice2;
            $exercice2 = $exo;
        }
        $exercice01 = $exercice1;
        $exercice02 = $exercice2;
        $dbs = getDB($request);
        // if not specific sector : choose all sectors
        if ($request->get('idSecteur') == "SECTEURS OHADA") {
            $secteurs = Secteur::on($dbs)->cursor()->whereNotIn('id', [11, 22, 23])->all();
            $systemClasse = "sh";
        } elseif ($request->get('idSecteur') == "AUTRES QUE OHADA") {
            $secteurs = Secteur::on($dbs)->cursor()->where('id', "=", 11)->all();
            $systemClasse = "sb";
        } else {
            $secteurs = Secteur::on($dbs)->where('secteur', htmlentities($request->get('idSecteur')))
                ->get();
            foreach ($secteurs as $secteur):
                if ($secteur->id != 11):
                    $systemClasse = "sh";
                else:
                    $systemClasse = "sb";
                endif;
            endforeach;
        }
        $classes = Classe::on($dbs)->where('nature', '=', $request->get('document'))
            ->where('typeClasse', $typeClasse)
            ->where('systemeClasse', $systemClasse)
            ->get();
        if ($request->get('naturep') == 'paran'):
            $exercices = DB::connection($dbs)->table('lignebilans')
                ->where('exercice', '>=', $exercice01)
                ->where('exercice', '<=', $exercice02)
                ->groupBy('exercice')
                ->get('exercice');
        else:
            $exercices = DB::connection($dbs)->table('lignebilans')
                ->where('exercice', '=', $exercice01)
                ->orwhere('exercice', '=', $exercice02)
                ->groupBy('exercice')
                ->get('exercice');
        endif;
        $view = view('pages.secteurs.bilan');
        if ($classes != ''): $view->classes = $classes; endif;
        $view->secteurs = $secteurs;
        $view->exercices = $exercices;
        $view->request = $request;
        $view->dbs = $dbs;
        return $view;
    }
}
