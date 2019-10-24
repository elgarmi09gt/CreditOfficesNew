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
