<?php

namespace App\Models;

use App\DB;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    public function getConnection(): Connection
    {
        return DB::mockConnectionUsing('pgsql', 'prefix');
    }
}
