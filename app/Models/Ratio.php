<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $ratio
 * @property string $description
 * @property string $codeRatio
 * @property string $created_at
 * @property string $updated_at
 */
class Ratio extends Model
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
    protected $fillable = ['ratio', 'description', 'codeRatio', 'created_at', 'updated_at'];

}
