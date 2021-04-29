<?php

namespace App\Repositories;

use App\Models\Ropa;
use App\Repositories\BaseRepository;

/**
 * Class RopaRepository
 * @package App\Repositories
 * @version March 15, 2021, 5:28 pm UTC
*/

class RopaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
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
        return Ropa::class;
    }
}
