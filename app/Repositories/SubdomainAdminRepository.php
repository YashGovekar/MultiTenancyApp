<?php

namespace App\Repositories;

use App\Models\Subdomain;
use Prettus\Repository\Eloquent\BaseRepository;

class SubdomainAdminRepository extends BaseRepository
{
    public function model(): string
    {
        return Subdomain\Admin::class;
    }
}
