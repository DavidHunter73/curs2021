<?php

namespace App\Repositories;

use App\Models\Personaje;
use App\Repositories\BaseRepository;

/**
 * Class PersonajeRepository
 * @package App\Repositories
 * @version February 5, 2021, 2:00 pm UTC
*/

class PersonajeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nom',
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
