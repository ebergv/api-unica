<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table        = 'tb_cidade';
    protected $connection   = 'mysql2';
    protected $fillable     = [];
}
