<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    private $authSvc;

    /**
     * AuthController constructor.
     * @param AuthService $authSvc
     */
    public function __construct(AuthService $authSvc)
    {
        $this->authSvc = $authSvc;
    }

    public function login(): Response
    {
        return Inertia::render('Auth/Login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $login = $this->authSvc->userLogin($request->all());

        if ($login) {
            return redirect(route('admin.index'));
        }

        return back()->withErrors(['email' => 'In-correct Email / Password!']);
    }

    public function register(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'unique:users|required',
            'password'  => 'required',
        ]);

        $register = $this->authSvc->registerUser($request->all());

        if ($register) {
            return redirect(route('login.index'));
        }

        return back()->with('error', 'In-correct Data!');
    }

    public function logout(): RedirectResponse
    {
        $this->authSvc->logout();

        return back();
    }
}
