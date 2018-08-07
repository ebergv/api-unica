<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class MaterialWorkload extends Model
{
    protected $table        = 'tb_material_cargahoraria';
    protected $connection   = 'mysql2';
    protected $fillable     = [];
}
