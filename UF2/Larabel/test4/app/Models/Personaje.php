<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Personaje
 * @package App\Models
 * @version February 4, 2021, 11:10 am UTC
 *
 * @property string $nombre
 * @property string $data-nacimiento
 * @property string $especie
 */
class Personaje extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'personajes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'nombre',
        'data-nacimiento',
        'especie'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nombre' => 'string',
        'data-nacimiento' => 'date',
        'especie' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required|string|max:80',
        'data-nacimiento' => 'required',
        'especie' => 'required|string|max:80'
    ];

    
}
