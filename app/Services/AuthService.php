<?php

namespace App\Services;

use App\Models\Subdomain\Admin;
use App\Repositories\CustomerRepository;
use App\Repositories\SubdomainAdminRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    private $adminRepo;
    private $customerRepo;
    private $dbSvc;
    private $userRepo;

    /**
     * AuthService constructor.
     * @param SubdomainAdminRepository $adminRepo
     * @param CustomerRepository $customerRepo
     * @param DBService $dbSvc
     * @param UserRepository $userRepo
     */
    public function __construct(
        SubdomainAdminRepository $adminRepo,
        CustomerRepository $customerRepo,
        DBService $dbSvc,
        UserRepository $userRepo
    ) {
        $this->adminRepo = $adminRepo;
        $this->customerRepo = $customerRepo;
        $this->dbSvc = $dbSvc;
        $this->userRepo = $userRepo;
    }

    public function registerCustomer(array $data): bool
    {
        $data = $this->dbSvc->createDatabase($data);

        if (count($data) > 0) {
            try {
                $this->customerRepo->create([
                    'name'        => $data['name'],
                    'email'       => $data['email'],
                    'password'    => Hash::make($data['password']),
                    'subdomain'   => $data['subdomain'],
                    'db_name'     => Crypt::encrypt($data['db_name']),
                    'db_username' => Crypt::encrypt($data['db_username']),
                    'db_password' => Crypt::encrypt($data['db_password']),
                ]);

                Admin::on('subdomain')->create([
                    'name'     => $data['name'],
                    'email'    => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);

                return true;
            } catch (Exception $e) {
                Log::error($e->getMessage());

                return false;
            }
        }

        return false;
    }

    public function customerLogin(array $data): bool
    {
        $admin = $this->adminRepo->findByField('email', $data['email'])->first();

        if ($admin) {
            if (Hash::check($data['password'], $admin->password)) {
                Auth::guard('subdomain')->login($admin, true);

                return true;
            }
        }

        return false;
    }

    public function logout($guard = 'web')
    {
        Auth::guard($guard)->logout();
    }

    public function userLogin(array $data): bool
    {
        $user = $this->userRepo->findByField('email', $data['email'])->first();

        if ($user) {
            if (Hash::check($data['password'], $user->password)) {
                Auth::login($user, true);

                return true;
            }
        }

        return false;
    }

    public function registerUser(array $data): bool
    {
        try {
            $this->userRepo->create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }
}
