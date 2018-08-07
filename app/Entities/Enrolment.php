<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    protected $table        = 'tb_inscricao';
    public $timestamps      = false;
    protected $connection   = 'mysql2';
    protected $fillable     = [
        'idinscricao',
        'cdcliente',
        'cdcurso',
        'cdmodalidadecurso',
        'valorinscricao',
        'nparcelasinscricao',
        'cdmaterial',
        'nparcelas',
        'valcurso',
        'diapagamento',
        'cdmidia',
        'cdstatus',
        'cdunidadeestudo',
        'isencao',
        'cdpromocao',
        'tpinscricao',
        'cd_parceiro_indicacao'
    ];
}
