<?php

namespace App\Repositories;

use App\Models\Personaje;
use App\Repositories\BaseRepository;

/**
 * Class PersonajeRepository
 * @package App\Repositories
 * @version February 4, 2021, 11:10 am UTC
*/

class PersonajeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre',
        'data-nacimiento',
        'especie'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Personaje::class;
    }
}
