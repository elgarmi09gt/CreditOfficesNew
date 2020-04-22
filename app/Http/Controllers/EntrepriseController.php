<?php

namespace App\Http\Controllers;
use App\Models\Entreprises;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EntrepriseController extends Controller
    {
    /**
     * Function for standard bilan in Activity Sector
     */
    function index_bilan(Request $pays){
        $dbs = getDB($pays);
        $lignebilans = DB::connection($dbs)->table('lignebilans')
        ->where('exercice','<=',2017)
        ->groupBy('exercice')
        ->get('exercice');
        $lignebilansNew = DB::connection($dbs)->table('lignebilans')
        ->where('exercice','>=',2017)
        ->groupBy('exercice')->get('exercice');
        return view('forms.entreprises.rechNew_bilan')
            ->with('pays', $pays->pays)
            ->with('lignebilans', $lignebilans)
            ->with('lignebilansNew', $lignebilansNew);
    }
    function bilan(Request $request){
        
        // collection to recup data
        $totalNatureA = $totalNatureB =
        $totalNatureAPays = $totalNatureBPays =
        $totalNatureAUEMOA = $totalNatureBUEMOA =
            collect();
        $input = $request->all();
        // Analyse période and type
        $typeClasse = $request->get('annee');
        if( $typeClasse == 'new'){
            $exercice1 = $request->get('exercice1');
            $exercice2 = $request->get('exercice2');
            }
        else
            {
                $exercice1 = $request->get('exercice3');
                $exercice2 = $request->get('exercice4');
            }
        // Normalise years
        if ($exercice1 > $exercice2){
            $exo = $exercice1;
            $exercice1 = $exercice2;
            $exercice2 = $exo;
        }
        $exercice01 = $exercice1;
        $exercice02 = $exercice2;
        
        $entreprise = $request->get('idEntreprise');
        $dbs = getDB($request);
        $idE = DB::connection($dbs)->table('entreprises')
            ->where('entreprise','=',$entreprise)
            ->first('id');
        // dd($idE->idEntreprise);
        $idE = $idE->id;
        $idsousecteur = DB::connection($dbs)->table('ligneservices')
            ->where('idEntreprise','=',$idE)
            ->first('idsouSecteur');
        if ($idsousecteur->idsouSecteur != 13):
            $systemeClasse = "sh";
        else:
            $systemeClasse = "sb";
        endif;
        if ($request->get('naturep') == 'paran'):
            for ($i = $exercice1; $i <= $exercice2; $i++):
                $YEARS [] = $i;
            endfor;
        else:
            $YEARS [] = $exercice01; $YEARS [] = $exercice02;
        endif;
        if ($request->get('document')=='bilan'):
            $natureA = 'actif'; $natureB = 'passif';
        else:
            $natureA = 'charge'; $natureB = 'produit';
        endif;
        $infoEntreprises = DB::connection($dbs)->table('entreprises')
            ->join('ligneservices', 'entreprises.id', '=', 'ligneservices.idEntreprise')
            ->join('services', 'ligneservices.idService', '=', 'services.id')
            ->join('soussecteurs', 'soussecteurs.id', '=', 'ligneservices.idSousecteur')
            ->join('secteurs', 'secteurs.id', '=', 'soussecteurs.idSecteur')
            ->select('soussecteurs.id', 'secteurs.id', 'services.id', 'entreprises.numRegistre', 'entreprises.entreprise',
                'entreprises.id', 'entreprises.adresse', 'entreprises.sigle',
                'entreprises.type', 'entreprises.dateCreation', 'entreprises.numEnregistre', 'soussecteurs.sousecteur', 'services.service',
                'secteurs.secteur')->where('entreprise',$entreprise)
            ->get();
        ############## Actifs ou Charges ##########
        $classesA = DB::connection($dbs)->table('classes')
            ->where('nature',$natureA)
            ->where('systemeClasse',$systemeClasse)
            ->where('typeClasse',$typeClasse)
            ->orderBy('classes.id','asc')
            ->get(['classe','id','nature']);

        ########## Passifs ou Produit###############
        $classesB = DB::connection($dbs)->table('classes')
            ->where('nature',$natureB)
            ->where('systemeClasse',$systemeClasse)
            ->where('typeClasse',$typeClasse)
            ->orderBy('classes.id','asc')
            ->get(['classe','id','nature']);
            ####### Pour chaque année traitement necessaire #######
        #### Total nature pour chaque catégorie : Actif, Passif, Charge, Produit (Entreprise, Pays, Uemoa)
        
        for ($i=0; $i<count($YEARS); $i++):
            $totalA = DB::connection($dbs)->table('classes')
                ->selectRaw('exercice,SUM(lignebilans.brute) as total')
                ->join('sousclasses' , 'classes.id' , 'sousclasses.idClasse')
                ->join('rubriques' , 'sousclasses.id' , 'rubriques.idSousclasse')
                ->join('lignebilans' , 'rubriques.id' , 'lignebilans.idRubrique')
                ->where('nature' , $natureA)
                ->where('exercice' , $YEARS[$i])
                ->where('systemeClasse',$systemeClasse)
                ->where('typeClasse',$typeClasse)
                ->where('lignebilans.idEntreprise' , $idE)
                ->groupBy('exercice')
                ->get();
                if($totalA->count()== 0):
                    $totalA = collect([
                                        [
                                            'exercice'  =>  $YEARS[$i],
                                            'total'     =>  0
                                        ]
                                    ]);
                endif;
            $totalAPays = DB::connection($dbs)->table('classes')
                ->selectRaw('exercice,SUM(lignebilans.brute) as total')
                ->join('sousclasses' , 'classes.id' , 'sousclasses.idClasse')
                ->join('rubriques' , 'sousclasses.id' , 'rubriques.idSousclasse')
                ->join('lignebilans' , 'rubriques.id' , 'lignebilans.idRubrique')
                ->where('exercice',$YEARS[$i])
                ->where('systemeClasse',$systemeClasse)
                ->where('typeClasse',$typeClasse)
                ->where('nature',$natureA)
                ->groupBy('exercice')
                ->get();
            if($totalAPays->count()== 0):
                    $totalAPays = collect([
                                        [
                                            'exercice'  =>  $YEARS[$i],
                                            'total'     =>  0
                                        ]
                                    ]);
                endif;
            $totalB = DB::connection($dbs)->table('classes')
                ->selectRaw('exercice,SUM(lignebilans.brute) as total')
                ->join('sousclasses' , 'classes.id' , '=' , 'sousclasses.idClasse')
                ->join('rubriques' , 'sousclasses.id' , '=' , 'rubriques.idSousclasse')
                ->join('lignebilans' , 'rubriques.id' , '=' , 'lignebilans.idRubrique')
                ->where('nature' , '=' , $natureB)
                ->where('exercice' , '=' , $YEARS[$i])
                ->where('systemeClasse','=',$systemeClasse)
                ->where('typeClasse','=',$typeClasse)
                ->where('lignebilans.idEntreprise' , '=' , $idE)
                ->groupBy('exercice')
                ->get();
            if($totalB->count()== 0):
                    $totalB = collect([
                                        [
                                            'exercice'  =>  $YEARS[$i],
                                            'total'     =>  0
                                        ]
                                    ]);
                endif;
            $totalBPays = DB::connection($dbs)->table('classes')
                ->selectRaw('exercice,SUM(lignebilans.brute) as total')
                ->join('sousclasses' , 'classes.id' , '=' , 'sousclasses.idClasse')
                ->join('rubriques' , 'sousclasses.id' , '=' , 'rubriques.idSousclasse')
                ->join('lignebilans' , 'rubriques.id' , '=' , 'lignebilans.idRubrique')
                ->join('entreprises','lignebilans.idEntreprise','=','entreprises.id')
                ->join('ligneservices','entreprises.id','=','ligneservices.idEntreprise')
                ->where('exercice','=',$YEARS[$i])
                ->where('systemeClasse','=',$systemeClasse)
                ->where('typeClasse','=',$typeClasse)
                ->where('nature','=',$natureB)
                ->groupBy('exercice')
                ->get();
            if($totalBPays->count()== 0):
                    $totalBPays = collect([
                                        [
                                            'exercice'  =>  $YEARS[$i],
                                            'total'     =>  0
                                        ]
                                    ]);
                endif;
            
            $totalNatureA = $totalNatureA->concat($totalA);
            $totalNatureB = $totalNatureB->concat($totalB);
            $totalNatureAPays = $totalNatureAPays->concat($totalAPays);
            $totalNatureBPays = $totalNatureBPays->concat($totalBPays);
            // If UEMOA default db 
            if($input['localite'] == 'uemoa'):
                $totalAUEMOA = DB::table('classes')
                    ->selectRaw('exercice,SUM(lignebilans.brute) as total')
                    ->join('sousclasses' , 'classes.id' , '=' , 'sousclasses.idClasse')
                    ->join('rubriques' , 'sousclasses.id' , '=' , 'rubriques.idSousclasse')
                    ->join('lignebilans' , 'rubriques.id' , '=' , 'lignebilans.idRubrique')
                    ->where('exercice','=',$YEARS[$i])
                    ->where('systemeClasse','=',$systemeClasse)
                    ->where('typeClasse','=',$typeClasse)
                    ->where('nature','=',$natureA)
                    ->groupBy('exercice')
                    ->get();
                if($totalAUEMOA->count()== 0):
                    $totalAUEMOA = collect([
                                        [
                                            'exercice'  =>  $YEARS[$i],
                                            'total'     =>  0
                                        ]
                                    ]);
                endif;
                $totalBUEMOA = DB::table('classes')
                    ->selectRaw('exercice,SUM(lignebilans.brute) as total')
                    ->join('sousclasses' , 'classes.id' , '=' , 'sousclasses.idClasse')
                    ->join('rubriques' , 'sousclasses.id' , '=' , 'rubriques.idSousclasse')
                    ->join('lignebilans' , 'rubriques.id' , '=' , 'lignebilans.idRubrique')
                    ->join('entreprises','lignebilans.idEntreprise','=','entreprises.id')
                    ->join('ligneservices','entreprises.id','=','ligneservices.idEntreprise')
                    ->where('exercice','=',$YEARS[$i])
                    ->where('typeClasse','=',$typeClasse)
                    ->where('systemeClasse','=',$systemeClasse)
                    ->where('nature','=',$natureB)
                    ->groupBy('exercice')
                    ->get();
                if($totalBUEMOA->count()== 0):
                    $totalBUEMOA = collect([
                                        [
                                            'exercice'  =>  $YEARS[$i],
                                            'total'     =>  0
                                        ]
                                    ]);
                endif;
                $totalNatureAUEMOA = $totalNatureAUEMOA->concat($totalAUEMOA);
                $totalNatureBUEMOA = $totalNatureBUEMOA->concat($totalBUEMOA);
            endif;
        endfor;
        if ($request->get('naturep') == 'paran'):
            $exercices = DB::connection($dbs)->table('lignebilans')
                ->where('exercice','>=',$exercice01)
                ->where('exercice','<=',$exercice02)
                ->groupBy('exercice')
                ->get('exercice');
        else:
            $exercices = DB::connection($dbs)->table('lignebilans')
                ->where('exercice','=',$exercice01)
                ->orwhere('exercice','=',$exercice02)
                ->groupBy('exercice')
                ->get('exercice');
        endif;
        // dd('totalNatureA '. $totalNatureA , 'totalNatureB '.$totalNatureB ,'totalNatureAPays '.$totalNatureAPays , 'totalNatureBPays '.$totalNatureBPays , 'totalNatureAUEMOA '.$totalNatureAUEMOA , 'totalNatureBUEMOA '.$totalNatureBUEMOA,$exercices);
        $view = view('pages.entreprises.bilan');
        $view->input = $input;
        $view->classesA = $classesA;
        $view->exercices = $exercices;
        $view->infoEntreprises = $infoEntreprises;
        $view->classesB = $classesB;
        $view->totalNatureA = $totalNatureA;
        $view->totalNatureB = $totalNatureB;
        $view->totalNatureBPays = $totalNatureBPays;
        $view->totalNatureAPays = $totalNatureAPays;
        $view->dbs = $dbs;
        $view->idE = $idE;
        if($input['localite'] == 'uemoa'):
            $view->totalNatureAUEMOA = $totalNatureAUEMOA;
            $view->totalNatureBUEMOA = $totalNatureBUEMOA;
        endif;
        return $view;
    }
    /**
     *Function For difference bilan of entreprise in same Activity
     */
    function index_bilan_diff(Request $request){
        $dbs = getDB($request);
        $lignebilans = DB::connection($dbs)->table('lignebilans')->groupBy('exercice')->get('exercice');
        return view('forms.entreprises.diff_bilan')
            ->with('pays', $request['pays'])
            ->with('lignebilans', $lignebilans);
    }
    function bilan_diff(Request $request){
        $collectclassesA = $collectclassesB =
        $collectclassesAR = $collectclassesBR =
        $collecttotalclassesA = $collecttotalclassesB =
        $collecttotalclassesAR = $collecttotalclassesBR =
            collect();
        $input = $request->all();
        if ($request->get('exercice1') > $request->get('exercice2')){
            $exercice1 = $request->get('exercice2');
            $exercice2 = $request->get('exercice1');
        }else
        {
            $exercice1 = $request->get('exercice1');
            $exercice2 = $request->get('exercice2');
        }
        $exercice01 = $exercice1;
        $exercice02 = $exercice2;
        ################### La verification doit etre dynamique #################
        $idER = explode('-',$request->get('idEntrepriser'))[0];
        $entrepriseR = explode('-',$request->get('idEntrepriser'))[1];
        $idE = explode('-',$request->get('idEntreprise'))[0];
        $entreprise = explode('-',$request->get('idEntreprise'))[1];
        $dbs = getDB($request);
        $idsousecteur = DB::connection($dbs)->table('ligneservices')
            ->where('idEntreprise','=',$idER)
            ->get('idsouSecteur');
        foreach ($idsousecteur as $item):
            $idsousecteur = $item->idsouSecteur;
        endforeach;
        if ($request->get('naturep') == 'paran'):
            for ($i = $exercice1; $i <= $exercice2; $i++):
                $YEARS [] = $i;
            endfor;
        else:
            $YEARS [] = $exercice01; $YEARS [] = $exercice02;
        endif;
        if ($request->get('document')=='bilan'):
            $natureA = 'actif'; $natureB = 'passif';
        else:
            $natureA = 'charge';  $natureB = 'produit';
        endif;
        $infoEntrepriseR = DB::connection($dbs)->table('entreprises')
            ->join('ligneservices', 'entreprises.id', '=', 'ligneservices.idEntreprise')
            ->join('service', 'ligneservices.idService', '=', 'service.idService')
            ->join('sousecteur', 'sousecteur.idSousecteur', '=', 'ligneservices.idSousecteur')
            ->join('secteur', 'secteur.idSecteur', '=', 'sousecteur.idSecteur')
            ->select('sousecteur.idsouSecteur', 'secteur.idSecteur', 'service.idService', 'entreprises.numRegistre', 'entreprises.entreprise',
                'entreprises.id', 'entreprises.Adresse', 'entreprises.Sigle', 'entreprises.codePays', 'entreprises.codeRegion',
                'entreprises.Pays', 'entreprises.type', 'entreprises.dateCreation', 'entreprises.numEnregistre', 'sousecteur.nomsouSecteur', 'service.nomService',
                'secteur.nomSecteur')->where('entreprises.id','=',$idER)
            ->get();
        $infoEntreprise = DB::connection($dbs)->table('entreprises')
            ->join('ligneservices', 'entreprises.id', '=', 'ligneservices.idEntreprise')
            ->join('service', 'ligneservices.idService', '=', 'service.idService')
            ->join('sousecteur', 'sousecteur.idSousecteur', '=', 'ligneservices.idSousecteur')
            ->join('secteur', 'secteur.idSecteur', '=', 'sousecteur.idSecteur')
            ->select('sousecteur.idsouSecteur', 'secteur.idSecteur', 'service.idService', 'entreprises.numRegistre', 'entreprises.entreprise',
                'entreprises.id', 'entreprises.Adresse', 'entreprises.Sigle', 'entreprises.codePays', 'entreprises.codeRegion',
                'entreprises.Pays', 'entreprises.type', 'entreprises.dateCreation', 'entreprises.numEnregistre', 'sousecteur.nomsouSecteur', 'service.nomService',
                'secteur.nomSecteur')->where('entreprises.id','=',$idE)
            ->get();

        $entreprises = DB::connection($dbs)->table('entreprises')
            ->where('idEntreprise',$idE)->orWhere('idEntreprise',$idER)->get('idEntreprise');

        $classesA = DB::connection($dbs)->table('classes')
            ->where('nature','=',$natureA)->orderBy('classes.id','asc')
            ->get('nomClasse');
        ########## Passifs ###############
        $classesB = DB::connection($dbs)->table('classes')
            ->where('nature','=',$natureB)->orderBy('classes.id','asc')
            ->get('nomClasse');
        // Selectionner les classes a afficher en fonction des données recuperées apres post ddu formulaire
        ########## Actifs ###############
        // En fonction de la classes recupéré la somme des rubriquess dans lignebilans en passant par sous classes et rubriques
        foreach ($classesA as $classesA):
            // Recuperer pour chaque année d'exercice la somme des rubriques de chaque classes
            for ($i=0; $i<count($YEARS); $i++):
                // Global de chaque classes (somme rubriques) pour l'entreprise reference
                $SommeAR=DB::connection($dbs)->table('classes')
                    ->selectRaw('idEntreprise,nomClasse,nature,exercice,SUM(lignebilans.brute) as total')
                    ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
                    ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousclasses')
                    ->join('lignebilans', 'rubriques.id', '=', 'lignebilans.idRubrique')
                    ->where('exercice', '=', $YEARS[$i])
                    ->where('lignebilans.idEntreprise', '=', $idER)
                    ->where('classes.nomClasse', '=', $classesA->nomClasse)
                    ->where('nature', '=', $natureA)
                    ->groupby('nomClasse', 'nature', 'exercice','idEntreprise')
                    ->get();
                // Global de chaque classes (somme rubriques) pour l'entreprise
                $SommeA=DB::connection($dbs)->table('classes')
                    ->selectRaw('idEntreprise,nomClasse,nature,exercice,SUM(lignebilans.brute) as total')
                    ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
                    ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousclasses')
                    ->join('lignebilans', 'rubriques.id', '=', 'lignebilans.idRubrique')
                    ->where('exercice', '=', $YEARS[$i])
                    ->where('lignebilans.idEntreprise', '=', $idE)
                    ->where('classes.nomClasse', '=', $classesA->nomClasse)
                    ->where('nature', '=', $natureA)
                    ->groupby('nomClasse', 'nature', 'exercice','idEntreprise')
                    ->get();

                $collectclassesAR=$collectclassesAR->concat($SommeAR);
                $collectclassesA=$collectclassesA->concat($SommeA);
            endfor;
        endforeach;
        foreach ($classesB as $classesB):
            // Recuperer pour chaque année d'exercice la somme des rubriques de chaque classes
            for ($i=0; $i<count($YEARS); $i++):
                // Global de chaque classes (somme rubriques) pour l'entreprise
                $SommeB=DB::connection($dbs)->table('classes')
                    ->selectRaw('idEntreprise,nomClasse,nature,exercice,SUM(lignebilans.brute) as total')
                    ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
                    ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousclasses')
                    ->join('lignebilans', 'rubriques.id', '=', 'lignebilans.idRubrique')
                    ->where('exercice', '=', $YEARS[$i])
                    ->where('lignebilans.idEntreprise', '=', $idE)
                    ->where('classes.nomClasse', '=', $classesB->nomClasse)
                    ->where('nature', '=', $natureB)
                    ->groupby('nomClasse', 'nature', 'exercice','idEntreprise')
                    ->get();
                $SommeBR=DB::connection($dbs)->table('classes')
                    ->selectRaw('idEntreprise,nomClasse,nature,exercice,SUM(lignebilans.brute) as total')
                    ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
                    ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousclasses')
                    ->join('lignebilans', 'rubriques.id', '=', 'lignebilans.idRubrique')
                    ->where('exercice', '=', $YEARS[$i])
                    ->where('lignebilans.idEntreprise', '=', $idER)
                    ->where('classes.nomClasse', '=', $classesB->nomClasse)
                    ->where('nature', '=', $natureB)
                    ->groupby('nomClasse', 'nature', 'exercice','idEntreprise')
                    ->get();
                $collectclassesBR=$collectclassesBR->concat($SommeBR);
                $collectclassesB=$collectclassesB->concat($SommeB);

            endfor;
        endforeach;
        for ($i=0; $i<count($YEARS); $i++):
            $totalclassesAR = DB::connection($dbs)->table('classes')
                ->selectRaw('idEntreprise,exercice,SUM(lignebilans.brute) as total')
                ->join('sousclasses' , 'classes.id' , '=' , 'sousclasses.idClasse')
                ->join('rubriques' , 'sousclasses.id' , '=' , 'rubriques.idSousclasses')
                ->join('lignebilans' , 'rubriques.id' , '=' , 'lignebilans.idRubrique')
                ->where('nature' , '=' , $natureA)
                ->where('exercice' , '=' , $YEARS[$i])
                ->where('lignebilans.idEntreprise' , '=' , $idER)
                ->groupBy('exercice','idEntreprise')
                ->get();
            $totalclassesA = DB::connection($dbs)->table('classes')
                ->selectRaw('idEntreprise,exercice,SUM(lignebilans.brute) as total')
                ->join('sousclasses' , 'classes.id' , '=' , 'sousclasses.idClasse')
                ->join('rubriques' , 'sousclasses.id' , '=' , 'rubriques.idSousclasses')
                ->join('lignebilans' , 'rubriques.id' , '=' , 'lignebilans.idRubrique')
                ->where('nature' , '=' , $natureA)
                ->where('exercice' , '=' , $YEARS[$i])
                ->where('lignebilans.idEntreprise' , '=' , $idE)
                ->groupBy('exercice','idEntreprise')
                ->get();

            $totalclassesBR = DB::connection($dbs)->table('classes')
                ->selectRaw('idEntreprise,exercice,SUM(lignebilans.brute) as total')
                ->join('sousclasses' , 'classes.id' , '=' , 'sousclasses.idClasse')
                ->join('rubriques' , 'sousclasses.id' , '=' , 'rubriques.idSousclasses')
                ->join('lignebilans' , 'rubriques.id' , '=' , 'lignebilans.idRubrique')
                ->where('nature' , '=' , $natureB)
                ->where('exercice' , '=' , $YEARS[$i])
                ->where('lignebilans.idEntreprise' , '=' , $idER)
                ->groupBy('exercice','idEntreprise')
                ->get();
            $totalclassesB = DB::connection($dbs)->table('classes')
                ->selectRaw('idEntreprise,exercice,SUM(lignebilans.brute) as total')
                ->join('sousclasses' , 'classes.id' , '=' , 'sousclasses.idClasse')
                ->join('rubriques' , 'sousclasses.id' , '=' , 'rubriques.idSousclasses')
                ->join('lignebilans' , 'rubriques.id' , '=' , 'lignebilans.idRubrique')
                ->where('nature' , '=' , $natureB)
                ->where('exercice' , '=' , $YEARS[$i])
                ->where('lignebilans.idEntreprise' , '=' , $idE)
                ->groupBy('exercice','idEntreprise')
                ->get();
            // Concataine collection to return resBilan blade
            $collecttotalclassesAR = $collecttotalclassesAR->concat($totalclassesAR);
            $collecttotalclassesBR = $collecttotalclassesBR->concat($totalclassesBR);
            $collecttotalclassesA = $collecttotalclassesA->concat($totalclassesA);
            $collecttotalclassesB = $collecttotalclassesB->concat($totalclassesB);

        endfor;

        if ($request->get('naturep') == 'paran'):
            $exercices = DB::connection($dbs)->table('lignebilans')
                ->where('exercice','>=',$exercice01)
                ->where('exercice','<=',$exercice02)
                ->groupBy('exercice')
                ->get('exercice');
        else:
            $exercices = DB::connection($dbs)->table('lignebilans')
                ->where('exercice','=',$exercice01)
                ->orwhere('exercice','=',$exercice02)
                ->groupBy('exercice')
                ->get('exercice');
        endif;
        $view = view('pages.entreprises.difference');
        $view->input = $input;
        $view->collectclassesAR = $collectclassesAR;
        $view->collectclassesA = $collectclassesA;
        $view->collecttotalclassesAR = $collecttotalclassesAR;
        $view->collecttotalclassesA = $collecttotalclassesA;
        $view->classesA = $classesA;
        $view->exercices = $exercices;
        $view->infoEntreprisesR = $infoEntrepriseR;
        $view->infoEntreprises = $infoEntreprise;
        $view->collectclassesBR = $collectclassesBR;
        $view->collectclassesB = $collectclassesB;
        $view->collecttotalclassesB = $collecttotalclassesB;
        $view->collecttotalclassesBR = $collecttotalclassesBR;
        $view->classesB = $classesB;
        $view->entreprises = $entreprises;
        return $view;
    }

    /**
     *Function for Poste Bilan
     */
    function index_bilan_post(Request $request){
        $dbs = getDB($request);
        $lignebilans = DB::connection($dbs)->table('lignebilans')->groupBy('exercice')->get('exercice');
        $natures = DB::connection($dbs)->table('classes')->groupBy('nature')->get('nature');
        $postes = DB::connection($dbs)->table('rubriques')->get(['nomRubrique', 'idRubrique']);
        $view = view('forms.entreprises.poste_bilan');
        $view->pays = $request['pays'];
        $view->lignebilans = $lignebilans;
        $view->natures = $natures;
        $view->postes = $postes;
        return $view;
    }
    function bilan_post(Request $request){
        $collectPoste = $collecttotalPoste = $collectSameNature = $collectSameNatureCountry = $collectEntreprise
            = $collectPosteUEMOA = $collectSameNatureUEMOA
            = collect();
        $input = $request->all();

        ################ Uniformisation of parameters ########################
        if ($request->exercice1 > $request->exercice2) {
            $exercice1 = $request->exercice2;
            $exercice2 = $request->exercice1;
        } else {
            $exercice1 = $request->get('exercice1');
            $exercice2 = $request->get('exercice2');
        }

        ################# Recupes values provide to requeste form et customise if not #############
        $exercice01 = $exercice1;
        $poste = $request->poste;
        $nature = $request->nature;
        $dbs = getDB($request);
        $idE = explode('-', $request->idEntreprise)[0];
//        $entreprise = explode('-', $request->idEntreprise)[1];
//        $naturep = $request->naturep;
//        $document = $request->document;
//        $localite = $request->localite;

        if ($exercice1 > 2000) {
            $exercice1 -= 1;
        }
        ############# Take good intervall ############
        if ($request->get('naturep') == 'paran'):
            for ($i = $exercice1; $i <= $exercice2; $i++):
                $YEARS [] = $i;
            endfor;
        else:
            $YEARS [] = $exercice01;
            $YEARS [] = $exercice2;
        endif;
        ####### End of recuperation ##########

        $Poste_ = DB::connection($dbs)->table('rubriques')
            ->where('idRubrique', $poste)
            ->first();
        $Sigle = DB::connection($dbs)->table('entreprises')
            ->where('idEntreprise',$idE)
            ->first();

        ### If Local Post
        ########### Select Poste val for either year ####
        for ($i = 0; $i < count($YEARS); $i++):
            /*
             * Poste for selected Entreprise
             */
            $PostEntreprise = DB::connection($dbs)
                ->table('lignebilans')
                ->where('idEntreprise', $idE)
                ->where('idRubrique', $poste)
                ->where('exercice', $YEARS[$i])
                ->get(['brute', 'idEntreprise', 'exercice']);
            $collectPoste = $collectPoste->concat($PostEntreprise);
            /*
            * Sum All Poste same nature of selected poste in same Entreprise.*
            */
            $PostEntreprise = DB::connection($dbs)->table('lignebilans')
                ->selectRaw('exercice,SUM(lignebilans.brute) as total')
                ->join('rubriques', 'lignebilans.idRubrique', '=', 'rubriques.id')
                ->join('sousclasses', 'sousclasses.id', '=', 'rubriques.idSousclasses')
                ->join('classes', 'classes.id', '=', 'sousclasses.idClasse')
                ->where('classes.nature', $nature)
                ->where('lignebilans.idEntreprise', $idE)
                ->where('exercice', $YEARS[$i])
                ->groupBy('exercice')
                ->get();
            $collectSameNature = $collectSameNature->concat($PostEntreprise);
            /*
             * Poste for Selected Country
             */
            $PostEntreprise = DB::connection($dbs)->table('lignebilans')
                ->selectRaw('nomRubrique,exercice,SUM(lignebilans.brute) as total')
                ->join('rubriques', 'lignebilans.idRubrique', '=', 'rubriques.id')
                ->where('rubriques.id', $poste)
                ->where('exercice', $YEARS[$i])
                ->groupBy('exercice', 'nomRubrique')
                ->get();
            $collecttotalPoste = $collecttotalPoste->concat($PostEntreprise);
            /*
            * Sum All Poste same nature of selected poste in same Country.*
            */
            $PostEntreprise = DB::connection($dbs)->table('lignebilans')
                ->selectRaw('exercice,SUM(lignebilans.brute) as total')
                ->join('rubriques', 'lignebilans.idRubrique', '=', 'rubriques.id')
                ->join('sousclasses', 'sousclasses.id', '=', 'rubriques.idSousclasses')
                ->join('classes', 'classes.id', '=', 'sousclasses.idClasse')
                ->where('classes.nature', $nature)
                ->where('exercice', $YEARS[$i])
                ->groupBy('exercice')
                ->get();
            $collectSameNatureCountry = $collectSameNatureCountry->concat($PostEntreprise);
            ##### If UEMOA Post
            if ($request->localite == 'uemoa'):
                /*
             * Poste for Selected Poste in UEMOA
             */
                $con = 'sensyyg2_umeoabd';
                $PostEntreprise = DB::connection($con)->table('lignebilans')
                    ->selectRaw('nomRubrique,exercice,SUM(lignebilans.brute) as total')
                    ->join('rubriques', 'lignebilans.idRubrique', '=', 'rubriques.id')
                    ->where('rubriques.id', $poste)
                    ->where('exercice', $YEARS[$i])
                    ->groupBy('exercice', 'nomRubrique')
                    ->get();
                $collectPosteUEMOA = $collectPosteUEMOA->concat($PostEntreprise);
                /*
                * Sum All Poste same nature of selected poste in UEMOA.*
                */
                $PostEntreprise = DB::connection($con)->table('lignebilans')
                    ->selectRaw('exercice,SUM(lignebilans.brute) as total')
                    ->join('rubriques', 'lignebilans.idRubrique', '=', 'rubriques.id')
                    ->join('sousclasses', 'sousclasses.id', '=', 'rubriques.idSousclasses')
                    ->join('classes', 'classes.id', '=', 'sousclasses.idClasse')
                    ->where('classes.nature', $nature)
                    ->where('exercice', $YEARS[$i])
                    ->groupBy('exercice')
                    ->get();
                $collectSameNatureUEMOA = $collectSameNatureUEMOA->concat($PostEntreprise);
            endif;
        endfor;
        if ($request->get('naturep') == 'paran'):
            $exercices = DB::connection($dbs)->table('lignebilans')
                ->where('exercice', '>=', $exercice01)
                ->where('exercice', '<=', $exercice2)
                ->groupBy('exercice')
                ->get('exercice');
        else:
            $exercices = DB::connection($dbs)->table('lignebilans')
                ->where('exercice', '=', $exercice01)
                ->orwhere('exercice', '=', $exercice2)
                ->groupBy('exercice')
                ->get('exercice');
        endif;
        $view = view('pages.entreprises.poste');
        $view->input = $input;
        $view->exercices = $exercices;
        $view->collectPostes = $collectPoste;
        $view->Poste_ = $Poste_;
        $view->Sigle = $Sigle;
        $view->collecttotalPostes = $collecttotalPoste;
        $view->collectSameNatures = $collectSameNature;
        $view->collectSameNatureCountries = $collectSameNatureCountry;
        if ($request->localite == 'uemoa'):
            $view->collectPosteUEMOA = $collectPosteUEMOA;
            $view->collectSameNatureUEMOA = $collectSameNatureUEMOA;
        endif;
        return $view;
    }
}
