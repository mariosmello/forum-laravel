<?php

namespace App\Http\Controllers;

use App\Reply;
use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{

    public function show(User $user)
    {

        return view('profiles.show')
            ->withProfileUser($user)
            ->withThreads($user->threads()->paginate(10));

    }
}
