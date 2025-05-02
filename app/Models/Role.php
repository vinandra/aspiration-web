<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public const ROLE_ADMIN = 1;
    public const ROLE_USER = 2;
}
