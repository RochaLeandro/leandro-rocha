<?php

namespace App\Repositories;

use App\Models\UserAccess;
use Prettus\Repository\Eloquent\BaseRepository;

class UserAccessRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return UserAccess::class;
    }
}