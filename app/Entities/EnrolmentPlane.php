<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class EnrolmentPlane extends Model
{
    protected $table        = 'tb_plano_pagamento_inscricao';
    protected $connection   = 'mysql2';
    protected $fillable     = [];
}
