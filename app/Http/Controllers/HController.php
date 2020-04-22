<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\LigneBilan;
use App\Models\Pays;
use App\Models\Rubrique;
use App\Models\Secteur;
use App\Models\Service;
use App\Models\Sousclasse;
use App\Models\Soussecteur;
use App\Models\Sousservice;
use App\Models\SupClasse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HController extends Controller
{
    function index(Request $request)
    {
        if (!$request->pays)
            $pays = 201;
        else
            $pays = $request->pays;
        /*$BD = [
            ['bd' => 'bic_beninbd', 'coef' => 0.98],
            ['bd' => 'bic_bissaubd', 'coef' => 0.6],
            ['bd' => 'bic_burkinabd', 'coef' => 0.87
            ['bd' => 'bic_coteivoirbd',  'coef' => 2.4
            ['bd' => 'bic_malibd',  'coef' => 1.6
            ['bd' => 'bic_nigerbd',  'coef' => 1.04
            ['bd' => 'bic_senegalbd',  'coef' => 1
            ['bd' => 'bic_togobd', 'coef' => 0.77
        ];
        $dbs = "bic_senegalbd";
        $blns = DB::connection($dbs)->table('lignebilans')->where('idEntreprise','>',36)->get();
        foreach ($BD as $bd):
            foreach ($blns as $bln):
                DB::connection($bd['bd'])->table('lignebilans')->updateOrInsert([
                    'idRubrique' => $bln->idRubrique,
                    'idEntreprise' => $bln->idEntreprise,
                    'exercice' => $bln->exercice,
                    'brute' => $bln->brute*$bd['coef'],
                    'provision' => $bln->provision
                ]);
            endforeach;
        endforeach;*/
        /*$flight = App\Flight::updateOrCreate(
            ['departure' => 'Oakland', 'destination' => 'San Diego'],
            ['price' => 99, 'discounted' => 1]
        );*/
        /*$ps = Pays::on($dbs)->cursor()->all();
        $sclasses = SupClasse::on($dbs)->cursor()->all();
        $classes = Classe::on($dbs)->cursor()->all();
        $sousclasses = Sousclasse::on($dbs)->cursor()->all();
        $rubriques = Rubrique::on($dbs)->cursor()->all();
        $secteurs = Secteur::on($dbs)->cursor()->all();
        $ssecteurs = Soussecteur::on($dbs)->cursor()->all();
        $services = Service::on($dbs)->cursor()->all();
        $sservices = Sousservice::on($dbs)->cursor()->all();
        for ($i = 0; $i < count($BD); $i++):
            foreach ($ps as $p):
                Pays::on($BD[$i])->updateOrCreate([
                    'id' => $p->id,'codePays' => $p->codePays,'pays' => $p->pays, 'ohada' => $p->ohada,
                    'cedeao' => $p->cedeao,'bdPays' => $p->bdPays
                ]);
            endforeach;
            foreach ($sclasses as $sclasse):
                SupClasse::on($BD[$i])->updateOrCreate([
                    'id' => $sclasse->id,'supClasse' => $sclasse->supClasse ]);
            endforeach;
            foreach ($classes as $p):
                Classe::on($BD[$i])->updateOrCreate([
                    'id' => $p->id, 'codeClasse' => $p->codeClasse, 'classe' => $p->classe, 'nature' => $p->nature,
                    'systemeClasse' => $p->systemeClasse,'typeClasse' => $p->typeClasse,'idSupclasse' => $p->idSupclasse
                ]);
            endforeach;
            foreach ($sousclasses as $p):
                Sousclasse::on($BD[$i])->updateOrCreate([
                    'id' => $p->id,'codeSousclasse' => $p->codeSousclasse, 'sousclasse' => $p->sousclasse,
                    'idClasse' => $p->idClasse
                ]);
            endforeach;
            foreach ($rubriques as $p):
                Rubrique::on($BD[$i])->updateOrCreate([
                    'id' => $p->id,'codeRubrique' => $p->codeRubrique,
                    'rubrique' => $p->rubrique, 'idSousclasse' => $p->idSousclasse
                ]);
            endforeach;
            foreach ($secteurs as $p):
                Secteur::on($BD[$i])->updateOrCreate([
                    'id' => $p->id,'codeSecteur' => $p->codeSecteur,
                    'secteur' => $p->secteur, 'prodService' => $p->prodService,
                    'typeProdService' => $p->typeProdService
                ]);
            endforeach;
            foreach ($ssecteurs as $p):
                Soussecteur::on($BD[$i])->updateOrCreate([
                    'id' => $p->id,'codeSousecteur' => $p->codeSousecteur,
                    'sousecteur' => $p->sousecteur, 'prodService' => $p->prodService
                    , 'idSecteur' => $p->idSecteur
                ]);
            endforeach;
            foreach ($services as $p):
                Service::on($BD[$i])->updateOrCreate([
                    'id' => $p->id,'codeService' => $p->codeService,
                    'service' => $p->service, 'idSousecteur' => $p->idSousecteur
                ]);
            endforeach;
            foreach ($sservices as $p):
                Sousservice::on($BD[$i])->updateOrCreate([
                    'id' => $p->id,'codeSouservice' => $p->codeSouservice,
                    'souservice' => $p->souservice, 'idService' => $p->idService
                ]);
            endforeach;
        endfor;*/
        return view('welcome', ['pays' => $pays]);
    }
}
