<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table        = 'tb_curso';
    protected $connection   = 'mysql2';
    protected $fillable     = [];
}
