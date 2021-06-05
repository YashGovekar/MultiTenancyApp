<?php

namespace App\Repositories;

use App\Models\Customer;
use Prettus\Repository\Eloquent\BaseRepository;

class CustomerRepository extends BaseRepository
{
    public function model(): string
    {
        return Customer::class;
    }
}
