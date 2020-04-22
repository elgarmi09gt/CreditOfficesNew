<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $codeRubrique
 * @property string $rubrique
 * @property integer $idSousclasse
 * @property string $created_at
 * @property string $updated_at
 * @property Sousclass $sousclass
 * @property Lignebilan[] $lignebilans
 */
class Rubrique extends Model
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
    protected $fillable = ['codeRubrique', 'rubrique', 'idSousclasse', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sousclass()
    {
        return $this->belongsTo('App\Models\Sousclass', 'idSousclasse');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lignebilans()
    {
        return $this->hasMany('App\Models\Lignebilan', 'idRubrique');
    }
}
