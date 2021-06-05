<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableToExclude extends Model
{
    use HasFactory;

    public $table = 'tables_to_exclude';

    protected $guarded = [];
}
