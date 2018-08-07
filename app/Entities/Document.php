<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table        = 'tb_documento';
    protected $connection   = 'mysql2';
    protected $fillable     = [];
}
