<?php

namespace Prominas\Entities;

use Illuminate\Database\Eloquent\Model;

class EnrolmentTransaction extends Model
{
    protected $table        = 'tb_inscricao_transacao';
    public $timestamps      = false;
    protected $connection   = 'mysql2';
    protected $fillable     = [
        'cdinscricao',
        'tid'
    ];
}
