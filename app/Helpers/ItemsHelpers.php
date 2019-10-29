<?php


namespace App\Helpers;


use Illuminate\Support\Facades\DB;

class ItemsHelpers
{
    /*
     * Number SousClasse For Classe
     */
    public static function ClassesInSupClasse($supclasse)
    {
        return DB::table('supClasse')
            ->join('classe', 'classe.idSupClasse', '=', 'supClasse.idSupClasse')
            ->where('supClasse.idSupClasse', $supclasse)
            ->get(['supClasse.idSupClasse', 'classe.idClasse', 'nomClasse', 'nomSupClasse']);
    }
    public static function SousClassesInClasse($classe)
    {
        return DB::table('classe')
            ->join('sousclasse', 'classe.idClasse', '=', 'sousclasse.idClasse')
            ->where('classe.idClasse', $classe)
            ->get(['sousclasse.idSousclasse', 'classe.idClasse', 'nomClasse', 'nomSousclasse']);
    }

    /*
     * Number Rubrique For SousClasse
     */
    public static function RubriquesSousClasse($sousclasse)
    {

        return DB::table('sousclasse')
            ->join('rubrique', 'sousclasse.idSousClasse', '=', 'rubrique.idSousClasse')
            ->where('sousclasse.idSousClasse', $sousclasse)
            ->get(['sousclasse.idSousclasse','nomSousclasse','nomRubrique','idRubrique']);
    }

    /*
     * Format Collection : if empty 0 Else collection->total
     */
    public static function FormatBrut($collection){
        return !$collection ? 0 :(int) $collection->total;
    }
}
