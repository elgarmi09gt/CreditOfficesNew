<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $codeService
 * @property string $service
 * @property integer $idSousecteur
 * @property string $created_at
 * @property string $updated_at
 * @property Soussecteur $soussecteur
 * @property Ligneservice[] $ligneservices
 * @property Sousservice[] $sousservices
 */
class Service extends Model
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
    protected $fillable = ['codeService', 'service', 'idSousecteur', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function soussecteur()
    {
        return $this->belongsTo('App\Models\Soussecteur', 'idSousecteur');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ligneservices()
    {
        return $this->hasMany('App\Models\Ligneservice', 'idService');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sousservices()
    {
        return $this->hasMany('App\Models\Sousservice', 'idService');
    }
}
