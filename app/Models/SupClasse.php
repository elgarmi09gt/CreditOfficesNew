<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $supClasse
 * @property string $created_at
 * @property string $updated_at
 * @property Class[] $classes
 */
class SupClasse extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'supclasses';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['supClasse', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classes()
    {
        return $this->hasMany('App\Models\Class', 'idSupclasse');
    }
}
