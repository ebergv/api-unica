<?php

namespace Prominas\Http\Controllers;

use Illuminate\Http\Request;
use Prominas\Entities\Graduation;
use Response;

class GraduationController extends Controller
{
    protected $Graduation;

    public function __construct(Graduation $graduation)
    {
        $this->Graduation = $graduation;
    }

    public function showGraduation($database)
    {
        if($database == 'iseib') {
            $data = $this->Graduation->setConnection($database)
                ->where('grupo', 1)->get();
        }else {
            $data = $this->Graduation->setConnection($database)->get();
        }

        return Response::json($data);
    }

    public function getGraduation($database, $cdformacao)
    {
        $data = $this->Graduation->setConnection($database)
            ->where('cdformacaoescolar', $cdformacao)
            ->first([
                'cdformacaoescolar',
                'nmformacaoescolar'
            ]);
        return Response::json($data);
    }
}
