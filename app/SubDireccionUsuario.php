<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SubDireccionUsuario extends Model
{
    use SoftDeletes;
    protected $table = 'sub_direcciones_usuarios';
}
