<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(protected ProfileService $service)
    {
    }

    public function show(User $user)
    {
        return view('profile.show');
    }

    public function edit(User $user)
    {
        dd(5);
        // return view('profile.show');
    }


    public function update(Request $request, User $user)
    {
        dd('user');
    }
}
