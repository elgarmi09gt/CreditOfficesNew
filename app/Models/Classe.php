<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $codeClasse
 * @property string $classe
 * @property string $nature
 * @property string $systemeClasse
 * @property string $typeClasse
 * @property integer $idSupclasse
 * @property string $created_at
 * @property string $updated_at
 * @property Supclass $supclass
 * @property Sousclass[] $sousclasses
 */
class Classe extends Model
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
    protected $fillable = ['codeClasse', 'classe', 'nature', 'systemeClasse', 'typeClasse', 'idSupclasse', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supclass()
    {
        return $this->belongsTo('App\Models\Supclass', 'idSupclasse');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sousclasses()
    {
        return $this->hasMany('App\Models\Sousclass', 'idClasse');
    }
}
