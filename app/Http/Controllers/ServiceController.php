<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    function listeEntreprises(Request $request)
    {
        $dataModified = array();
        $dbs = getDB($request);
        
        if (\Request::segment(1) == "banque") {
            $entreprises = 'banque';
            // DB::connection($dbs)->table('entreprises')
            //     ->where('entreprise', 'LIKE', "%{$request->input('query')}%")
            //     ->get(['entreprise']);
        }
        else{
            $entreprises = 'no';
            // DB::connection($dbs)->table('entreprises')
            //     ->where('entreprise', 'LIKE', "%{$request->input('query')}%")
            //     ->where('type', 'B')
            //     ->get(['entreprise']);
        }
        // foreach ($entreprises as $entreprise) {
        //     $dataModified[] = $entreprise->entreprise;
        // }
        return response()->json($entreprises);
    }

    function listeBanques(Request $request)
    {
        $dbs = getDB($request);
        $entreprises = DB::connection($dbs)->table('entreprises')
            ->where('entreprise', 'LIKE', "%{$request->input('query')}%")
            ->where('type', 'B')
            ->get(['entreprise']);
        $dataModified = array();
        foreach ($entreprises as $entreprise) {
            $dataModified[] = $entreprise->entreprise;
        }
        return response()->json($dataModified);
    }

    function listeSyscoas(Request $request)
    {
        $dbs = getDB($request);
        $entreprises = DB::connection($dbs)->table('entreprises')
            ->where('entreprise', 'LIKE', "%{$request->input('query')}%")
            ->where('type','!=', 'B')
            ->get(['entreprise']);
        $dataModified = array();
        foreach ($entreprises as $entreprise) {
            $dataModified[] = htmlspecialchars($entreprise->entreprise);
        }
        return response()->json($dataModified);
    }

    public function fetchPostes(Request $request)
        {
            $dbs = getDB($request);
            if ($request->get('query')) {
                $query = $request->get('query');
                $data = DB::connection($dbs)->table('classes')
                ->join('sousclasses','classes.id','sousclasses.idClasse')
                ->join('rubriques','sousclasses.id','rubriques.idSousclasse')
                ->where('rubrique', 'LIKE', "%{$request->input('query')}%")
                ->where('systemeClasse', 'sb')
                ->get();
                return response()->json($data);
            }
        }

        public function fetchPostesSyscoa(Request $request)
        {
            $dbs = getDB($request);
            if ($request->get('query')) {
                $query = $request->get('query');
                $data = DB::connection($dbs)->table('classes')
                ->join('sousclasses','classes.id','sousclasses.idClasse')
                ->join('rubriques','sousclasses.id','rubriques.idSousclasse')
                ->where('rubrique', 'LIKE', "%{$request->input('query')}%")
                ->where('systemeClasse', 'sh')
                ->get();
                return response()->json($data);
            }
        }

    function listeSecteurs(Request $request){
        $dbs = getDB($request);
        $secteurs = DB::connection($dbs)->table('secteurs')
            ->where('secteur', 'LIKE', htmlentities("%{$request->input('query')}%"))
            ->get('secteur');
        $dataModified = array();
        foreach ($secteurs as $secteur) {
            $dataModified[] = html_entity_decode ($secteur->secteur);
        }
        return response()->json($dataModified);
    }

    function listeRatios(Request $request){
        $dbs = getDB($request);
        $ratios = DB::connection($dbs)->table('ratio')
            ->where('nomRatio', 'LIKE', "%{$request->input('query')}%")
            ->get('nomRatio');
        $dataModified = array();
        foreach ($ratios as $ratio) {
            $dataModified[] = $ratio->nomRatio;
        }
        return response()->json($dataModified);
    }

    function listeGroupes(Request $request){
        $dbs = "sensyyg2_umeoabd";
        $groupes = DB::connection($dbs)->table('groupe')
            ->where('groupe', 'LIKE', "%{$request->input('query')}%")
            ->get('groupe');
        $dataModified = array();
        foreach ($groupes as $groupe) {
            $dataModified[] = $groupe->groupe;
        }
        return response()->json($dataModified);
    }
}
