<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $codePays
 * @property string $pays
 * @property string $ohada
 * @property string $cedeao
 * @property string $bdPays
 * @property string $created_at
 * @property string $updated_at
 * @property Entreprise[] $entreprises
 */
class Pays extends Model
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
    protected $fillable = ['codePays', 'pays', 'ohada', 'cedeao', 'bdPays', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entreprises()
    {
        return $this->hasMany('App\Models\Entreprise', 'idPays');
    }
}
