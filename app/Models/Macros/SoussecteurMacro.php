<?php

namespace App\Models\Macros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $codeSouSecteur
 * @property string $sousecteur
 * @property integer $idSecteur
 * @property string $created_at
 * @property string $updated_at
 * @property SecteurMacro $secteurMacro
 * @property MacroAgregat[] $macroAgregats
 */
class SoussecteurMacro extends Model
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
    protected $fillable = ['codeSouSecteur', 'sousecteur', 'idSecteur', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secteurMacro()
    {
        return $this->belongsTo('App\Models\Macros\SecteurMacro', 'idSecteur');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function macroAgregats()
    {
        return $this->hasMany('App\Models\Macros\MacroAgregat', 'idSousecteur');
    }
}
