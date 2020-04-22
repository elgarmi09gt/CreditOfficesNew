<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $exercice
 * @property integer $idRubrique
 * @property integer $idEntreprise
 * @property float $brute
 * @property float $provision
 * @property string $created_at
 * @property string $updated_at
 * @property Rubrique $rubrique
 */
class Lignebilan extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['idEntreprise', 'brute', 'provision', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rubrique()
    {
        return $this->belongsTo('App\Models\Rubrique', 'idRubrique');
    }
}
