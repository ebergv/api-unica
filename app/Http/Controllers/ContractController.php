<?php

namespace Prominas\Http\Controllers;

use Illuminate\Http\Request;
use Prominas\Entities\Contract;
use Response;

class ContractController extends Controller
{
    protected $Contract;

    public function __construct(Contract $contract)
    {
        $this->Contract = $contract;
    }

    public function getContract($database)
    {
        $data = $this->Contract->setConnection($database)
            ->where(['cdtpcurso' => 1, 'ativo' => true])->first(['dsccontrato']);
        return Response::json($data);
    }
}
