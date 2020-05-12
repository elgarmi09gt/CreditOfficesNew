<?php

namespace App\Http\Controllers\Macro;

use App\Http\Controllers\Controller;
use App\Models\Macros\Lignemacro;
use App\Models\Macros\SecteurMacro;
use App\Models\Macros\SoussecteurMacro;
use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MacroAgregatController extends Controller
{
    public function index(Request $pays)
    {
        $dbs = getDB($pays);
        $secteurs = SecteurMacro::on($dbs)->where("id", "!=", 5)->cursor();
        $soussecteur_sr = SoussecteurMacro::on($dbs)->where("idSecteur", "=", 1)->cursor();
        $soussecteur_smf = SoussecteurMacro::on($dbs)->where("idSecteur", "=", 2)->cursor();
        $soussecteur_sfp = SoussecteurMacro::on($dbs)->where("idSecteur", "=", 3)->cursor();
        $soussecteur_se = SoussecteurMacro::on($dbs)->where("idSecteur", "=", 4)->cursor();
        $soussecteur_ss = SoussecteurMacro::on($dbs)->where("idSecteur", "=", 6)->cursor();
//        $exercices = Lignemacro::on($dbs)->groupBy("exercice")->distinct()->cursor();
        $exercices = DB::connection($dbs)->table('lignemacros')
            ->groupBy('exercice')
            ->get('exercice');
        $view = view('forms.macro.agregat');
        $view->pays = $pays->pays;
        $view->exercices = $exercices;
        $view->ss_sr = $soussecteur_sr;
        $view->ss_smf = $soussecteur_smf;
        $view->ss_sfp = $soussecteur_sfp;
        $view->ss_se = $soussecteur_se;
        $view->ss_ss = $soussecteur_ss;
        $view->secteurs = $secteurs;
        return $view;
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        if ($request->get('exercice1') > $request->get('exercice2')) {
            $exercice1 = $request->get('exercice2');
            $exercice2 = $request->get('exercice1');
        } else {
            $exercice1 = $request->get('exercice1');
            $exercice2 = $request->get('exercice2');
        }

        $dbs = getDB($request);
        if ($request->get('naturep') == 'paran'):
            $exercices = DB::connection($dbs)->table('lignemacros')
                ->where('exercice', '>=', $exercice1)
                ->where('exercice', '<=', $exercice2)
                ->groupBy('exercice')
                ->get('exercice');
        else:
            $exercices = DB::connection($dbs)->table('lignemacros')
                ->where('exercice', '=', $exercice1)
                ->orwhere('exercice', '=', $exercice2)
                ->groupBy('exercice')
                ->get('exercice');
        endif;
        if ($request->get('localite') == 'uemoa'):
            $pays = Pays::on($dbs)->where("cedeao","=","ce")->cursor();
        else:
            $pays = Pays::on($dbs)->where("id","=",$request->get('pays'))->cursor();
        endif;
        $soussecteurs = DB::connection($dbs)
            ->table('soussecteur_macros')
            ->join('secteur_macros', "idSecteur", "=", "secteur_macros.id")
            ->where("codeSecteur", "=", $request->get('secteur'))
            ->where("codeSouSecteur", "=", $request->get('soussecteur'))
            ->get(['soussecteur_macros.id','idSecteur','codeSouSecteur','codeSecteur']);
        $view = view('pages.macro.agregat');
        $view->input = $inputs;
        $view->request = $request;
        $view->soussecteurs = $soussecteurs;
        $view->pays = $pays;
        $view->dbs = $dbs;
        $view->exercices = $exercices;
        return $view;
    }
}
