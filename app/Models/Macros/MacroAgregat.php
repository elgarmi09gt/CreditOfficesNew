<?php

namespace App\Models\Macros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $codeMacro
 * @property string $macro
 * @property integer $idSousecteur
 * @property string $unite_mesure
 * @property string $magnitude
 * @property string $created_at
 * @property string $updated_at
 * @property SoussecteurMacro $soussecteurMacro
 * @property Lignemacro[] $lignemacros
 */
class MacroAgregat extends Model
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
    protected $fillable = ['codeMacro', 'macro', 'idSousecteur', 'unite_mesure', 'magnitude', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function soussecteurMacro()
    {
        return $this->belongsTo('App\Models\Macros\SoussecteurMacro', 'idSousecteur');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lignemacros()
    {
        return $this->hasMany('App\Models\Macros\Lignemacro', 'idMacro');
    }
}
