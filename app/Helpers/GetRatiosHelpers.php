<?php


namespace App\Helpers;


use Illuminate\Support\Facades\DB;

class GetRatiosHelpers
{
    /*
     * Format Ratio
     */
    public static function FormatRatio(){

    }
    /*
    *   Ratio de la situation clientèle
    */
    public static function rsc($entreprise,$exercice,$bd){
        $op2 = GetRatiosHelpers::Operation_clientel_passif($entreprise,$exercice,$bd);
        $op1 = GetRatiosHelpers::Operation_clientel_actif($entreprise,$exercice,$bd);
        if (!$op1 || !$op2 || $op2->total == 0) {
            return 0;
        }
        return round(($op1->total / $op2->total)*100,2);
    }
    public static function rscPays($exercice,$bd){
        $op2 = GetRatiosHelpers::Operation_clientel_passifPays($exercice,$bd);
        $op1 = GetRatiosHelpers::Operation_clientel_actifPays($exercice,$bd);
        if (!$op1 || !$op2 || $op2->total == 0) {
            return 0;
        }
        return round(($op1->total / $op2->total)*100,2);
        
    }
    public static function rscUEMOA($exercice){
        $op2 = GetRatiosHelpers::Operation_clientel_passifUEMOA($exercice);
        $op1 = GetRatiosHelpers::Operation_clientel_actifUEMOA($exercice);
        if (!$op1 || !$op2 || $op2->total == 0) {
            return 0;
        }
        return round(($op1->total / $op2->total)*100,2);
        
    }
    /*
    *   Ratio de la situation de la trésorerie
    */
    public static function rst($entreprise,$exercice,$bd){
        $op2 = GetRatiosHelpers::Operation_tresorerie_passif($entreprise,$exercice,$bd);
        $op1 = GetRatiosHelpers::Operation_tresorerie_actif($entreprise,$exercice,$bd);
        if (!$op1 || !$op2 || $op2->total == 0) {
            return 0;
        }
        return round(($op1->total / $op2->total)*100,2);
    }
    public static function rstPays($exercice,$bd){
        $op2 = GetRatiosHelpers::Operation_tresorerie_passifPays($exercice,$bd);
        $op1 = GetRatiosHelpers::Operation_tresorerie_actifPays($exercice,$bd);
        if (!$op1 || !$op2 || $op2->total == 0) {
            return 0;
        }
        return round(($op1->total / $op2->total)*100,2);
        
    }
    public static function rstUEMOA($exercice){
        $op2 = GetRatiosHelpers::Operation_tresorerie_passifUEMOA($exercice);
        $op1 = GetRatiosHelpers::Operation_tresorerie_actifUEMOA($exercice);
        if (!$op1 || !$op2 || $op2->total == 0) {
            return 0;
        }
        return round(($op1->total / $op2->total)*100,2);
        
    }
    /*
    *   Le ratio du type de crédits distribués
    */
    public static function rtcd1($entreprise,$exercice,$bd){

    }
    public static function rtcd1Pays($exercice,$bd){
        
    }
    public static function rtcd1UEMOA($exercice){
        
    }
    public static function rtcd2($entreprise,$exercice,$bd){

    }
    public static function rtcd2Pays($exercice,$bd){
        
    }
    public static function rtcd2UEMOA($exercice){
        
    }
    public static function rtcd3($entreprise,$exercice,$bd){

    }
    public static function rtcd3Pays($exercice,$bd){
        
    }
    public static function rtcd3UEMOA($exercice){
        
    }
    /*
    *   Les ratios de type de dépôts collectés
    */
    public static function rtdc1($entreprise,$exercice,$bd){

    }
    public static function rtdc1Pays($exercice,$bd){
        
    }
    public static function rtdc1UEMOA($exercice){
        
    }
    public static function rtdc2($entreprise,$exercice,$bd){

    }
    public static function rtdc2Pays($exercice,$bd){
        
    }
    public static function rtdc2UEMOA($exercice){
        
    }
    /*
    *   Le ratio de production
    */
    public static function rp($entreprise,$exercice,$bd){
        $op = GetRatiosHelpers::totalBilan($entreprise,$exercice,$bd);
        if (!$op || $op->total == 0 ) {
            return 0;
        }
        return round((GetRatiosHelpers::pnb($entreprise,$exercice,$bd) / $op->total)*100,2);
        
    }
    public static function rpPays($exercice,$bd){
        $op = GetRatiosHelpers::totalBilanPays($exercice,$bd);
        if (!$op || $op->total == 0 ) {
            return 0;
        }
        return round((GetRatiosHelpers::pnbPays($exercice,$bd) / $op->total)*100,2);
        
    }
    public static function rpUEMOA($exercice){
        $op = GetRatiosHelpers::totalBilanUEMOA($exercice);
        if (!$op || $op->total == 0 ) {
            return 0;
        }
        return round((GetRatiosHelpers::pnbUEMOA($exercice) / $op->total)*100,2);
        
    }
    /*
    *   Le ratio de productivité générale : Produit Net Bancaire / Friax Généraux
    */
    public static function rpg($entreprise,$exercice,$bd){
        $op = GetRatiosHelpers::pnb($entreprise,$exercice,$bd);
        if ($op == 0) {
            return 0;
        }
        return round((GetRatiosHelpers::fg($entreprise,$exercice,$bd) / $op)*100,2);

    }
    public static function rpgPays($exercice,$bd){
        $op = GetRatiosHelpers::pnbPays($exercice,$bd);
        if ($op == 0) {
            return 0;
        }
        return round((GetRatiosHelpers::fgPays($exercice,$bd) / $op)*100,2);

    }
    public static function rpgUEMOA($exercice){
        $op = GetRatiosHelpers::pnbUEMOA($exercice);
        if ($op == 0) {
            return 0;
        }
        return round((GetRatiosHelpers::fgUEMOA($exercice) / $op)*100,2);

    }
    /*
    *   Le ratio de marge nette
    */
    public static function rmn($entreprise,$exercice,$bd){

    }
    public static function rmnPays($exercice,$bd){
        
    }
    public static function rmnUEMOA($exercice){
        
    }
    // Ratio de dstribution de credit
    public static function rdc($entreprise,$exercice,$bd){
        $op1 = GetRatiosHelpers::Operation_clientel_actif($entreprise,$exercice,$bd);
        $op2 = GetRatiosHelpers::totalBilan($entreprise,$exercice,$bd);

        if (!$op1 || !$op2 || $op1->total == 0 || $op2->total == 0):
            return 0.0;
        endif;
        return round(($op1->total / $op2->total)*100,2);
    }
    public static function rdcPays($exercice,$bd){
        $op1 = GetRatiosHelpers::Operation_clientel_actifPays($exercice,$bd);
        $op2 = GetRatiosHelpers::totalBilanPays($exercice,$bd);

        if (!$op1 || !$op2 || $op1->total == 0 || $op2->total == 0):
            return 0.0;
        endif;
        return round(($op1->total / $op2->total)*100,2);
    }
    public static function rdcUEMOA($exercice){
        $op1 = GetRatiosHelpers::Operation_clientel_actifUEMOA($exercice);
        $op2 = GetRatiosHelpers::totalBilanUEMOA($exercice);

        if (!$op1 || !$op2 || $op1->total == 0 || $op2->total == 0):
            return 0.0;
        endif;
        return round(($op1->total / $op2->total)*100,2);
    }
    // Ratio de dstribution de credit
    public static function rcd($entreprise,$exercice,$bd){
        $op1 = GetRatiosHelpers::Operation_clientel_passif($entreprise,$exercice,$bd);
        $op2 = GetRatiosHelpers::totalBilan($entreprise,$exercice,$bd);

        if (!$op1 || !$op2 || $op1->total == 0 || $op2->total == 0):
            return 0.0;
        endif;
        return round(($op1->total / $op2->total)*100,2);
    }
    public static function rcdPays($exercice,$bd){
        $op1 = GetRatiosHelpers::Operation_clientel_passifPays($exercice,$bd);
        $op2 = GetRatiosHelpers::totalBilanPays($exercice,$bd);

        if (!$op1 || !$op2 || $op1->total == 0 || $op2->total == 0):
            return 0.0;
        endif;
        return round(($op1->total / $op2->total)*100,2);
    }
    public static function rcdUEMOA($exercice){
        $op1 = GetRatiosHelpers::Operation_clientel_passifUEMOA($exercice);
        $op2 = GetRatiosHelpers::totalBilanUEMOA($exercice);

        if (!$op1 || !$op2 || $op1->total == 0 || $op2->total == 0):
            return 0.0;
        endif;
        return round(($op1->total / $op2->toatl)*100,2);
    }

    // Ration d'independance financiere ou De couverture de risque
    public static function rif($entreprise,$exercice,$bd){
        $op1 = GetRatiosHelpers::fondPropre($entreprise,$exercice,$bd);
        $op2 = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[22,24,27,28,31,32])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        if (!$op1 || !$op2 || $op1->total == 0 || $op2->total == 0):
            return 0.0;
        endif;
        return round(($op1->total / ($op1->total + $op2->total))*100,2);
    }
    public static function rifPays($exercice,$bd){
        $op1 = GetRatiosHelpers::fondProprePays($exercice,$bd);
        $op2 = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[22,24,27,28,31,32])
            ->where('exercice',$exercice)
            ->first();

        if (!$op1 || !$op2 || $op1->total == 0 || $op2->total == 0):
            return 0.0;
        endif;
        return round(($op1->total / ($op1->total + $op2->total))*100,2);
    }
    public static function rifUEMOA($exercice){
        $op1 = GetRatiosHelpers::fondPropreUEMOA($exercice);
        $op2 = DB::connection('sensyyg2_umeoabd')->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[22,24,27,28,31,32])
            ->where('exercice',$exercice)
            ->first();

        if (!$op1 || !$op2 || $op1->total == 0 || $op2->total == 0):
            return 0.0;
        endif;
        return round(($op1->total / ($op1->total + $op2->total))*100,2);
    }
    /* Dividende*/
    public static function dividende($entreprise, $exercice){
        $op1 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[39,41,42])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();
        $op2 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[39,41])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice+1)
            ->first();

        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function dividendePays($exercice){
        $op1 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[39,41,42])
            ->where('exercice',$exercice)
            ->first();
        $op2 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[39,41])
            ->where('exercice',$exercice+1)
            ->first();

        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function dividendeUEMOA($exercice){
        $op1 = DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[39,41,42])
            ->where('exercice',$exercice)
            ->first();
        $op2 = DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[39,41])
            ->where('exercice',$exercice+1)
            ->first();

        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }

    /* 1. Produit Bancaire */
    public static function pb($entreprise, $exercice,$bd){
        $pb = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[65,66,67,68,69,70,71,72,73,74,75,87])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        if (!$pb): $pb = 0 ; else: $pb = (int)$pb->total; endif;
        return $pb;
    }
    public static function pbPays($exercice,$bd){
        $pb = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[65,66,67,68,69,70,71,72,73,74,75,87])
            ->where('exercice',$exercice)
            ->first();

        if (!$pb): $pb = 0 ; else: $pb = (int)$pb->total; endif;
        return $pb;
    }
    public static function pbUEMOA($exercice){
        $pb = DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[65,66,67,68,69,70,71,72,73,74,75,87])
            ->where('exercice',$exercice)
            ->first();

        if (!$pb): $pb = 0 ; else: $pb = (int)$pb->total; endif;
        return $pb;
    }
    /* 2. Charge Bancaire */
    public static function cb($entreprise, $exercice,$bd){
        $cb = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[43,44,45,46,47,48,49,50,51,52,86])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        if (!$cb): $cb = 0 ; else: $cb = (int)$cb->total; endif;
        return $cb;

    }
    public static function cbPays($exercice,$bd){
        $cb = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[43,44,45,46,47,48,49,50,51,52,86])
                ->where('exercice',$exercice)
                ->first();
        if (!$cb): $cb = 0 ; else: $cb = (int)$cb->total; endif;
        return $cb;

    }
    public static function cbUEMOA($exercice){
        $cb = DB::connection('sensyyg2_umeoabd')
                ->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[43,44,45,46,47,48,49,50,51,52,86])
                ->where('exercice',$exercice)
                ->first();
        if (!$cb): $cb = 0 ; else: $cb = (int)$cb->total; endif;
        return $cb;

    }
    /* 3. Produit Net Bancaire (1-2) */
    public static function pnb($entreprise, $exercice,$bd){
    
        return (GetRatiosHelpers::pb($entreprise, $exercice,$bd) - GetRatiosHelpers::cb($entreprise, $exercice,$bd));
    }
    public static function pnbPays($exercice,$bd){
    
        return (GetRatiosHelpers::pbPays($exercice,$bd) - GetRatiosHelpers::cbPays($exercice,$bd));
    }
    public static function pnbUEMOA($exercice){
    
        return (GetRatiosHelpers::pbUEMOA($exercice) - GetRatiosHelpers::cbUEMOA($exercice));
    }
    /* 4. Produits Accessoires Net */
    public static function pan($entreprise, $exercice,$bd){
        $op1 = DB::connection($bd)
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[76,77,78,79])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection($bd)
                ->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[53,54,55])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function panPays($exercice,$bd){
        $op1 = DB::connection($bd)
                ->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[76,77,78,79])
                ->where('exercice',$exercice)
                ->first();

        $op2 = DB::connection($bd)
                ->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[53,54,55])
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function panUEMOA($exercice){
        $op1 = DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[76,77,78,79])
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection('sensyyg2_umeoabd')
                ->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[53,54,55])
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    /* 5. Produit Global D'exploitation (3+4) */
    public static function pge($entreprise, $exercice,$bd){
    
        return (GetRatiosHelpers::pan($entreprise, $exercice,$bd)+ GetRatiosHelpers::pnb($entreprise, $exercice,$bd));
    }
    public static function pgePays($exercice,$bd){
    
        return (GetRatiosHelpers::panPays($exercice,$bd)+ GetRatiosHelpers::pnbPays($exercice,$bd));
    }
    public static function pgeUEMOA($exercice){
    
        return (GetRatiosHelpers::panUEMOA($exercice)+ GetRatiosHelpers::pnbUEMOA($exercice));
    }
    /* 6. Frais Generaux */
    public static function fg($entreprise, $exercice,$bd){
        $fg = DB::connection($bd)
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[56,57])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        if (!$fg): $fg = 0 ; else: $fg = (int)$fg->total; endif;
        return $fg;
    }
   public static function fgPays($exercice,$bd){
        $fg = DB::connection($bd)
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[56,57])
            ->where('exercice',$exercice)
            ->first();

        if (!$fg): $fg = 0 ; else: $fg = (int)$fg->total; endif;
        return $fg;
    }
   public static function fgUEMOA($exercice){
        $fg = DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[56,57])
            ->where('exercice',$exercice)
            ->first();

        if (!$fg): $fg = 0 ; else: $fg = (int)$fg->total; endif;
        return $fg;
    }
    /* 7. Amortissement et Provision Net Sur Immobilisation */
    public static function api($entreprise, $exercice,$bd){
        $api = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[58,80])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        if (!$api): $api = 0 ; else: $api = (int)$api->total; endif;
        return $api;
    }
    public static function apiPays($exercice,$bd){
        $api = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[58,80])
            ->where('exercice',$exercice)
            ->first();

        if (!$api): $api = 0 ; else: $api = (int)$api->total; endif;
        return $api;
    }
    public static function apiUEMOA($exercice){
        $api = DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[58,80])
            ->where('exercice',$exercice)
            ->first();

        if (!$api): $api = 0 ; else: $api = (int)$api->total; endif;
        return $api;
    }
    /* 8. Resultat Brut D'exploitation apres amortissement */
    public static function rbeaamor($entreprise, $exercice,$bd){
        return (GetRatiosHelpers::pge($entreprise, $exercice,$bd)- GetRatiosHelpers::fg($entreprise, $exercice,$bd)- GetRatiosHelpers::api($entreprise, $exercice,$bd));
    }
    public static function rbeaamorPays($exercice,$bd){
        return (GetRatiosHelpers::pgePays($exercice,$bd)- GetRatiosHelpers::fgPays($exercice,$bd)- GetRatiosHelpers::apiPays($exercice,$bd));
    }
    public static function rbeaamorUEMOA($exercice){
        return (GetRatiosHelpers::pgeUEMOA($exercice)- GetRatiosHelpers::fgUEMOA($exercice)- GetRatiosHelpers::apiUEMOA($exercice));
    }
    /* 9. Provision Net Sur Risque */
    public static function pnr($entreprise, $exercice,$bd){
        $op1 = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[81,82])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[59,60])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op2 - $op1);
    }
    public static function pnrPays($exercice,$bd){
        $op1 = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[81,82])
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[59,60])
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op2 - $op1);
    }
    public static function pnrUEMOA($exercice){
        $op1 = DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[81,82])
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection('sensyyg2_umeoabd')
                ->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[59,60])
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op2 - $op1);
    }
    /* 10. Interet sur creance douteuse */
    public static function icdl($entreprise, $exercice,$bd){
        return '0';
    }
    public static function icdlPays($exercice,$bd){
        return '0';
    }
    public static function icdlUEMOA($exercice){
        return '0';
    }
    /* 11. Resultat D'exploitation (8-9+10) */
    public static function re($entreprise, $exercice,$bd){
        return (GetRatiosHelpers::rbeaamor($entreprise, $exercice,$bd)- GetRatiosHelpers::pnr($entreprise, $exercice,$bd));
    }
    public static function rePays($exercice,$bd){
        return (GetRatiosHelpers::rbeaamorPays($exercice,$bd)- GetRatiosHelpers::pnrPays($exercice,$bd));
    }
    public static function reUEMOA($exercice){
        return (GetRatiosHelpers::rbeaamorUEMOA($exercice)- GetRatiosHelpers::pnrUEMOA($exercice));
    }
    /* 12. Resultat Exceptionel Net */
    public static function ren($entreprise,$exercice,$bd){
        $op1 = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[83])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[61])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function renPays($exercice,$bd){
        $op1 = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[83])
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[61])
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function renUEMOA($exercice){
        $op1 = DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[83])
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection('sensyyg2_umeoabd')
                ->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[61])
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    /* 13. Resultat sur exercice Anterieur */
    public static function rea($entreprise,$exercice,$bd){
        $op1 = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[84])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[62])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function reaPays($exercice,$bd){
        $op1 = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[84])
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[62])
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function reaUEMOA($exercice){
        $op1 = DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[84])
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection('sensyyg2_umeoabd')
                ->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[62])
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    /* 14. Impot sur le benefice */
    public static function ib($entreprise, $exercice,$bd){
        $api = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->where('idRubrique',63)
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        if (!$api): $api = 0 ; else: $api = (int)$api->total; endif;
        return $api;
    }
     public static function ibPays($exercice,$bd){
        $api = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->where('idRubrique',63)
            ->where('exercice',$exercice)
            ->first();

        if (!$api): $api = 0 ; else: $api = (int)$api->total; endif;
        return $api;
    }
     public static function ibUEMOA($exercice){
        $api = DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->where('idRubrique',63)
            ->where('exercice',$exercice)
            ->first();

        if (!$api): $api = 0 ; else: $api = (int)$api->total; endif;
        return $api;
    }
    /* 15. Resultat net */
    public static function res($entreprise, $exercice,$bd){
        $op1 = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->where('idRubrique',64)
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->where('idRubrique',85)
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function resPays($exercice,$bd){
        $op1 = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->where('idRubrique',64)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->where('idRubrique',85)
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function resUEMOA($exercice){
        $op1 = DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->where('idRubrique',64)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::connection('sensyyg2_umeoabd')
                ->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->where('idRubrique',85)
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    /*
    * Ratio du Cout des Comptes Rénuméré ccr: (Intérêts et charges assimilées sur dettes à l\'égard de la clientèle / 
                (Compte Rémunéré A1 - Compte Rémunéré A-1)/2)*100
    */
    public static function ccr($entreprise, $exercice, $bd){
        $numer = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',44)
        ->where('idEntreprise',$entreprise)
        ->where('exercice',$exercice)
        ->first();
        /* Compte rénuméré */
        $op1 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[24,25,27])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        $op2 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[24,25,27])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice-1)
                ->first();
        if (!$op1)  $op1 = 0 ;  else    $op1 = $op1->total;
        if (!$op2)  $op2 = 0 ;  else    $op2 = $op2->total;
        
        $denom = ($op2 + $op1)/2;

        if (!$numer || $numer->total == 0 || $denom == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom)*100,2);
    }
    public static function ccrPays($exercice, $bd){
        $numer = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',44)
        ->where('exercice',$exercice)
        ->first();

        /* Compte rénuméré */
        $op1 = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->whereIn('idRubrique',[24,25,27])
        ->where('exercice',$exercice)
        ->first();

        $op2 = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->whereIn('idRubrique',[24,25,27])
        ->where('exercice',$exercice-1)
        ->first();

        if (!$op1)  $op1 = 0 ;  else        $op1 = $op1->total;
        if (!$op2)  $op2 = 0 ;  else        $op2 = $op2->total;
        
        $denom = ($op2 + $op1)/2;

        if (!$numer || $numer->total == 0 || $denom == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom)*100,2);
    }
    public static function ccrUEMOA($exercice){
        $numer = DB::connection('sensyyg2_umeoabd')->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',44)
        ->where('exercice',$exercice)
        ->first();
        /* Compte rénuméré */
        $op1 = DB::connection('sensyyg2_umeoabd')->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->whereIn('idRubrique',[24,25,27])
        ->where('exercice',$exercice)
        ->first();

        $op2 = DB::connection('sensyyg2_umeoabd')->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->whereIn('idRubrique',[24,25,27])
        ->where('exercice',$exercice-1)
        ->first();

        if (!$op1)  $op1 = 0 ;  else        $op1 = $op1->total;
        if (!$op2)  $op2 = 0 ;  else        $op2 = $op2->total;
        
        $denom = ($op2 + $op1)/2;

        if (!$numer || $numer->total == 0 || $denom == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom)*100,2);
    }
    /*
    * Cout des Comptes Créditeur ccr: (Intérêts et charges assimilées sur dettes à l\'égard de la clientèle / 
                (Dette a l'egard de la clientel A1 - Dette a l'agard de la clientel A-1)/2)*100
    */
    public static function ccc($entreprise, $exercice, $bd){
        $numer = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',44)
        ->where('idEntreprise',$entreprise)
        ->where('exercice',$exercice)
        ->first();

        /* Dette a l'agard de la clientel */
        $op1 = GetRatiosHelpers::Operation_clientel_passif($entreprise,$exercice,$bd);
        $op2 = GetRatiosHelpers::Operation_clientel_passif($entreprise,$exercice-1,$bd);
        if (!$op1)  $op1 = 0 ;  else    $op1 = $op1->total;
        if (!$op2)  $op2 = 0 ;  else    $op2 = $op2->total;
        
        $denom = ($op2 + $op1)/2;

        if (!$numer || $numer->total == 0 || $denom == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom)*100,2);
    }
    public static function cccPays($exercice, $bd){
        $numer = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',44)
        ->where('exercice',$exercice)
        ->first();

        $op1 = GetRatiosHelpers::Operation_clientel_passifPays($exercice,$bd);
        $op2 = GetRatiosHelpers::Operation_clientel_passifPays($exercice-1,$bd);
        

        if (!$op1)  $op1 = 0 ;  else        $op1 = $op1->total;
        if (!$op2)  $op2 = 0 ;  else        $op2 = $op2->total;
        
        $denom = ($op2 + $op1)/2;

        if (!$numer || $numer->total == 0 || $denom == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom)*100,2);
    }
    public static function cccUEMOA($exercice){
        $numer = DB::connection('sensyyg2_umeoabd')->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',44)
        ->where('exercice',$exercice)
        ->first();
        $op1 = GetRatiosHelpers::Operation_clientel_passifUEMOA($exercice);
        $op2 = GetRatiosHelpers::Operation_clientel_passifUEMOA($exercice-1);

        if (!$op1)  $op1 = 0 ;  else        $op1 = $op1->total;
        if (!$op2)  $op2 = 0 ;  else        $op2 = $op2->total;
        
        $denom = ($op2 + $op1)/2;

        if (!$numer || $numer->total == 0 || $denom == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom)*100,2);
    }

    /*
    * Ratio 1 cc: (Intérêts et produits assimilé sur creance sur la clientèle / 
                (Creance sur la clientele A1 + Creance sur la clientele A-1)/2)*100
    */

    // Operetion clientel Actif
    public static function Operation_clientel_actif($entreprise,$exercice,$bd){
        return DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[6,7,8,9,10,11])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
    }
     public static function Operation_clientel_actifPays($exercice,$bd){
        return DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[6,7,8,9,10,11])
                ->where('exercice',$exercice)
                ->first();
    }
     public static function Operation_clientel_actifUEMOA($exercice){
        return DB::connection('sensyyg2_umeoabd')->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[6,7,8,9,10,11])
                ->where('exercice',$exercice)
                ->first();
    }
    // Operation clientel Passif
    public static function Operation_clientel_passif($entreprise,$exercice,$bd){
        return DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[23,24,25,26,27])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
    }
     public static function Operation_clientel_passifPays($exercice,$bd){
        return DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[23,24,25,26,27])
                ->where('exercice',$exercice)
                ->first();
    }
     public static function Operation_clientel_passifUEMOA($exercice){
        return DB::connection('sensyyg2_umeoabd')->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[23,24,25,26,27])
                ->where('exercice',$exercice)
                ->first();
        
    }
    // Operetion clientel Actif
    public static function Operation_tresorerie_actif($entreprise,$exercice,$bd){
        return DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[2,3,4,5])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
    }
     public static function Operation_tresorerie_actifPays($exercice,$bd){
        return DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[2,3,4,5])
                ->where('exercice',$exercice)
                ->first();
    }
     public static function Operation_tresorerie_actifUEMOA($exercice){
        return DB::connection('sensyyg2_umeoabd')->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[2,3,4,5])
                ->where('exercice',$exercice)
                ->first();
    }
    // Operation clientel Passif
    public static function Operation_tresorerie_passif($entreprise,$exercice,$bd){
        return DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[20,21,22])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
    }
     public static function Operation_tresorerie_passifPays($exercice,$bd){
        return DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[20,21,22])
                ->where('exercice',$exercice)
                ->first();
    }
     public static function Operation_tresorerie_passifUEMOA($exercice){
        return DB::connection('sensyyg2_umeoabd')->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[20,21,22])
                ->where('exercice',$exercice)
                ->first();
        
    }
    public static function cc($entreprise, $exercice, $bd){
        $numer = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',66)
        ->where('idEntreprise',$entreprise)
        ->where('exercice',$exercice)
        ->first();

        /* Creance sur la clientele */
        $op1 = GetRatiosHelpers::Operation_clientel_actif($entreprise,$exercice,$bd);
        $op2 = GetRatiosHelpers::Operation_clientel_actif($entreprise,$exercice-1,$bd);
        if (!$op1)  $op1 = 0 ;  else    $op1 = $op1->total;
        if (!$op2)  $op2 = 0 ;  else    $op2 = $op2->total;
        
        $denom = ($op2 + $op1)/2;

        if (!$numer || $numer->total == 0 || $denom == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom)*100,2);
    }
    public static function ccPays($exercice, $bd){
        $numer = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',66)
        ->where('exercice',$exercice)
        ->first();

        $op1 = GetRatiosHelpers::Operation_clientel_actifPays($exercice,$bd);
        $op2 = GetRatiosHelpers::Operation_clientel_actifPays($exercice-1,$bd);

        if (!$op1)  $op1 = 0 ;  else        $op1 = $op1->total;
        if (!$op2)  $op2 = 0 ;  else        $op2 = $op2->total;
        
        $denom = ($op2 + $op1)/2;

        if (!$numer || $numer->total == 0 || $denom == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom)*100,2);
    }
    public static function ccUEMOA($exercice){
        $numer = DB::connection('sensyyg2_umeoabd')->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',66)
        ->where('exercice',$exercice)
        ->first();

        $op1 = GetRatiosHelpers::Operation_clientel_actifUEMOA($exercice);
        $op2 = GetRatiosHelpers::Operation_clientel_actifUEMOA($exercice-1);
        
        if (!$op1)  $op1 = 0 ;  else        $op1 = $op1->total;
        if (!$op2)  $op2 = 0 ;  else        $op2 = $op2->total;
        
        $denom = ($op2 + $op1)/2;

        if (!$numer || $numer->total == 0 || $denom == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom)*100,2);
    }
    /*
    * Fonds Propre : Somme rubrique 34 à 42 (Subvention D'esploitation à Resultat de L'exercice)
    */
    public static function fondPropre($entreprise, $exercice,$bd){

        return DB::connection($bd)->table("lignebilan")
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[34,35,36,37,38,39,40,41,42])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();
    }
    public static function fondProprePays($exercice,$bd){

        return DB::connection($bd)->table("lignebilan")
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[34,35,36,37,38,39,40,41,42])
            ->where('exercice',$exercice)
            ->first();
    }
    public static function fondPropreUEMOA($exercice){

        return DB::connection('sensyyg2_umeoabd')->table("lignebilan")
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[34,35,36,37,38,39,40,41,42])
            ->where('exercice',$exercice)
            ->first();
    }
    // Total bilan
    public static function totalBilan($entreprise,$exercice,$bd){
        return DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total ')
            ->join('rubrique','rubrique.idRubrique','=','lignebilan.idRubrique')
            ->join('sousclasse','sousclasse.idSousclasse','=','rubrique.idSousclasse')
            ->join('classe','classe.idClasse','=','sousclasse.idClasse')
            ->where('nature','actif')
            ->where('exercice',$exercice)
            ->where('idEntreprise',$entreprise)
            ->first();
    }
    public static function totalBilanPays($exercice,$bd){
        return DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total ')
                ->join('rubrique','rubrique.idRubrique','=','lignebilan.idRubrique')
                ->join('sousclasse','sousclasse.idSousclasse','=','rubrique.idSousclasse')
                ->join('classe','classe.idClasse','=','sousclasse.idClasse')
                ->where('nature','actif')
                ->where('exercice',$exercice)
                ->first();
    }
    public static function totalBilanUEMOA($exercice){
        return DB::connection('sensyyg2_umeoabd')
                ->table('lignebilan')
                ->selectRaw('SUM(brut) as total ')
                ->join('rubrique','rubrique.idRubrique','=','lignebilan.idRubrique')
                ->join('sousclasse','sousclasse.idSousclasse','=','rubrique.idSousclasse')
                ->join('classe','classe.idClasse','=','sousclasse.idClasse')
                ->where('nature','actif')
                ->where('exercice',$exercice)
                ->first();
    }

    /** ROA : Return On Asset : Rentabilité des actifs *  Resultat net / Total Bilan **/
    public static function roa($entreprise, $exercice,$bd){
        
        $denom = GetRatiosHelpers::totalBilan($entreprise,$exercice,$bd);
        /* Resultat Net */
        $numer = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total ')
            ->where('idRubrique',42)
            ->where('exercice',$exercice)
            ->where('idEntreprise',$entreprise)
            ->first();
        if (!$denom || !$numer || $numer->total == 0 || $denom->total == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom->total)*100,2);
    }
    public static function roaPays($exercice,$bd){
            $denom = GetRatiosHelpers::totalBilanPays($exercice,$bd);
            $numer = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total ')
                ->where('idRubrique',42)
                ->where('exercice',$exercice)
                ->first();
        if (!$denom || !$numer || $numer->total == 0 || $denom->total == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom->total)*100,2);
        }
        public static function roaUEMOA($exercice){
            $denom = GetRatiosHelpers::totalBilanUEMOA($exercice);
            $numer = DB::connection('sensyyg2_umeoabd')
                ->table('lignebilan')
                ->selectRaw('SUM(brut) as total ')
                ->where('idRubrique',42)
                ->where('exercice',$exercice)
                ->first();
            if (!$denom || !$numer || $numer->total == 0 || $denom->total == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom->total)*100,2);
        }
    /*
     * ROE : Return On Equity : Rentabilité des capitaux propres ou Coeficient de rentabilité
     *
     *                  Resultat net / Fonds Propres
     */
    public static function roe($entreprise, $exercice,$bd){
        $denom = GetRatiosHelpers::fondPropre($entreprise,$exercice,$bd);

        $numer = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->where('idRubrique',42)
            ->where('exercice',$exercice)
            ->where('idEntreprise',$entreprise)
            ->first();

        if (!$denom || !$numer || $numer->total == 0 || $denom->total == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom->total)*100,2);
    }
    public static function roePays($exercice,$bd){
        $denom = GetRatiosHelpers::fondProprePays($exercice,$bd);

        $numer = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total ')
            ->where('idRubrique',42)
            ->where('exercice',$exercice)
            ->first();

        if (!$denom || !$numer || $numer->total == 0 || $denom->total == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom->total)*100,2);
    }
    public static function roeUEMOA($exercice){
        $denom = GetRatiosHelpers::fondPropreUEMOA($exercice);

        $numer = DB::connection('sensyyg2_umeoabd')
            ->table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->where('idRubrique',42)
            ->where('exercice',$exercice)
            ->first();
        if (!$denom || !$numer || $numer->total == 0 || $denom->total == 0):
            return 0.0;
        endif;
        return round(($numer->total / $denom->total)*100,2);
    }
}
