<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UnidadUsuario extends Model
{
    use SoftDeletes;
    protected $table = 'unidades_usuarios';
}
