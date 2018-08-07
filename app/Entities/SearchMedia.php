<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class SearchMedia extends Model
{
    protected $table        = 'tb_pesquisa_midia';
    protected $connection   = 'mysql2';
    protected $fillable     = [];
}
