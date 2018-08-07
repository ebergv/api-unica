<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table        = 'tb_clientes';
    public $timestamps      = false;
    protected $connection   = 'mysql2';
    protected $fillable     = [
        'nucpfcnpj',
        'nuidentidade',
        'cdestado_civil',
        'sexo',
        'nmcliente',
        'email',
        'emailsecundario',
        'emaildefault',
        'telefone1',
        'telefone2',
        'endereco',
        'complemento',
        'numero',
        'bairro',
        'cep',
        'cdestado',
        'cdcidade',
        'orgaoexpedidor',
        'dtnascimento',
        'cdformacaoescolar',
        'nmcursograduacao',
        'dtcolacaodegrau',
        'cdestadonaturalidade',
        'cdcidadenaturalidade',
        'nmpai',
        'nmmae',
        'optin'
    ];
}
