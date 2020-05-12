<?php

namespace App\Models\Macros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $codeSecteur
 * @property string $secteur
 * @property string $created_at
 * @property string $updated_at
 * @property SoussecteurMacro[] $soussecteurMacros
 */
class SecteurMacro extends Model
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
    protected $fillable = ['codeSecteur', 'secteur', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function soussecteurMacros()
    {
        return $this->hasMany('App\Models\Macros\SoussecteurMacro', 'idSecteur');
    }
}
