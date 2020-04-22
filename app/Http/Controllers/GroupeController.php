<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\DB;
    
    class GroupeController extends Controller
    {
        function index_bilan(){

            $dbs = "sensyyg2_umeoabd";
            $lignebilans = DB::connection($dbs)->table('lignegroupe')
            ->groupBy('exercice')->get('exercice');
            return view('forms.groupes.groupe_form')
                ->with('lignebilans', $lignebilans);
        }

        function bilan(Request $request){
            // Job Database
            $dbs = "sensyyg2_umeoabd";
            
            /**
             * Collection to store for concataning and storing data
             */
            $bilanUEMOA = $entreprises = collect();

            $inputs = $request->all();
            if ($request->exercice1 < $request->exercice2):
                $exercice1 = $request->exercice1;
                $exercice2 = $request->exercice2;
            else:
                $exercice1 = $request->exercice2;
                $exercice2 = $request->exercice1;
            endif;

            if (!$request->groupe):
                $groupe = 'all';
            else:
                $groupe = $request->groupe;
                $idgroupe = DB::connection($dbs)->table('groupe')
                ->where('groupe',$groupe)
                ->first('idgroupe');
            endif;
            if ($request->naturep == 'paran'):
            for ($i = $exercice1; $i <= $exercice2; $i++):
                    $YEARS [] = $i;
                endfor;
            else:
                $YEARS [] = $exercice1;
                $YEARS [] = $exercice2;
            endif;
            if ($groupe == 'all'):
                    // if no specific group : choice all groupe
                $groupes = DB::connection($dbs)->table('groupe')
                    ->selectRaw('groupe,groupe.idGroupe,origine')
                    ->join('lignegroupe','lignegroupe.idGroupe','groupe.idGroupe')
                    ->distinct()
                    ->whereIn('exercice',$YEARS)
                    ->get();
            else:
                $groupes = DB::connection($dbs)->table('groupe')
                    ->selectRaw('groupe,groupe.idGroupe,origine')
                    ->join('lignegroupe','lignegroupe.idGroupe','groupe.idGroupe')
                    ->distinct()
                    ->whereIn('exercice',$YEARS)
                    ->where('groupe',$groupe)
                    ->get();
                    // if specific group : choice all entreprise of this
            endif;
            foreach ($groupes as $key => $value) {
                $e = DB::connection($dbs)->table('entreprises')
                    ->selectRaw('idPays,entreprises.idEntreprise,idGroupe')
                    ->distinct()
                    ->join('lignegroupe','lignegroupe.idEntreprise','entreprises.idEntreprise')
                    ->where('idGroupe',$value->idGroupe)
                    ->whereIn('exercice',$YEARS)
                    ->get();
                    $entreprises = $entreprises->concat($e);
            }

            foreach ($YEARS as $key => $value) {
                $totalAUEMOA = DB::connection('sensyyg2_umeoabd')->table('classe')
                ->selectRaw('exercice,SUM(lignebilan.brut) as total')
                ->join('sousclasse' , 'classe.idClasse' , '=' , 'sousclasse.idClasse')
                ->join('rubrique' , 'sousclasse.idSousclasse' , '=' , 'rubrique.idSousclasse')
                ->join('lignebilan' , 'rubrique.idRubrique' , '=' , 'lignebilan.idRubrique')
                ->where('exercice','=',$value)
                ->where('nature','=','actif')
                ->groupBy('exercice')
                ->get();

                if($totalAUEMOA->count()== 0):
                    $totalAUEMOA->exercice = $value;
                    $totalAUEMOA->total = 0;
                endif;
                $bilanUEMOA = $bilanUEMOA->concat($totalAUEMOA);
            }

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

            $view = view('pages.groupe.bilan');
            $view->inputs = $inputs;
            $view->bilanUEMOA = $bilanUEMOA;
            $view->groupes = $groupes;
            $view->entreprises = $entreprises;
            $view->exercices = $exercices;
            return $view;
        }
}
