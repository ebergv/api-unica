<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
    protected $table        = 'tb_curso_tipo';
    protected $connection   = 'mysql2';
    protected $fillable     = [];
}
