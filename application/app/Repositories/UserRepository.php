<?php

namespace App\Repositories;

use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class UserRepository extends BaseRepository {
    protected $fieldSearchable = [
        'name'  => 'like',
        'email' => 'like'
    ];

    public function boot()
	{
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return User::class;
    }
}