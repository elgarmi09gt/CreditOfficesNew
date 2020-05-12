<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class GetBrutesHelpers
{
    public static function getBianGroupe($idGroupe, $exercice)
    {
        // Get entreprise 
        $entreprises = DB::table('entreprises')
            ->selectRaw('idPays,entreprises.idEntreprise,idGroupe')
            ->distinct()
            ->join('lignegroupe', 'lignegroupe.idEntreprise', 'entreprises.idEntreprise')
            ->where('idGroupe', $idGroupe)
            ->where('exercice', $exercice)
            ->get();
        // Variable to store brute group    
        $brute = 0;
        /** To have group balance(bilan) sum bilan of etheir entreprise of this group **/
        foreach ($entreprises as $key => $value) {
            # code...
            $bd = DB::table('pays')
                ->where('idPays', $value->idPays)
                ->where('cedeao', 'ce')
                ->first('bdpays');
            $b = DB::connection($bd->bdpays)->table('classes')
                ->selectRaw('nature,SUM(lignebilans.brute) as total')
                ->join('sousclasses', 'classes.idClasse', '=', 'sousclasses.idClasse')
                ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousClasse')
                ->join('lignebilans', 'rubriques.id', '=', 'lignebilans.idRubrique')
                ->where('nature', 'actif')
                ->where('lignebilans.idEntreprise', $value->idEntreprise)
                ->where('exercice', $exercice)
                ->groupby('nature')
                ->first();

            if (!$b) {
                $brute += 0;
            } else
                $brute += (int)$b->total;
        }

        return $brute;
    }

    public static function getBilanEntreprise($idPays, $idEntreprise, $exercice)
    {
        $bd = DB::table('pays')->where('id', $idPays)
            ->where('cedeao', 'ce')
            ->first('bdpays');

        $a = DB::connection($bd->bdpays)->table('classes')
            ->selectRaw('exercice,SUM(lignebilans.brute) as total')
            ->join('sousclasses', 'classes.id', 'sousclasses.idClasse')
            ->join('rubriques', 'sousclasses.id', 'rubriques.idSousclasse')
            ->join('lignebilans', 'rubriques.id', 'lignebilans.idRubrique')
            ->where('nature', 'actif')
            ->where('exercice', $exercice)
            ->where('systemClasse', 'sb')
            ->where('lignebilans.idEntreprise', $idEntreprise)
            ->groupBy('exercice')
            ->first();

        if (!$a)
            return 0;
        return $a->total;
    }

    public static function getBruteMacro($dbs,$macro,$exercice){
        return DB::connection($dbs)->table('lignemacros')
            ->selectRaw('lignemacros.brute as total')
            ->where('idMacro', $macro)
            ->where('exercice', $exercice)
            ->first();
    }

    public static function getBruteSouSecteurAgreat($dbs,$sousecteur,$exercice){
        return DB::connection($dbs)->table('soussecteur_macros')
            ->selectRaw('soussecteur_macros.id,SUM(brute) as total')
            ->join('macro_agregats', 'soussecteur_macros.id', '=', 'idSouSecteur')
            ->join('lignemacros', 'idMacro', '=', 'macro_agregats.id')
            ->where('soussecteur_macros.id', $sousecteur)
            ->where('exercice', $exercice)
            ->groupby('soussecteur_macros.id')
            ->first();
    }

    public static function getBruteMacroUEMOA($macro, $exercice){
        return DB::connection('bic_uemoa')->table('lignemacros')
            ->selectRaw('SUM(lignemacros.brute) as total')
            ->where('idMacro', $macro)
            ->where('exercice', $exercice)
            ->first();
    }

    public static function getBruteSouSecteurAgreatUEMOA($sousecteur,$exercice){
        return DB::connection('bic_uemoa')->table('soussecteur_macros')
            ->selectRaw('soussecteur_macros.id,SUM(brute) as total')
            ->join('macro_agregats', 'soussecteur_macros.id', '=', 'idSouSecteur')
            ->join('lignemacros', 'idMacro', '=', 'macro_agregats.id')
            ->where('soussecteur_macros.id', $sousecteur)
            ->where('exercice', $exercice)
            ->groupby('soussecteur_macros.id')
            ->first();
    }

    public static function getBruteNature($dbs, $nature, $system, $type, $idEntreprise, $exercice)
    {
        return DB::connection($dbs)->table('classes')
            ->selectRaw('nature,SUM(lignebilans.brute) as total')
            ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
            ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousClasse')
            ->join('lignebilans', 'rubriques.id', '=', 'lignebilans.idRubrique')
            ->where('nature', $nature)
            ->where('typeClasse', $type)
            ->where('systemeClasse', $system)
            ->where('lignebilans.idEntreprise', $idEntreprise)
            ->where('exercice', $exercice)
            ->groupby('nature')
            ->first();
    }

    /*
     * Calculate SUM(brute) Rubrique Same Nature on Country By Year
     */
    public static function getBruteNaturePays($dbs, $nature, $system, $type, $exercice)
    {
        return DB::connection($dbs)->table('classes')
            ->selectRaw('exercice,nature,SUM(lignebilans.brute) as total')
            ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
            ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousClasse')
            ->join('lignebilans', 'lignebilans.idRubrique', '=', 'rubriques.id')
            ->where('nature', $nature)
            ->where('typeClasse', $type)
            ->where('systemeClasse', $system)
            ->where('exercice', $exercice)
            ->groupby(['nature','exercice'])
            ->first();
    }

    public static function getBruteNatureUEMOA($nature, $system, $type, $exercice)
    {
        return DB::connection('bic_uemoa')->table('classes')
            ->selectRaw('exercice,nature,SUM(lignebilans.brute) as total')
            ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
            ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousClasse')
            ->join('lignebilans', 'lignebilans.idRubrique', '=', 'rubriques.id')
            ->where('nature', $nature)
            ->where('systemeClasse', $system)
            ->where('typeClasse', $type)
            ->where('exercice', $exercice)
            ->groupby(['nature','exercice'])
            ->first();
    }

    /*
     * ############### FOR CLASSE #########################
     *
     * Calculate SUM(brute) For classes on Entreprise By Year
     */
    public static function getBruteClasse($dbs, $classes, $idEntreprise, $exercice)
    {
        return DB::connection($dbs)->table('classes')
            ->selectRaw('classes.id,SUM(lignebilans.brute) as total')
            ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
            ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousClasse')
            ->join('lignebilans', 'rubriques.id', '=', 'lignebilans.idRubrique')
            ->where('classes.id', $classes)
            ->where('lignebilans.idEntreprise', $idEntreprise)
            ->where('exercice', $exercice)
            ->groupby('classes.id')
            ->first();
    }

    /*
     * Calculate SUM(brute) For Classe on Country By Year
     */
    public static function getBruteClassePays($dbs, $classes, $exercice)
    {
        return DB::connection($dbs)->table('classes')
            ->selectRaw('classes.id,SUM(lignebilans.brute) as total')
            ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
            ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousClasse')
            ->join('lignebilans', 'lignebilans.idRubrique', '=', 'rubriques.id')
            ->where('classes.id', $classes)
            ->where('exercice', $exercice)
            ->groupby('classes.id')
            ->first();
    }

    /*
     * Calculate SUM(brute) For Classe on UEMOA By Year
     */
    public static function getBruteClasseUEMOA( $classes, $exercice)
    {
        return DB::connection('bic_uemoa')->table('classes')
            ->selectRaw('classes.id,SUM(lignebilans.brute) as total')
            ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
            ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousClasse')
            ->join('lignebilans', 'lignebilans.idRubrique', '=', 'rubriques.id')
            ->where('classes.id', $classes)
            ->where('exercice', $exercice)
            ->groupby('classes.id')
            ->first();
    }

    /*
     * ############### FOR SOUS CLASSE ##################
     *
     * Calculate SUM(brute) For Sousclasses on Entreprise By Year
     */
    public static function getBruteSousClasse($dbs, $sousclasses, $idEntreprise, $exercice)
    {
        return DB::connection($dbs)->table('sousclasses')
            ->selectRaw('sousclasses.id,SUM(lignebilans.brute) as total')
            ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousClasse')
            ->join('lignebilans', 'lignebilans.idRubrique', '=', 'rubriques.id')
            ->where('sousclasses.id', $sousclasses)
            ->where('idEntreprise', $idEntreprise)
            ->where('exercice', $exercice)
            ->groupby('sousclasses.id')
            ->first();
    }

    /*
     * Calculate SUM(brute) For SousClasse on Country By Year
     */
    public static function getBruteSousClassePays($dbs, $sousclasses, $exercice)
    {
        return DB::connection($dbs)->table('sousclasses')
            ->selectRaw('sousclasses.id,SUM(lignebilans.brute) as total')
            ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousClasse')
            ->join('lignebilans', 'lignebilans.idRubrique', '=', 'rubriques.id')
            ->where('sousclasses.id', $sousclasses)
            ->where('exercice', $exercice)
            ->groupby('sousclasses.id')
            ->first();
    }

    /*
     * Calculate SUM(brute) For SousClasse on UEMOA By Year
     */
    public static function getBruteSousClasseUEMOA( $sousclasses, $exercice)
    {
        return DB::connection('bic_uemoa')->table('sousclasses')
            ->selectRaw('sousclasses.id,SUM(lignebilans.brute) as total')
            ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousClasse')
            ->join('lignebilans', 'lignebilans.idRubrique', '=', 'rubriques.id')
            ->where('sousclasses.id', $sousclasses)
            ->where('exercice', $exercice)
            ->groupby('sousclasses.id')
            ->first();
    }

    /*
     * ############# FOR RUBRIQUE CALCUL #########
     *
     * Brut For Rubrique on Entreprise By Year
     */
    public static function getBruteRubrique($dbs, $rubriques, $idEntreprise, $exercice)
    {
        return DB::connection($dbs)->table('lignebilans')
            ->selectRaw('lignebilans.brute as total')
            ->where('idRubrique', $rubriques)
            ->where('idEntreprise', $idEntreprise)
            ->where('exercice', $exercice)
            ->first();
    }

    /*
     * Calculate SUM(Brut) For Same Rubrique In Country
     */
    public static function getBruteRubriquePays($dbs, $rubriques, $exercice)
    {
        return DB::connection($dbs)->table('lignebilans')
            ->selectRaw('SUM(lignebilans.brute) as total')
            ->where('idRubrique', $rubriques)
            ->where('exercice', $exercice)
            ->first();
    }

    /*
     * Calculate SUM(Brut) For Same Rubrique In UEMOA
     */
    public static function getBruteRubriqueUEMOA($rubriques, $exercice)
    {
        return DB::connection('bic_uemoa')->table('lignebilans')
            ->selectRaw('SUM(lignebilans.brute) as total')
            ->where('idRubrique', $rubriques)
            ->where('exercice', $exercice)
            ->first();
    }

    public static function BruteClasseSecteur($dbs, $classe, $secteur, $exercice)
    {
        return DB::connection($dbs)->table('sousclasses')
            ->selectRaw('idSecteur,SUM(lignebilans.brute) as total')
            ->join('rubriques', 'idSousClasse', '=', 'sousclasses.id')
            ->join('lignebilans', 'idRubrique', '=', 'rubriques.id')
            ->join('ligneservices', 'ligneservices.idEntreprise', '=', 'lignebilans.idEntreprise')
            ->join('sousservices', 'idSouservice', '=', 'sousservices.id')
            ->join('services', 'idService', '=', 'services.id')
            ->join('soussecteurs', 'idSousecteur', '=', 'soussecteurs.id')
            ->where('idClasse', $classe)
            ->where('exercice', $exercice)
            ->where('idSecteur', $secteur)
            ->groupby('idSecteur')
            ->first();
    }

    public static function BruteClasseSousSecteur($dbs, $classe, $sousecteur, $exercice)
    {
        return DB::connection($dbs)->table('sousclasses')
            ->selectRaw('idSousecteur,SUM(lignebilans.brute) as total')
            ->join('rubriques', 'idSousClasse', '=', 'sousclasses.id')
            ->join('lignebilans', 'idRubrique', '=', 'rubriques.id')
            ->join('ligneservices', 'ligneservices.idEntreprise', '=', 'lignebilans.idEntreprise')
            ->join('sousservices', 'idSouservice', '=', 'sousservices.id')
            ->join('services', 'idService', '=', 'services.id')
            ->join('soussecteurs', 'idSousecteur', '=', 'soussecteurs.id')
            ->where('idClasse', $classe)
            ->where('exercice', $exercice)
            ->where('idSousecteur', $sousecteur)
            ->groupby('idSousecteur')
            ->first();
    }
    public static function BruteClasseService($dbs, $classe, $service, $exercice)
    {
        return DB::connection($dbs)->table('sousclasses')
            ->selectRaw('idService,SUM(lignebilans.brute) as total')
            ->join('rubriques', 'idSousClasse', '=', 'sousclasses.id')
            ->join('lignebilans', 'idRubrique', '=', 'rubriques.id')
            ->join('ligneservices', 'ligneservices.idEntreprise', '=', 'lignebilans.idEntreprise')
            ->join('sousservices', 'idSouservice', '=', 'sousservices.id')
            ->join('services', 'idService', '=', 'services.id')
            ->join('soussecteurs', 'idSousecteur', '=', 'soussecteurs.id')
            ->where('idClasse', $classe)
            ->where('exercice', $exercice)
            ->where('idService', $service)
            ->groupby('idService')
            ->first();
    }
    public static function BruteClasseSousService($dbs, $classe, $souservice, $exercice)
    {
        return DB::connection($dbs)->table('sousclasses')
            ->selectRaw('idSouservice,SUM(lignebilans.brute) as total')
            ->join('rubriques', 'idSousClasse', '=', 'sousclasses.id')
            ->join('lignebilans', 'idRubrique', '=', 'rubriques.id')
            ->join('ligneservices', 'ligneservices.idEntreprise', '=', 'lignebilans.idEntreprise')
            ->join('sousservices', 'idSouservice', '=', 'sousservices.id')
            ->join('services', 'idService', '=', 'services.id')
            ->join('soussecteurs', 'idSousecteur', '=', 'soussecteurs.id')
            ->where('idClasse', $classe)
            ->where('exercice', $exercice)
            ->where('idSouservice', $souservice)
            ->groupby('idSouservice')
            ->first();
    }
}
