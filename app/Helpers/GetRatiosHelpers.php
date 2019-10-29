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

    /* 1. Produit Bancaire */
    public static function pb($entreprise, $exercice){
        $pb = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[65,66,67,68,69,70,71,72,73,74,75,87])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        if (!$pb): $pb = 0 ; else: $pb = (int)$pb->total; endif;
        return $pb;
    }
    public static function pbPays($exercice){
        $pb = DB::table('lignebilan')
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
    public static function cb($entreprise, $exercice){
        $cb = DB::table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[43,44,45,46,47,48,49,50,51,52,86])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        if (!$cb): $cb = 0 ; else: $cb = (int)$cb->total; endif;
        return $cb;

    }
    public static function cbPays($exercice){
        $cb = DB::table('lignebilan')
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
    public static function pnb($entreprise, $exercice){
    
        return (GetRatiosHelpers::pb($entreprise, $exercice) - GetRatiosHelpers::cb($entreprise, $exercice));
    }
    public static function pnbPays($exercice){
    
        return (GetRatiosHelpers::pbPays($exercice) - GetRatiosHelpers::cbPays($exercice));
    }
    public static function pnbUEMOA($exercice){
    
        return (GetRatiosHelpers::pbUEMOA($exercice) - GetRatiosHelpers::cbUEMOA($exercice));
    }
    /* 4. Produits Accessoires Net */
    public static function pan($entreprise, $exercice){
        $op1 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[76,77,78,79])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[53,54,55])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function panPays($exercice){
        $op1 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[76,77,78,79])
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::table('lignebilan')
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
    public static function pge($entreprise, $exercice){
    
        return (GetRatiosHelpers::pan($entreprise, $exercice)+ GetRatiosHelpers::pnb($entreprise, $exercice));
    }
    public static function pgePays($exercice){
    
        return (GetRatiosHelpers::panPays($exercice)+ GetRatiosHelpers::pnbPays($exercice));
    }
    public static function pgeUEMOA($exercice){
    
        return (GetRatiosHelpers::panUEMOA($exercice)+ GetRatiosHelpers::pnbUEMOA($exercice));
    }
    /* 6. Frais Generaux */
    public static function fg($entreprise, $exercice){
        $fg = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[56,57])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        if (!$fg): $fg = 0 ; else: $fg = (int)$fg->total; endif;
        return $fg;
    }
   public static function fgPays($exercice){
        $fg = DB::table('lignebilan')
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
    public static function api($entreprise, $exercice){
        $api = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[58,80])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        if (!$api): $api = 0 ; else: $api = (int)$api->total; endif;
        return $api;
    }
    public static function apiPays($exercice){
        $api = DB::table('lignebilan')
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
    public static function rbeaamor($entreprise, $exercice){
        return (GetRatiosHelpers::pge($entreprise, $exercice)- GetRatiosHelpers::fg($entreprise, $exercice)- GetRatiosHelpers::api($entreprise, $exercice));
    }
    public static function rbeaamorPays($exercice){
        return (GetRatiosHelpers::pgePays($exercice)- GetRatiosHelpers::fgPays($exercice)- GetRatiosHelpers::apiPays($exercice));
    }
    public static function rbeaamorUEMOA($exercice){
        return (GetRatiosHelpers::pgeUEMOA($exercice)- GetRatiosHelpers::fgUEMOA($exercice)- GetRatiosHelpers::apiUEMOA($exercice));
    }
    /* 9. Provision Net Sur Risque */
    public static function pnr($entreprise, $exercice){
        $op1 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[81,82])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[59,60])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function pnrPays($exercice){
        $op1 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[81,82])
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[59,60])
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
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

        return ($op1 - $op2);
    }
    /* 10. Interet sur creance douteuse */
    public static function icdl($entreprise, $exercice){
        return '0';
    }
    public static function icdlPays($exercice){
        return '0';
    }
    public static function icdlUEMOA($exercice){
        return '0';
    }
    /* 11. Resultat D'exploitation (8-9+10) */
    public static function re($entreprise, $exercice){
        return (GetRatiosHelpers::rbeaamor($entreprise, $exercice)- GetRatiosHelpers::pnr($entreprise, $exercice));
    }
    public static function rePays($exercice){
        return (GetRatiosHelpers::rbeaamorPays($exercice)- GetRatiosHelpers::pnrPays($exercice));
    }
    public static function reUEMOA($exercice){
        return (GetRatiosHelpers::rbeaamorUEMOA($exercice)- GetRatiosHelpers::pnrUEMOA($exercice));
    }
    /* 12. Resultat Exceptionel Net */
    public static function ren($entreprise,$exercice){
        $op1 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[83])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[61])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function renPays($exercice){
        $op1 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[83])
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::table('lignebilan')
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
    public static function rea($entreprise,$exercice){
        $op1 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[84])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[62])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function reaPays($exercice){
        $op1 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[84])
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::table('lignebilan')
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
    public static function ib($entreprise, $exercice){
        $api = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->where('idRubrique',63)
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        if (!$api): $api = 0 ; else: $api = (int)$api->total; endif;
        return $api;
    }
     public static function ibPays($exercice){
        $api = DB::table('lignebilan')
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
    public static function res($entreprise, $exercice){
        $op1 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->where('idRubrique',64)
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->where('idRubrique',85)
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        if (!$op1): $op1 = 0; else: $op1 = (int) $op1->total; endif;
        if (!$op2): $op2 = 0; else: $op2 = (int) $op2->total; endif;

        return ($op1 - $op2);
    }
    public static function resPays($exercice){
        $op1 = DB::table('lignebilan')
            ->selectRaw('SUM(brut) as total')
            ->where('idRubrique',64)
            ->where('exercice',$exercice)
            ->first();

        $op2 = DB::table('lignebilan')
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
        $op1 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[23,24,25,26,27])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        $op2 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[23,24,25,26,27])
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
    public static function cccPays($exercice, $bd){
        $numer = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',44)
        ->where('exercice',$exercice)
        ->first();

        /* Compte rénuméré */
        $op1 = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->whereIn('idRubrique',[23,24,25,26,27])
        ->where('exercice',$exercice)
        ->first();

        $op2 = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->whereIn('idRubrique',[23,24,25,26,27])
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
    public static function cccUEMOA($exercice){
        $numer = DB::connection('sensyyg2_umeoabd')->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',44)
        ->where('exercice',$exercice)
        ->first();
        /* Compte rénuméré */
        $op1 = DB::connection('sensyyg2_umeoabd')->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->whereIn('idRubrique',[23,24,25,26,27])
        ->where('exercice',$exercice)
        ->first();

        $op2 = DB::connection('sensyyg2_umeoabd')->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->whereIn('idRubrique',[23,24,25,26,27])
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
    * Ratio 1 cc: (Intérêts et produits assimilé sur creance sur la clientèle / 
                (Creance sur la clientele A1 + Creance sur la clientele A-1)/2)*100
    */
    public static function cc($entreprise, $exercice, $bd){
        $numer = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',66)
        ->where('idEntreprise',$entreprise)
        ->where('exercice',$exercice)
        ->first();

        /* Creance sur la clientele */
        $op1 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[6,7,8,9,10,11])
                ->where('idEntreprise',$entreprise)
                ->where('exercice',$exercice)
                ->first();
        $op2 = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total')
                ->whereIn('idRubrique',[6,7,8,9,10,11])
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
    public static function ccPays($exercice, $bd){
        $numer = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',66)
        ->where('exercice',$exercice)
        ->first();

        /* Compte rénuméré */
        $op1 = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->whereIn('idRubrique',[6,7,8,9,10,11])
        ->where('exercice',$exercice)
        ->first();

        $op2 = DB::connection($bd)->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->whereIn('idRubrique',[6,7,8,9,10,11])
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
    public static function ccUEMOA($exercice){
        $numer = DB::connection('sensyyg2_umeoabd')->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->where('idRubrique',66)
        ->where('exercice',$exercice)
        ->first();
        /* Compte rénuméré */
        $op1 = DB::connection('sensyyg2_umeoabd')->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->whereIn('idRubrique',[6,7,8,9,10,11])
        ->where('exercice',$exercice)
        ->first();

        $op2 = DB::connection('sensyyg2_umeoabd')->table('lignebilan')
        ->selectRaw('SUM(brut) as total')
        ->whereIn('idRubrique',[6,7,8,9,10,11])
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
    /*
     * ROA : Return On Asset : Rentabilité des actifs
     *
     *          Resultat net / Total Bilan
     */
    public static function roa($entreprise, $exercice,$bd){
        /* Total Bilan */
        $denom = DB::connection($bd)->table('lignebilan')
            ->selectRaw('SUM(brut) as total ')
            ->join('rubrique','rubrique.idRubrique','=','lignebilan.idRubrique')
            ->join('sousclasse','sousclasse.idSousclasse','=','rubrique.idSousclasse')
            ->join('classe','classe.idClasse','=','sousclasse.idClasse')
            ->where('nature','actif')
            ->where('exercice',$exercice)
            ->where('idEntreprise',$entreprise)
            ->first();
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
            $denom = DB::connection($bd)->table('lignebilan')
                ->selectRaw('SUM(brut) as total ')
                ->join('rubrique','rubrique.idRubrique','=','lignebilan.idRubrique')
                ->join('sousclasse','sousclasse.idSousclasse','=','rubrique.idSousclasse')
                ->join('classe','classe.idClasse','=','sousclasse.idClasse')
                ->where('nature','actif')
                ->where('exercice',$exercice)
                ->first();
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
            $denom = DB::connection('sensyyg2_umeoabd')
                ->table('lignebilan')
                ->selectRaw('SUM(brut) as total ')
                ->join('rubrique','rubrique.idRubrique','=','lignebilan.idRubrique')
                ->join('sousclasse','sousclasse.idSousclasse','=','rubrique.idSousclasse')
                ->join('classe','classe.idClasse','=','sousclasse.idClasse')
                ->where('nature','actif')
                ->where('exercice',$exercice)
                ->first();
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
     * ROE : Return On Equity : Rentabilité des capitaus propres ou Coeficient de rentabilité
     *
     *                  Resultat net / Fonds Propres
     */
    public static function roe($entreprise, $exercice,$bd){
        $denom = DB::connection($bd)->table("lignebilan")
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[34,35,36,37,38,39,40,41,42])
            ->where('idEntreprise',$entreprise)
            ->where('exercice',$exercice)
            ->first();

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
        $denom = DB::connection($bd)->table("lignebilan")
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[34,35,36,37,38,39,40,41,42])
            ->where('exercice',$exercice)
            ->first();

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
        $denom = DB::connection('sensyyg2_umeoabd')->table("lignebilan")
            ->selectRaw('SUM(brut) as total')
            ->whereIn('idRubrique',[34,35,36,37,38,39,40,41,42])
            ->where('exercice',$exercice)
            ->first();

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
