<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuloUsuario extends Model
{
    use SoftDeletes;
    protected $table = 'modulos_usuarios';
}
