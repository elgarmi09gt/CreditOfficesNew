<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $agence
 * @property string $adresse
 * @property string $codeRegion
 * @property string $region
 * @property integer $idE
 * @property integer $idPays
 * @property string $created_at
 * @property string $updated_at
 * @property Entreprise $entreprise
 * @property Entreprise $entreprises
 */
class Agence extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['agence', 'adresse', 'region', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprise', 'idE');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprises()
    {
        return $this->belongsTo('App\Models\Entreprise', 'idPays', 'idPays');
    }
}
