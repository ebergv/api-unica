<?php

namespace Prominas\Http\Controllers;

use Illuminate\Http\Request;
use Prominas\Entities\Client;
use Prominas\Entities\CourseType;
use Response;


class ClientController extends Controller
{
    protected $Client;
    protected $CourseType;

    public function __construct(Client $client, CourseType $courseType)
    {
        $this->Client = $client;
        $this->CourseType = $courseType;
    }

    public function search($database, $cpf)
    {
        if(!$this->validaCPF($cpf)) {
            return Response::json(['status' => 800]);
        }

        $cpf = str_replace(['.','-'], '', $cpf);
        $data = $this->Client->setConnection($database)->where('nucpfcnpj', $cpf)->first([
            'cdcliente',
            'nucpfcnpj',
            'nuidentidade',
            'cdestado_civil',
            'sexo',
            'nmcliente',
            'email',
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
            'nmmae'
        ]);

        if(empty($data)) {
            return Response::json(['status' => 801]);
        }

        $data->dtnascimento = date('d/m/Y', strtotime($data->dtnascimento));
        $data->dtcolacaodegrau = date('d/m/Y', strtotime($data->dtcolacaodegrau));

        return Response::json(['status' => 200, 'data' => $data]);
    }

    public function coursetype()
    {
        $data = $this->CourseType->all();
        dd($data);
    }

    public function student($database, $cpf,$cdcurso)
    {
        $data = $this->Client->setConnection($database)
            ->join('tb_inscricao', 'tb_inscricao.cdcliente', '=', 'tb_clientes.cdcliente')
            ->where('tb_clientes.nucpfcnpj', $cpf)
            ->where('tb_inscricao.cdcurso', $cdcurso)
            ->first([
                'tb_inscricao.cdstatus as status',
                'tb_inscricao.cdinscricao'
            ]);

        //Não há inscrição neste cpf
        if (empty($data)) {
            return Response::json(['status' => '200']);
        }

        //Inscrição incompleta
        if ($data->status == 2) {
            return Response::json(['status' => 900, 'cdinscricao' => $data->cdinscricao]);
        }

        //Inscrição verificada ou outras
        return Response::json(['status' => 901]);
    }

    public function verifyDtColacao($database, $date, $typeCourse)
    {
        $dt = $this->formatDate($date);
        $dc = $this->intervalDays($dt);

        if ((strtotime($dt) > strtotime(date('Y-m-d'))) && $typeCourse == 1) {

            switch ($dc) {
                case ($dc <= 180) :
                    return Response::json(['termo_ciencia' => true, 'colou_grau' => false]);
                    break;
                case ($dc > 180) :
                    return Response::json(['termo_ciencia' => false, 'colou_grau' => false]);
                    break;
            }
        }

        return Response::json(['termo_ciencia' => false, 'colou_grau' => true]);
    }

    protected function formatDate($d)
    {
        $ed = explode('-', $d);
        return $ed[2] . '-' . $ed['1'] . '-' . $ed[0];
    }

    protected function intervalDays($d)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $data_inicial = date('Y-m-d');
        $data_final = $d;

        $time_inicial = explode('-', $data_inicial);
        $time_inicial = mktime(0, 0, 0, $time_inicial[1], $time_inicial[2], $time_inicial[0]);
        $time_final = explode('-', $data_final);
        $time_final = mktime(0, 0, 0, $time_final[1], $time_final[2], $time_final[0]);
        $diferenca = $time_final - $time_inicial;
        $dias = (int)floor($diferenca / (60 * 60 * 24));

        return $dias;
    }

    protected function validaCPF($cpf)
    {

        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        $digitoA = 0;
        $digitoB = 0;

        for ($i = 0, $x = 10; $i <= 8; $i++, $x--) {

            $digitoA += $cpf[$i] * $x;
        }

        for ($i = 0, $x = 11; $i <= 9; $i++, $x--) {

            $digitoB += $cpf[$i] * $x;
        }

        $somaA = (($digitoA % 11) < 2) ? 0 : 11 - ($digitoA % 11);
        $somaB = (($digitoB % 11) < 2) ? 0 : 11 - ($digitoB % 11);

        if ($cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999' ||
            $cpf == '00000000000'
        ) {
            return false;
        } elseif ($somaA != $cpf[9] || $somaB != $cpf[10]) {
            return false;
        } else {
            return true;
        }
    }
}
