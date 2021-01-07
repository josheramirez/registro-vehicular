<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class InstitucionUsuario extends Model
{
    use SoftDeletes;
    protected $table = 'instituciones_usuarios';
}
