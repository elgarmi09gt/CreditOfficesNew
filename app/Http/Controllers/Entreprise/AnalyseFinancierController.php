<?php

namespace App\Http\Controllers\Entreprise;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AnalyseFinancierController extends Controller
{
    function bilan(Request $request)
    {
        // collection to recup data
        $totalNatureAPays = $totalNatureBPays =
        $totalNatureAUEMOA = $totalNatureBUEMOA =
            collect();
        $input = $request->all();
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

        $entreprise = $request->get('idEntreprise');
        $dbs = getDB($request);
        $idE = DB::connection($dbs)->table('entreprises')
            ->where('entreprise', '=', $entreprise)
            ->first('id');
        $idE = $idE->id;
        $idsousecteur = DB::connection($dbs)->table('ligneservices')
            ->join('sousservices','idSouservice','sousservices.id')
            ->join('services','idService','services.id')
            ->where('idEntreprise', '=', $idE)
            ->first('idSousecteur');
        // dd($idsousecteur->idSousecteur);
        if ($idsousecteur->idSousecteur != 57):
            $systemeClasse = "sh";
        else:
            $systemeClasse = "sb";
        endif;
        if ($request->get('naturep') == 'paran'):
            for ($i = $exercice1; $i <= $exercice2; $i++):
                $YEARS[] = (int) $i;
            endfor;
        else:
            $YEARS[] = (int) $exercice01;
            $YEARS[] = (int) $exercice02;
        endif;
        if ($request->get('document') == 'bilan'):
            $natureA = 'actif';
            $natureB = 'passif';
        else:
            if($typeClasse == 'old'):
                $natureA = 'charge';
                $natureB = 'produit';
            else:
                $natureA = 'res';
                $natureB = '';
            endif;
        endif;
        $infoEntreprises = DB::connection($dbs)->table('entreprises')
            ->join('ligneservices', 'entreprises.id', '=', 'ligneservices.idEntreprise')
            ->join('sousservices', 'idSouservice', '=', 'sousservices.id')
            ->join('services', 'idService', '=', 'services.id')
            ->join('soussecteurs', 'soussecteurs.id', '=', 'services.idSousecteur')
            ->join('secteurs', 'secteurs.id', '=', 'soussecteurs.idSecteur')
            ->select('soussecteurs.id', 'secteurs.id', 'services.id', 'entreprises.numRegistre', 'entreprises.entreprise',
                'entreprises.id', 'entreprises.adresse', 'entreprises.sigle',
                'entreprises.type', 'entreprises.dateCreation', 'entreprises.numEnregistre', 'soussecteurs.sousecteur', 'services.service',
                'secteurs.secteur')->where('entreprise', $entreprise)
            ->get();
        ############## Actifs ou Charges ##########
        $classesA = DB::connection($dbs)->table('classes')
            ->where('nature', $natureA)
            ->where('systemeClasse', $systemeClasse)
            ->where('typeClasse', $typeClasse)
            ->orderBy('classes.id', 'asc')
            ->get();
        ########## Passifs ou Produit###############
        if($natureB):
            $classesB = DB::connection($dbs)->table('classes')
                ->where('nature', $natureB)
                ->where('systemeClasse', $systemeClasse)
                ->where('typeClasse', $typeClasse)
                ->orderBy('classes.id', 'asc')
                ->get();
        else:
            $classesB = '';            
        endif;
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
        // dd('totalNatureAPays '.$totalNatureAPays , 'totalNatureBPays '.$totalNatureBPays , 'totalNatureAUEMOA '.$totalNatureAUEMOA , 'totalNatureBUEMOA '.$totalNatureBUEMOA,$exercices);
        $view = view('pages.entreprises.bilan');
        $view->input = $input;
        $view->classesA = $classesA;
        $view->typeClasse = $typeClasse;
        $view->systemeClasse = $systemeClasse;
        $view->natureA = $natureA;
        $view->exercices = $exercices;
        $view->infoEntreprises = $infoEntreprises;
        $view->natureB = $natureB;
        if($natureB):
            $view->classesB = $classesB;
//            $view->totalNatureBPays = $totalNatureBPays;
        endif;
//        $view->totalNatureAPays = $totalNatureAPays;
        $view->dbs = $dbs;
        $view->idE = $idE;
        /*if ($input['localite'] == 'uemoa'):
            $view->totalNatureAUEMOA = $totalNatureAUEMOA;
            if ($natureB):
                $view->totalNatureBUEMOA = $totalNatureBUEMOA;
            endif;
        endif;*/
        return $view;
    }

    function bilan_diff(Request $request)
    {
        $totalNatureA = $totalNatureAR =
        $totalNatureB = $totalNatureBR =
            collect();
        $input = $request->all();
        $typeClasse = $request->get('annee');
        if ($typeClasse == 'new') {
            $exercice1 = $request->get('exercice1');
            $exercice2 = $request->get('exercice2');
        } 
        else {
            $exercice1 = $request->get('exercice3');
            $exercice2 = $request->get('exercice4');
        }
        if ($exercice1 > $exercice2) {
            $exo = $exercice1;
            $exercice1 = $exercice2;
            $exercice2 = $exo;
        }
        $exercice01 = $exercice1;
        $exercice02 = $exercice2;
        $entreprise = $request->get('idEntreprise');
        $dbs = getDB($request);
        $idE = DB::connection($dbs)->table('entreprises')
            ->where('entreprise', '=', $entreprise)
            ->first('id');
        $idE = $idE->id;
        $entrepriseR = $request->get('idEntrepriser');
        $idER = DB::connection($dbs)->table('entreprises')
            ->where('entreprise', '=', $entrepriseR)
            ->first('id');
        $idER = $idER->id;
        
        $idsousecteur = DB::connection($dbs)->table('ligneservices')
            ->where('idEntreprise', '=', $idE)
            ->first('idsouSecteur');
        if ($idsousecteur->idsouSecteur != 13):
            $systemeClasse = "sh";
        else:
            $systemeClasse = "sb";
        endif;

        if ($request->get('naturep') == 'paran'):
            for ($i = $exercice1; $i <= $exercice2; $i++):
                $YEARS[] = $i;
            endfor;
        else:
            $YEARS[] = $exercice01;
            $YEARS[] = $exercice02;
        endif;
        if ($request->get('document') == 'bilan'):
            $natureA = 'actif';
            $natureB = 'passif';
        else:
            $natureA = 'charge';
            $natureB = 'produit';
        endif;
        $infoEntreprisesR = DB::connection($dbs)->table('entreprises')
            ->join('ligneservices', 'entreprises.id', '=', 'ligneservices.idEntreprise')
            ->join('services', 'ligneservices.idService', '=', 'services.id')
            ->join('soussecteurs', 'soussecteurs.id', '=', 'ligneservices.idSousecteur')
            ->join('secteurs', 'secteurs.id', '=', 'soussecteurs.idSecteur')
            ->select('soussecteurs.id', 'secteurs.id', 'services.id', 'entreprises.numRegistre', 'entreprises.entreprise',
                'entreprises.id', 'entreprises.adresse', 'entreprises.sigle',
                'entreprises.type', 'entreprises.dateCreation', 'entreprises.numEnregistre', 'soussecteurs.sousecteur', 'services.service',
                'secteurs.secteur')->where('entreprise', $entrepriseR)
            ->get();
        $infoEntreprises = DB::connection($dbs)->table('entreprises')
            ->join('ligneservices', 'entreprises.id', '=', 'ligneservices.idEntreprise')
            ->join('services', 'ligneservices.idService', '=', 'services.id')
            ->join('soussecteurs', 'soussecteurs.id', '=', 'ligneservices.idSousecteur')
            ->join('secteurs', 'secteurs.id', '=', 'soussecteurs.idSecteur')
            ->select('soussecteurs.id', 'secteurs.id', 'services.id', 'entreprises.numRegistre', 'entreprises.entreprise',
                'entreprises.id', 'entreprises.adresse', 'entreprises.sigle',
                'entreprises.type', 'entreprises.dateCreation', 'entreprises.numEnregistre', 'soussecteurs.sousecteur', 'services.service',
                'secteurs.secteur')->where('entreprise', $entreprise)
            ->get();

        $entreprises = DB::connection($dbs)->table('entreprises')
            ->where('id', $idE)->orWhere('id', $idER)->get('id');

        ############## Actifs ou Charges ##########
        $classesA = DB::connection($dbs)->table('classes')
            ->where('nature', $natureA)
            ->where('systemeClasse', $systemeClasse)
            ->where('typeClasse', $typeClasse)
            ->orderBy('classes.id', 'asc')
            ->get(['classe', 'id', 'nature']);

        ########## Passifs ou Produit###############
        $classesB = DB::connection($dbs)->table('classes')
            ->where('nature', $natureB)
            ->where('systemeClasse', $systemeClasse)
            ->where('typeClasse', $typeClasse)
            ->orderBy('classes.id', 'asc')
            ->get(['classe', 'id', 'nature']);

        for ($i = 0; $i < count($YEARS); $i++):
            $totalA = DB::connection($dbs)->table('classes')
                ->selectRaw('idEntreprise,exercice,SUM(lignebilans.brute) as total')
                ->join('sousclasses', 'classes.id', 'sousclasses.idClasse')
                ->join('rubriques', 'sousclasses.id', 'rubriques.idSousclasse')
                ->join('lignebilans', 'rubriques.id', 'lignebilans.idRubrique')
                ->where('nature', $natureA)
                ->where('exercice', $YEARS[$i])
                ->where('systemeClasse', $systemeClasse)
                ->where('typeClasse', $typeClasse)
                ->where('lignebilans.idEntreprise', $idE)
                ->groupBy('exercice','idEntreprise')
                ->get();
            $totalAR = DB::connection($dbs)->table('classes')
                ->selectRaw('idEntreprise,exercice,SUM(lignebilans.brute) as total')
                ->join('sousclasses', 'classes.id', 'sousclasses.idClasse')
                ->join('rubriques', 'sousclasses.id', 'rubriques.idSousclasse')
                ->join('lignebilans', 'rubriques.id', 'lignebilans.idRubrique')
                ->where('nature', $natureA)
                ->where('exercice', $YEARS[$i])
                ->where('systemeClasse', $systemeClasse)
                ->where('typeClasse', $typeClasse)
                ->where('lignebilans.idEntreprise', $idER)
                ->groupBy('exercice','idEntreprise')
                ->get();

            $totalB = DB::connection($dbs)->table('classes')
                ->selectRaw('idEntreprise,exercice,SUM(lignebilans.brute) as total')
                ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
                ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousclasse')
                ->join('lignebilans', 'rubriques.id', '=', 'lignebilans.idRubrique')
                ->where('nature', '=', $natureB)
                ->where('exercice', '=', $YEARS[$i])
                ->where('systemeClasse', '=', $systemeClasse)
                ->where('typeClasse', '=', $typeClasse)
                ->where('lignebilans.idEntreprise', '=', $idE)
                ->groupBy('exercice','idEntreprise')
                ->get();
            $totalBR = DB::connection($dbs)->table('classes')
                ->selectRaw('idEntreprise,exercice,SUM(lignebilans.brute) as total')
                ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
                ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousclasse')
                ->join('lignebilans', 'rubriques.id', '=', 'lignebilans.idRubrique')
                ->where('nature', '=', $natureB)
                ->where('exercice', '=', $YEARS[$i])
                ->where('systemeClasse', '=', $systemeClasse)
                ->where('typeClasse', '=', $typeClasse)
                ->where('lignebilans.idEntreprise', '=', $idER)
                ->groupBy('exercice','idEntreprise')
                ->get();

            $totalNatureA = $totalNatureA->concat($totalA);
            $totalNatureB = $totalNatureB->concat($totalB);
            $totalNatureAR = $totalNatureAR->concat($totalAR);
            $totalNatureBR = $totalNatureBR->concat($totalBR);
        endfor;
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

        $view = view('pages.entreprises.difference');
        $view->input = $input;
        $view->totalNatureBR = $totalNatureBR;
        $view->totalNatureAR = $totalNatureBR;
        $view->totalNatureB = $totalNatureB;
        $view->totalNatureA = $totalNatureA;
        $view->classesA = $classesA;
        $view->classesB = $classesB;
        $view->exercices = $exercices;
        $view->infoEntreprisesR = $infoEntreprisesR;
        $view->infoEntreprises = $infoEntreprises;
        $view->idE = $idE;
        $view->idER = $idER;
        $view->dbs = $dbs;
        $view->exercice01 = $exercice01;
        $view->exercice02 = $exercice02;
        $view->entreprises = $entreprises;

        return $view;
    }


    function bilan_post(Request $request){
        
        $input = $request->all();
        ################ Uniformisation of parameters ########################
        if ($request->exercice1 > $request->exercice2) {
            $exercice1 = $request->exercice2;
            $exercice2 = $request->exercice1;
        } else {
            $exercice1 = $request->get('exercice1');
            $exercice2 = $request->get('exercice2');
        }
        $dbs = getDB($request);

        $posteid = DB::connection($dbs)->table('rubriques')
        ->where('rubrique',$request->poste)->first()->id;

        $entrepriseid = DB::connection($dbs)->table('entreprises')
        ->where('entreprise', $request->idEntreprise)->first()->id;

        $infoEntreprises = DB::connection($dbs)->table('entreprises')
            ->join('ligneservices', 'entreprises.id', '=', 'ligneservices.idEntreprise')
            ->join('services', 'ligneservices.idService', '=', 'services.id')
            ->join('soussecteurs', 'soussecteurs.id', '=', 'ligneservices.idSousecteur')
            ->join('secteurs', 'secteurs.id', '=', 'soussecteurs.idSecteur')
            ->select('soussecteurs.id', 'secteurs.id', 'services.id', 'entreprises.numRegistre', 'entreprises.entreprise',
                'entreprises.id', 'entreprises.adresse', 'entreprises.sigle',
                'entreprises.type', 'entreprises.dateCreation', 'entreprises.numEnregistre', 'soussecteurs.sousecteur', 'services.service',
                'secteurs.secteur')->where('entreprise', $request->idEntreprise)
            ->first();

        if ($request->get('naturep') == 'paran'):
            $exercices = DB::connection($dbs)->table('lignebilans')
                ->where('exercice', '>=', $exercice1)
                ->where('exercice', '<=', $exercice2)
                ->groupBy('exercice')
                ->get('exercice');
        else:
            $exercices = DB::connection($dbs)->table('lignebilans')
                ->where('exercice', '=', $exercice1)
                ->orwhere('exercice', '=', $exercice2)
                ->groupBy('exercice')
                ->get('exercice');
        endif;
        $view = view('pages.entreprises.poste');
        $view->posteid = $posteid;
        $view->infoEntreprises = $infoEntreprises;        
        $view->entrepriseid = $entrepriseid;
        $view->input = $input;
        $view->dbs = $dbs;
        $view->exercice1 = $exercice1;
        $view->exercice2 = $exercice2;
        $view->exercices = $exercices;
        return $view;
    } 
}
