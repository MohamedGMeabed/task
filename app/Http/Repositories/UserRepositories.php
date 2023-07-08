<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AuthInterface;
use App\Http\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepositories implements UserInterface
{
    public function index()
    {
        $users = User::orderByRaw('name asc, created_at asc')->get();
        return $users;
    }
}
