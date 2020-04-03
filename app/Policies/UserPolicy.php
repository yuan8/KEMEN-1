<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;
use Hp;
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public static function checkAlive(){
        if(!empty(session('fokus_urusan'))){
            return 1;
        }else{
            Auth::logout();
            return 0;
        }
    }
}

