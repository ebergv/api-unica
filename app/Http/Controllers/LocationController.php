<?php

namespace Prominas\Http\Controllers;

use Illuminate\Http\Request;

use Prominas\Entities\City;
use Prominas\Entities\State;
use Response;

class LocationController extends Controller
{
    protected $City;
    protected $State;

    public function __construct(City $city, State $state)
    {
        $this->State = $state;
        $this->City = $city;
    }

    public function getState($database)
    {
        $data = $this->State->setConnection($database)->get();
        return Response::json($data);
    }

    public function getCity($database, $cdestado)
    {
        $data = $this->City->setConnection($database)
            ->where('cdestado', $cdestado)->get();
        return Response::json($data);
    }

    public function getNameCityState($database, $name)
    {
        $data = $this->City->setConnection($database)
            ->where('tb_cidade.nmcidade', $name)
            ->join('tb_estado', 'tb_cidade.cdestado', '=', 'tb_estado.cdestado')
            ->first([
                'tb_cidade.cdcidade',
                'tb_estado.cdestado'
            ]);
        return Response::json($data);
    }

    public function getName($database, $cdcidade)
    {
        $data = $this->City->setConnection($database)
            ->join('tb_estado', 'tb_estado.cdestado', '=', 'tb_cidade.cdestado')
            ->where('tb_cidade.cdcidade', $cdcidade)
            ->first([
               'tb_cidade.cdcidade',
                'tb_cidade.nmcidade',
                'tb_estado.cdestado',
                'tb_estado.nmestado',
                'tb_estado.sgestado'
            ]);
        return Response::json($data);
    }

}
