<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table        = 'tb_estado';
    protected $connection   = 'mysql2';
    protected $fillable     = [];
}
