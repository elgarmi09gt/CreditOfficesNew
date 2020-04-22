<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $codeSousecteur
 * @property string $sousecteur
 * @property string $prodService
 * @property integer $idSecteur
 * @property string $created_at
 * @property string $updated_at
 * @property Secteur $secteur
 * @property Ligneservice[] $ligneservices
 * @property Service[] $services
 */
class Soussecteur extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['codeSousecteur', 'sousecteur', 'prodService', 'idSecteur', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secteur()
    {
        return $this->belongsTo('App\Models\Secteur', 'idSecteur');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ligneservices()
    {
        return $this->hasMany('App\Models\Ligneservice', 'idSousect');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany('App\Models\Service', 'idSousecteur');
    }
}
