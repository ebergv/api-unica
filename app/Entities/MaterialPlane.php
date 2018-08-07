<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class MaterialPlane extends Model
{
    protected $table = 'tb_plano_pagamento_material';
    protected $connection   = 'mysql2';
    protected $fillable = [];
}
