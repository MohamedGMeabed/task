<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function index()
    {
        $users = $this->userInterface->index();
        return view( 'home', compact('users'));
    }
}
