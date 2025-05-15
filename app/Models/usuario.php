<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    protected $fillable = ['nombre', 'email', 'telefono', 'password', 'id_rol'];

    protected $hidden = ['password'];
}
