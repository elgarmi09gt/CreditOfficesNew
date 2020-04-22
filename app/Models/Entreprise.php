<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $numRegistre
 * @property string $type
 * @property string $numEnregistre
 * @property string $entreprise
 * @property string $sigle
 * @property string $adresse
 * @property string $telephone
 * @property string $fax
 * @property string $website
 * @property string $boitePostale
 * @property string $dateCreation
 * @property integer $idPays
 * @property string $created_at
 * @property string $updated_at
 * @property Pay $pay
 * @property Ligneservice[] $ligneservices
 */
class Entreprise extends Model
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
    protected $fillable = ['numRegistre', 'type', 'numEnregistre', 'entreprise', 'sigle', 'adresse', 'telephone', 'fax', 'website', 'boitePostale', 'dateCreation', 'idPays', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pay()
    {
        return $this->belongsTo('App\Models\Pay', 'idPays');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ligneservices()
    {
        return $this->hasMany('App\Models\Ligneservice', 'idEntreprise');
    }
}
