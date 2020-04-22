<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $codeSousclasse
 * @property string $sousclasse
 * @property integer $idClasse
 * @property string $created_at
 * @property string $updated_at
 * @property Class $class
 * @property Rubrique[] $rubriques
 */
class Sousclasse extends Model
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
    protected $fillable = ['codeSousclasse', 'sousclasse', 'idClasse', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function class()
    {
        return $this->belongsTo('App\Models\Class', 'idClasse');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rubriques()
    {
        return $this->hasMany('App\Models\Rubrique', 'idSousclasse');
    }
}
