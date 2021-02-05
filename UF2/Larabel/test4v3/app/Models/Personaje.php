<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Personaje
 * @package App\Models
 * @version February 5, 2021, 3:39 pm UTC
 *
 * @property string $nom
 * @property string $especie
 */
class Personaje extends Model
{
    //use SoftDeletes;

    use HasFactory;

    public $table = 'personajes';
    public $timestamps = false;
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'nom',
        'especie'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nom' => 'string',
        'especie' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nom' => 'required|string|max:80',
        'especie' => 'required|string|max:80'
    ];

    
}
