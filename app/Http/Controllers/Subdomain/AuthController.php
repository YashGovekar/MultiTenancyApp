<?php

namespace App\Http\Controllers\Subdomain;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return Inertia::render('Subdomain/Auth/Login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $login = $this->authSvc->customerLogin($request->all());

        if ($login) {
            return redirect(route('subdomain.index', $request->route()->account));
        }

        return back()->with('error', 'In-correct Email / Password!');
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authSvc->logout('subdomain');

        return redirect(route('subdomain.login.index', $request->route()->account));
    }
}
