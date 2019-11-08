<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


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
    function index_ratios_res(Request $pays){
        $dbs = getDB($pays);
        $lignebilans = DB::connection($dbs)->table('lignebilan')->groupBy('exercice')->get('exercice');
        return view('forms.ratios.ratiosResForm')
            ->with('pays', $pays['pays'])
            ->with('lignebilans', $lignebilans);
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
                ->join('lignebilan', 'entreprises.idEntreprise', '=', 'lignebilan.idEntreprise')
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
        elseif($request->ratio == 'DIVIDENDE')
            $view = view('pages.ratios.dividende');
        elseif($request->ratio == 'Ratio d’Indépendance Financière (Ratio de Couverture de Risque)')
            $view = view('pages.ratios.rif');
        elseif($request->ratio == 'Ratio de Distribution de Crédit')
            $view = view('pages.ratios.rdc');
        elseif($request->ratio == 'Ratio de Collect de Depot')
            $view = view('pages.ratios.rcd');
        
        else
           return $view = view('pages.ratios.404');
        $view->entreprises = $entreprises;
        $view->exercices = $exercices;
        $view->input = $input;
        $view->Countries = $pays;
        return $view;
    }
    function ratio_res(Request $request){

        $input = $request->all();
        $RESULTATS = collect(); 
        $RESULTAT[0][0] = "01. PRODUITS BANCAIRES";
        $RESULTAT[0][1] = "pb";
        $RESULTATS = $RESULTATS->concat($RESULTAT);

        $RESULTAT[0][0] = "02. CHARGES BANCAIRES";
        $RESULTAT[0][1] = "cb";
        $RESULTATS = $RESULTATS->concat($RESULTAT);

        $RESULTAT[0][0] = "03. PRODUIT NET BANCAIRE (1-2)";
        $RESULTAT[0][1] = "pnb";
        $RESULTATS = $RESULTATS->concat($RESULTAT);

        $RESULTAT[0][0] = "04. PRODUITS ACCESSOIRES NETS";
        $RESULTAT[0][1] = "pan";
        $RESULTATS = $RESULTATS->concat($RESULTAT);

        $RESULTAT[0][0] = "05. PRODUIT GLOBAL D'EXPLOITATION (3+4)";
        $RESULTAT[0][1] = "pge";
        $RESULTATS = $RESULTATS->concat($RESULTAT);

        $RESULTAT[0][0] = "06. FRAIS GENERAUX";
        $RESULTAT[0][1] = "fg";
        $RESULTATS = $RESULTATS->concat($RESULTAT);

        $RESULTAT[0][0] = "07. AMORTISSEMENT & PROVISIONS SUR IMMOBILISATIONS";
        $RESULTAT[0][1] = "api";
        $RESULTATS = $RESULTATS->concat($RESULTAT);

        $RESULTAT[0][0] = "08. RESULTAT BRUT D'EXPLOITATION APRES AMORTISSEMENT (5-(6+7))";
        $RESULTAT[0][1] = "rbeaamor";
        $RESULTATS = $RESULTATS->concat($RESULTAT);

        $RESULTAT[0][0] = "09. PROVISIONS NETS SUR RISQUES";
        $RESULTAT[0][1] = "pnr";
        $RESULTATS = $RESULTATS->concat($RESULTAT);
        
        $RESULTAT[0][0] = "10. INTERETS SUR CREANCES DOUTEUSES ET LITIGIEUSES";
        $RESULTAT[0][1] = "icdl";
        $RESULTATS = $RESULTATS->concat($RESULTAT);
        
        $RESULTAT[0][0] = "11. RESULTAT D'EXPLOITATION(8-9+10)";
        $RESULTAT[0][1] = "re";
        $RESULTATS = $RESULTATS->concat($RESULTAT);

        $RESULTAT[0][0] = "12. RESULTAT EXCEPTIONNEL NET";
        $RESULTAT[0][1] = "ren";
        $RESULTATS = $RESULTATS->concat($RESULTAT);

        $RESULTAT[0][0] = "13. RESULTAT SUR EXERCICES ANTERIEURS";
        $RESULTAT[0][1] = "rea";
        $RESULTATS = $RESULTATS->concat($RESULTAT);

        $RESULTAT[0][0] = "14. IMPOT SUR LE BENEFICE";
        $RESULTAT[0][1] = "ib";
        $RESULTATS = $RESULTATS->concat($RESULTAT);
        
        $RESULTAT[0][0] = "15. RESULTAT(11+12+13-14)";
        $RESULTAT[0][1] = "res";
        $RESULTATS = $RESULTATS->concat($RESULTAT);

        $dbs = getDB($request);
        if ($request->exercice1 > $request->exercice2){
            $exercice1 = $request->get('exercice2');
            $exercice2 = $request->get('exercice1');
        }
        else
        {
            $exercice1 = $request->get('exercice1');
            $exercice2 = $request->get('exercice2');
        }

        $idE = explode('-',$request->get('idEntreprise'))[0];
        $nomEntreprise = explode('-',$request->get('idEntreprise'))[1];

        $infoEntreprises = DB::connection($dbs)->table('entreprises')
            ->join('ligneservices', 'entreprises.idEntreprise', '=', 'ligneservices.idEntreprise')
            ->join('service', 'ligneservices.idService', '=', 'service.idService')
            ->join('sousecteur', 'sousecteur.idSousecteur', '=', 'ligneservices.idSousecteur')
            ->join('secteur', 'secteur.idSecteur', '=', 'sousecteur.idSecteur')
            ->select('sousecteur.idsouSecteur', 'secteur.idSecteur', 'service.idService', 'entreprises.numRegistre', 'entreprises.nomEntreprise',
                'entreprises.idEntreprise', 'entreprises.Adresse', 'entreprises.Sigle', 'entreprises.codePays', 'entreprises.codeRegion',
                'entreprises.Pays', 'entreprises.type', 'entreprises.dateCreation', 'entreprises.numEnregistre', 'sousecteur.nomsouSecteur', 'service.nomService',
                'secteur.nomSecteur')->where('nomEntreprise','=',$nomEntreprise)
            ->get();

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

        $supclasses = DB::table('supClasse')
            ->get(['supClasse.idSupClasse','nomSupClasse']);

        return view('pages.ratios.resultat')
            ->with('exercices', $exercices)
            ->with('RESULTATS', $RESULTATS)
            ->with('inputs', $input)
            ->with('supclasses', $supclasses)
            ->with('infoEntreprises', $infoEntreprises);
    }
}
