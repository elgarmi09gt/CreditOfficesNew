<?php

namespace App\Helpers;

use App\Models\Secteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsHelpers
{
    public static function getEntrepriseNameHelper($dbs, $idPays, $idEntreprise)
    {
        return DB::connection($dbs)->table('entreprises')
            ->where('Pays', $idPays)
            ->where('id', $idEntreprise)
            ->first(['entreprise', 'sigle']);
    }

    /*
     * Number SousClasse For Classe
     */
    public static function ClassesInSupClasse($dbs, $supclasse)
    {
        return DB::connection($dbs)->table('supclasses')
            ->join('classes', 'classes.idSupclasse', '=', 'supclasses.id')
            ->where('supclasses.id', $supclasse)
            ->get(['supclasses.id', 'classes.id', 'classe', 'supClasse']);
    }

    public static function SousClassesInClasse($dbs, $classe)
    {
        return DB::connection($dbs)->table('classes')
            ->join('sousclasses', 'classes.id', '=', 'sousclasses.idClasse')
            ->where('classes.id', $classe)
            ->get(['sousclasses.id', 'sousclasses.idClasse', 'classe', 'sousclasse']);
    }

    /*
     * Number Rubrique For SousClasse
     */
    public static function RubriquesSousClasse($dbs, $sousclasses)
    {
        return DB::connection($dbs)->table('sousclasses')
            ->join('rubriques', 'sousclasses.id', '=', 'rubriques.idSousClasse')
            ->where('sousclasses.id', $sousclasses)
            ->get(['rubriques.idSousClasse', 'sousclasse', 'rubrique', 'rubriques.id']);
    }

    /*
     * Format Collection : if empty 0 Else collection->total
     */
    public static function FormatBrut($collection)
    {
        return !$collection ? 0 : (int)$collection->total;
    }

    public static function getNaturePoste($dbs, $rubriques)
    {
        return DB::connection($dbs)->table('classes')
            ->join('sousclasses', 'classes.id', 'sousclasses.idClasse')
            ->join('rubriques', 'sousclasses.id', 'rubriques.idSousClasse')
            ->where('rubriques.id', $rubriques)->first();
    }

    public static function getNatureClasse($dbs, $classes)
    {
        return DB::connection($dbs)->table('classes')
            ->where('classes.id', $classes)->first();
    }

    public static function SousSecteursInSecteur($dbs, $secteur)
    {
        return DB::connection($dbs)->table('secteurs')
            ->join('soussecteurs', 'idSecteur', '=', 'secteurs.id')
            ->where('idSecteur', '=', $secteur)
            ->get(['soussecteurs.id','idSecteur','secteur','sousecteur']);
    }

    public static function ServicesInSousSecteur($dbs, $sousecteur)
    {
        return DB::connection($dbs)->table('soussecteurs')
            ->join('services', 'idSousecteur', '=', 'soussecteurs.id')
            ->where('idSousecteur', '=', $sousecteur)
            ->get(['idSousecteur','services.id','service','sousecteur']);
    }

    public static function SousServicesInService($dbs, $service)
    {
        return DB::connection($dbs)->table('services')
            ->join('sousservices', 'idService', '=', 'services.id')
            ->where('services.id', '=', $service)
            ->get(['sousservices.id','idService','service','souservice']);
    }

    public static function EntrepriseInSector($dbs, $secteur)
    {
        return count(
            DB::connection($dbs)->table('soussecteurs')
                ->join('services', 'idSousecteur', '=', 'soussecteurs.id')
                ->join('sousservices', 'idService', '=', 'services.id')
                ->join('ligneservices', 'idSouservice', '=', 'sousservices.id')
                ->where('idSecteur', $secteur)
                ->get()
        );
    }

    public static function EntrepriseInSousSector($dbs, $soussecteur)
    {
        return count(
            DB::connection($dbs)->table('services')
                ->join('sousservices', 'idService', '=', 'services.id')
                ->join('ligneservices', 'idSouservice', '=', 'sousservices.id')
                ->where('idSousecteur', $soussecteur)
                ->get()
        );
    }

    public static function EntrepriseInService($dbs, $service)
    {
        return count(
            DB::connection($dbs)->table('sousservices')
                ->join('ligneservices', 'idSouservice', '=', 'sousservices.id')
                ->where('idService', $service)
                ->get()
        );
    }

    public static function EntrepriseInSousService($dbs, $souservice)
    {
        return count(
            DB::connection($dbs)->table('sousservices')
                ->join('ligneservices', 'idSouservice', '=', 'sousservices.id')
                ->where('idSouservice', $souservice)
                ->get()
        );
    }
}