<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\Auth\RegisterService;
use App\Http\Requests\User\Auth\RegisterRequest;

class RegisterController extends Controller
{

    public function __construct(protected RegisterService $registerService)
    {
        $this->middleware('guest');
    }

    public function show()
    {
        return view('user.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->registerService->create($request->validated());
        
        auth()->login($user);
        
        return redirect('/')->with('success', 'Registration successful!');
    }
}