<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $codeSecteur
 * @property string $secteur
 * @property string $prodService
 * @property string $typeProdService
 * @property string $created_at
 * @property string $updated_at
 * @property Soussecteur[] $soussecteurs
 */
class Secteur extends Model
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
    protected $fillable = ['codeSecteur', 'secteur', 'prodService', 'typeProdService', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function soussecteurs()
    {
        return $this->hasMany('App\Models\Soussecteur', 'idSecteur');
    }
}
