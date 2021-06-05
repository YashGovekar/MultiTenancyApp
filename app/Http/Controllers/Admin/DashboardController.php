<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CustomerRepository;
use App\Services\DBService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    private $dbSvc;
    private $customerRepo;

    /**
     * DashboardController constructor.
     * @param CustomerRepository $customerRepo
     * @param DBService $dbSvc
     */
    public function __construct(CustomerRepository $customerRepo, DBService $dbSvc)
    {
        $this->customerRepo = $customerRepo;
        $this->dbSvc = $dbSvc;
    }

    public function index(): Response
    {
        $tables = $this->dbSvc->allTables();
        $tables_to_exclude = $this->dbSvc->getTablesToExclude();
        $customers = $this->customerRepo->all();

        return Inertia::render('Home', [
            'db_tables'         => $tables,
            'tables_to_exclude' => $tables_to_exclude,
            'customers'         => $customers,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->dbSvc->updateTablesToExclude($request->except('_token', '_method'));

        return redirect()->back();
    }
}
