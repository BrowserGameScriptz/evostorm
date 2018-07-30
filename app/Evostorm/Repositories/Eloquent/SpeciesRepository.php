<?php

namespace App\Evostorm\Repositories\Eloquent;


use App\Evostorm\Models\Species;
use App\Evostorm\Repositories\SpeciesRepositoryInterface;

class SpeciesRepository extends AbstractRepository implements SpeciesRepositoryInterface
{
    public function __construct(Species $model)
    {
        $this->model = $model;
    }
}