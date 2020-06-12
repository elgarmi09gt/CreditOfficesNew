<?php

namespace App\Http\Controllers\Macro;

use App\Http\Controllers\Controller;
use App\Models\Macros\MacroAgregat;
use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MacroAgregatController extends Controller
{
    public function index(Request $pays)
    {
        $dbs = getDB($pays);
        $exercices = DB::connection($dbs)->table('lignemacros')
            ->groupBy('exercice')
            ->get('exercice');
        $countries = Pays::on($dbs)->where('cedeao','=','ce')
            ->orderBy('id','desc')
            ->cursor();
        if($pays->segment(2) == 'agregat_df'):
            $view = view('forms.macro.agregat_df');
        else:
            $view = view('forms.macro.agregat');
        endif;
        $view->pays = $pays->pays;
        $view->countries = $countries;
        $view->exercices = $exercices;
        return $view;
    }

    public function store(Request $request)
    {
        $countries = collect();
        $uemoa = false;
        $inputs = $request->all();
        if ($request->get('exercice1') > $request->get('exercice2')) {
            $exercice1 = $request->get('exercice2');
            $exercice2 = $request->get('exercice1');
        } else {
            $exercice1 = $request->get('exercice1');
            $exercice2 = $request->get('exercice2');
        }
        $dbs = getDB($request);
        $macros = MacroAgregat::on($dbs)->where('macro','=',$request->get('agregat'))
            ->get();
        if (!$request->get('localite')):
            $localite = [];
        else:
            $localite = $request->get('localite');
            for ($i = 0; $i < count($localite); $i++):
                if ($localite[$i] == 240):
                    $uemoa = true;
                endif;
                $countries = $countries->concat( Pays::on($dbs)->where("id","=",$localite[$i])->cursor());
            endfor;
        endif;
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
        if($request->segment(2) == 'agregat_df'):
            $view = view('pages.macro.agregat_df');
            $view->pays = getPays($request->get('ref'));
        else:
            $view = view('pages.macro.agregat');
            $view->uemoa = $uemoa;
        endif;
        $view->input = $inputs;
        $view->request = $request;
        $view->macros = $macros;
        if ($countries):
            $view->countries = $countries;
        endif;
        $view->dbs = $dbs;
        $view->localite = $localite;
        $view->exercices = $exercices;
        return $view;
    }

    public function agregat_diff(Request $request){
        dd($request->all());
    }
}