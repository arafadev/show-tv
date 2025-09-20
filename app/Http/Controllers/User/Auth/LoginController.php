<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\Auth\LoginService;
use App\Http\Requests\User\Auth\LoginRequest;

class LoginController extends Controller
{

    public function __construct(protected LoginService $loginService)
    {
        $this->middleware('guest')->except('logout');
    }

    public function show()
    {
        return view('user.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $result = $this->loginService->attempt($request->validated());

        if ($result['success']) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => $result['message']]);
    }

    public function logout()
    {
        $this->loginService->logout();
        return redirect('/login');
    }
}