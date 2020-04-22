<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idEntreprise
 * @property integer $idSouservice
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 * @property Entreprise $entreprise
 * @property Sousservice $sousservice
 */
class Ligneservice extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['type', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprise', 'idEntreprise');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sousservice()
    {
        return $this->belongsTo('App\Models\Sousservice', 'idSouservice');
    }
}
