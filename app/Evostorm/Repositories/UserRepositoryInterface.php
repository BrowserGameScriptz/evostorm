<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 2018-07-27
 * Time: 21:15
 */

namespace App\Evostorm\Repositories;


interface UserRepositoryInterface
{
    public function create(array $data);
}