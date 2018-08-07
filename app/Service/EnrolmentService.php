<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 28/04/17
 * Time: 15:30
 */

namespace Prominas\Service;


use Prominas\Entities\Enrolment;
use Psy\Exception\ErrorException;

class EnrolmentService
{
    protected $Enrolment;
    protected $CodeBoletoService;
    protected $Cdcliente;

    public function __construct(Enrolment $enrolment, CodeBoletoService $codeBoletoService)
    {
        $this->Enrolment = $enrolment;
        $this->CodeBoletoService = $codeBoletoService;
    }

    public function save(array $full, $cdclient, $database)
    {
        $this->Cdcliente = $cdclient;
        $data = $this->filterData($full);

        try {

            return $this->Enrolment->setConnection($database)->insertGetId($data);

        } catch (ErrorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function update(array $full, $cdinscricao, $cdclient, $database)
    {
        $this->Cdcliente = $cdclient;
        $data = $this->filterData($full);

        try {

            $this->Enrolment->setConnection($database)->where('cdinscricao', $cdinscricao)->update($data);
            return $cdinscricao;

        } catch (ErrorException $e) {
            return [
              'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    protected function filterData(array $data)
    {
        $inscrE = explode('-', $data['planoinscricao']);
        $mensaE = explode('-', $data['planomensalidade']);

        $d['idinscricao']           = $this->CodeBoletoService->setSize(6)->codeBoleto();
        $d['cdcliente']             = $this->Cdcliente;
        $d['cdcurso']               = $data['cdcurso'];
        $d['cdmodalidadecurso']     = 2;
        $d['valor_inscricao']       = ($inscrE[1] * $inscrE[0]);
        $d['nparcelasinscricao']    = $inscrE[0];
        $d['cdmaterial']            = ($data['planomaterial'] == 0) ? 1 : 2;
        $d['nparcelas']             = $mensaE[0];
        $d['valcurso']              = ($mensaE[1] * $mensaE[0]);
        $d['diapagamento']          = $data['diapagamento'];
        $d['cdmidia']               = $data['cdmidia'];
        $d['cdstatus']              = 1;
        $d['cdunidadeestudo']       = $data['cdcidade'];
        $d['isencao']               = 'N';
        $d['cdpromocao']            = 1;
        $d['tpinscricao']           = 'IN';
        $d['cd_parceiro_indicacao'] = (!empty($data['cd_parceiro_indicacao'])) ? $data['cd_parceiro_indicacao'] : NULL;

        return $d;
    }
}