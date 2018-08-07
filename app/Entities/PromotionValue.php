<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class PromotionValue extends Model
{
    protected $table        = 'tb_promocao_valores';
    protected $connection   = 'mysql2';
    protected $fillable     = [];
}
