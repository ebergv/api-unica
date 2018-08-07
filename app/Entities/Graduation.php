<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class Graduation extends Model
{
    protected $table        = 'tb_formacaoescolar';
    protected $connection   = 'mysql2';
    protected $fillable     = [];
}
