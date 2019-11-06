<?php


namespace App\Helpers;


use Illuminate\Support\Facades\DB;

class GetBrutesHelpers
{
    /*
     * ################ FOR NATURE #################
     *
     * Calculate SUM(brut) Rubrique Same Nature on Entreprise By Year
     */
    public static function getBruteNature($nature,$idEntreprise, $exercice)
    {
        return DB::table('classe')
            ->selectRaw('nature,SUM(lignebilan.brut) as total')
            ->join('sousclasse', 'classe.idClasse', '=', 'sousclasse.idClasse')
            ->join('rubrique', 'sousclasse.idSousClasse', '=', 'rubrique.idSousClasse')
            ->join('lignebilan', 'rubrique.idRubrique', '=', 'lignebilan.idRubrique')
            ->where('nature', $nature)
            ->where('lignebilan.idEntreprise', $idEntreprise)
            ->where('exercice', $exercice)
            ->groupby('nature')
            ->first();
    }
    /*
     * Calculate SUM(brut) Rubrique Same Nature on Country By Year
     */
    public static function getBruteNaturePays($nature, $exercice)
    {
        return DB::connection('sensyyg2_umeoabd')->table('classe')
            ->selectRaw('nature,SUM(lignebilan.brut) as total')
            ->join('sousclasse', 'classe.idClasse', '=', 'sousclasse.idClasse')
            ->join('rubrique', 'sousclasse.idSousClasse', '=', 'rubrique.idSousClasse')
            ->join('lignebilan', 'lignebilan.idRubrique', '=', 'rubrique.idRubrique')
            ->where('nature', $nature)
            ->where('exercice', $exercice)
            ->groupby('nature')
            ->first();
    }
    /*
     * Calculate SUM(brut) For Classe on UEMOA By Year
     */
    public static function getBruteNatureUEMOA($nature, $exercice)
    {
        return DB::connection('sensyyg2_umeoabd')->table('classe')
            ->selectRaw('nature,SUM(lignebilan.brut) as total')
            ->join('sousclasse', 'classe.idClasse', '=', 'sousclasse.idClasse')
            ->join('rubrique', 'sousclasse.idSousClasse', '=', 'rubrique.idSousClasse')
            ->join('lignebilan', 'lignebilan.idRubrique', '=', 'rubrique.idRubrique')
            ->where('nature', $nature)
            ->where('exercice', $exercice)
            ->groupby('nature')
            ->first();
    }
    /*
     * ############### FOR CLASSE #########################
     *
     * Calculate SUM(brut) For classe on Entreprise By Year
     */
    public static function getBruteClasse($classe,$idEntreprise, $exercice)
    {
        return DB::table('classe')
            ->selectRaw('classe.idClasse,SUM(lignebilan.brut) as total')
            ->join('sousclasse', 'classe.idClasse', '=', 'sousclasse.idClasse')
            ->join('rubrique', 'sousclasse.idSousClasse', '=', 'rubrique.idSousClasse')
            ->join('lignebilan', 'rubrique.idRubrique', '=', 'lignebilan.idRubrique')
            ->where('classe.idClasse', $classe)
            ->where('lignebilan.idEntreprise', $idEntreprise)
            ->where('exercice', $exercice)
            ->groupby('classe.idClasse')
            ->first();
    }
    /*
     * Calculate SUM(brut) For Classe on Country By Year
     */
    public static function getBruteClassePays($classe, $exercice)
    {
        return DB::table('classe')
            ->selectRaw('classe.idClasse,SUM(lignebilan.brut) as total')
            ->join('sousclasse', 'classe.idClasse', '=', 'sousclasse.idClasse')
            ->join('rubrique', 'sousclasse.idSousClasse', '=', 'rubrique.idSousClasse')
            ->join('lignebilan', 'lignebilan.idRubrique', '=', 'rubrique.idRubrique')
            ->where('classe.idClasse', $classe)
            ->where('exercice', $exercice)
            ->groupby('classe.idClasse')
            ->first();
    }
    /*
     * Calculate SUM(brut) For Classe on UEMOA By Year
     */
    public static function getBruteClasseUEMOA($classe, $exercice)
    {
        return DB::connection('sensyyg2_umeoabd')->table('classe')
            ->selectRaw('classe.idClasse,SUM(lignebilan.brut) as total')
            ->join('sousclasse', 'classe.idClasse', '=', 'sousclasse.idClasse')
            ->join('rubrique', 'sousclasse.idSousClasse', '=', 'rubrique.idSousClasse')
            ->join('lignebilan', 'lignebilan.idRubrique', '=', 'rubrique.idRubrique')
            ->where('classe.idClasse', $classe)
            ->where('exercice', $exercice)
            ->groupby('classe.idClasse')
            ->first();
    }
    /*
     * ############### FOR SOUS CLASSE ##################
     *
     * Calculate SUM(brut) For Sousclasse on Entreprise By Year
     */
    public static function getBruteSousClasse($sousclasse,$idEntreprise, $exercice)
    {
        return DB::table('sousclasse')
            ->selectRaw('sousclasse.idSousclasse,SUM(lignebilan.brut) as total')
            ->join('rubrique', 'sousclasse.idSousClasse', '=', 'rubrique.idSousClasse')
            ->join('lignebilan', 'lignebilan.idRubrique', '=', 'rubrique.idRubrique')
            ->where('sousclasse.idSousclasse', $sousclasse)
            ->where('idEntreprise', $idEntreprise)
            ->where('exercice', $exercice)
            ->groupby('sousclasse.idSousclasse')
            ->first();
    }
    /*
     * Calculate SUM(brut) For SousClasse on Country By Year
     */
    public static function getBruteSousClassePays($sousclasse, $exercice)
    {
        return DB::table('sousclasse')
            ->selectRaw('sousclasse.idSousclasse,SUM(lignebilan.brut) as total')
            ->join('rubrique', 'sousclasse.idSousClasse', '=', 'rubrique.idSousClasse')
            ->join('lignebilan', 'lignebilan.idRubrique', '=', 'rubrique.idRubrique')
            ->where('sousclasse.idSousclasse', $sousclasse)
            ->where('exercice', $exercice)
            ->groupby('sousclasse.idSousclasse')
            ->first();
    }
    /*
     * Calculate SUM(brut) For SousClasse on UEMOA By Year
     */
    public static function getBruteSousClasseUEMOA($sousclasse, $exercice)
        {
            return DB::connection('sensyyg2_umeoabd')->table('sousclasse')
                ->selectRaw('sousclasse.idSousclasse,SUM(lignebilan.brut) as total')
                ->join('rubrique', 'sousclasse.idSousClasse', '=', 'rubrique.idSousClasse')
                ->join('lignebilan', 'lignebilan.idRubrique', '=', 'rubrique.idRubrique')
                ->where('sousclasse.idSousclasse', $sousclasse)
                ->where('exercice', $exercice)
                ->groupby('sousclasse.idSousclasse')
                ->first();
        }
    /*
     * ############# FOR RUBRIQUE CALCUL #########
     *
     * Brut For Rubrique on Entreprise By Year
     */
    public static function getBruteRubrique($rubrique, $idEntreprise, $exercice)
    {
        return DB::table('lignebilan')
            ->selectRaw('lignebilan.brut as total')
            ->where('idRubrique', $rubrique)
            ->where('idEntreprise', $idEntreprise)
            ->where('exercice', $exercice)
            ->first();
    }
    /*
     * Calculate SUM(Brut) For Same Rubrique In Country
     */
    public static function getBruteRubriquePays($rubrique, $exercice)
    {
        return DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(lignebilan.brut) as total')
            ->where('idRubrique', $rubrique)
            ->where('exercice', $exercice)
            ->first();
    }
    /*
     * Calculate SUM(Brut) For Same Rubrique In UEMOA
     */
    public static function getBruteRubriqueUEMOA($rubrique, $exercice)
    {
        return DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(lignebilan.brut) as total')
            ->where('idRubrique', $rubrique)
            ->where('exercice', $exercice)
            ->first();
    }
}
