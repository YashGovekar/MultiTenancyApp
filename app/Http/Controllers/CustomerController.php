<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    private $authSvc;

    /**
     * CustomerController constructor.
     * @param AuthService $authSvc
     */
    public function __construct(AuthService $authSvc)
    {
        $this->authSvc = $authSvc;
    }

    public function register(): Response
    {
        return Inertia::render('Subdomain/Auth/Register');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'unique:customers|required',
            'password'  => 'required',
            'subdomain' => 'unique:customers|required',
        ]);

        $register = $this->authSvc->registerCustomer($request->all());

        if ($register) {
            return back()->with([
                'route' => route('subdomain.login.index', $request->input('subdomain')),
            ]);
        }

        return back()->withErrors(['subdomain' => 'In-correct Data!']);
    }
}
