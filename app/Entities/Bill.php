<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table        = 'tb_cobranca';
    public $timestamps      = false;
    protected $connection   = 'mysql2';

    protected $fillable     = [
        'idcobranca',
        'cdinscricao',
        'valor_cobranca',
        'valor_cobrancasemjuros',
        'cdstatus',
        'dtvencimento',
        'cdcedente',
        'tipo',
    ];
}
