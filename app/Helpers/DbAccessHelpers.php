<?php


namespace App\Helpers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbAccessHelpers
{
    public static function getDB(Request $request)
    {
        if ($request['pays'])
            $idPays = $request['pays'];
        else
            $idPays = 201;
        $db = DB::table('pays')->where('id', $idPays)->get('bdPays');
        foreach ($db as $d) {
            $db = $d->bdPays;
        }
        return $db;
    }
}
