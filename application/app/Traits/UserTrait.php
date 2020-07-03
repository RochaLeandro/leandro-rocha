<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

trait UserTrait
{
    public function scoutUsers(Request $request)
    {
        $users = app(UserRepository::class)
                    ->whereHas('accesses', function ($accesses) use ($request) {
                        if ($request->has('login')) {
                            $dates = explode(' até ', $request->get('login'));

                            $from = date($dates[0] . ' ' . '00:00:00');
                            $to = date(end($dates) . ' ' . '23:59:59');

                            $accesses = $accesses->whereBetween('last_login', [$from, $to]);
                        }

                        return $accesses;
                    })
                    ->withCount('accesses')->orderBy(
                        (
                            $request->has('sort_property') ? 
                            $request->get('sort_property') : 'name'
                        ), (
                            $request->has('sort_direction') ? 
                            $request->get('sort_direction') : 'asc'
                        )
                    )
                    ->paginate($request->get('limit'))          
                ;

        return $users;
    }
}