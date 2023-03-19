<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use GeneralTrait;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $users = User::all();
        if (! $users) {
            return $this->returnError('001', 'Invalid Request');
        }

        return $this->returnData('user', $users);
    }
}
