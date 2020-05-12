<?php

namespace App\Models\Macros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $exercice
 * @property integer $idMacro
 * @property float $brute
 * @property string $created_at
 * @property string $updated_at
 * @property MacroAgregat $macroAgregat
 */
class Lignemacro extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['brute', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function macroAgregat()
    {
        return $this->belongsTo('App\Models\Macros\MacroAgregat', 'idMacro');
    }
}
