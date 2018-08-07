<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 28/04/17
 * Time: 16:52
 */

namespace Prominas\Service;


use Illuminate\Support\Facades\DB;
use Prominas\Entities\Bill;
use Psy\Exception\ErrorException;

class BillService
{
    protected $Bill;
    protected $CodeBoletoService;
    protected $Cdinscricao;
    protected $TypeBill;

    public function __construct(Bill $bill, CodeBoletoService $codeBoletoService)
    {
        $this->Bill = $bill;
        $this->CodeBoletoService = $codeBoletoService;
    }

    public function save(array $data, $cdinscricao, $type, $database)
    {
        $this->Cdinscricao = $cdinscricao;
        $this->TypeBill = $type;
        $d = $this->filterData($data, $database);

        try {

            return $this->Bill->setConnection($database)->insert($d);

        } catch (ErrorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }


    }

    public function searchBill($id,$type, $database)
    {
        $data = $this->Bill->setConnection($database)
            ->where([
            'cdinscricao' => $id,
            'tipo' => $type
            ])
            ->limit(1)
            ->first(['cdcobranca']);
        return $data;
    }

    protected function filterData(array $data, $database)
    {
        $planeResult = $this->getValorType($data);
        $d['dtvencimento'] = $planeResult['dtvencimento'];
        $d['cdcedente'] = $this->getCedente($database);
        if($planeResult['tipo'] == 3) {
            $d['mesiniciocobranca'] = $data['mesiniciocobranca'];
        }
        $plane = [];

        for($i = 1; $i <= $planeResult['parcelas']; $i++) {

            $d['idcobranca'] = $this->CodeBoletoService->setSize(6)->codeBoleto();
            $d['cdinscricao'] = $this->Cdinscricao;
            $d['valor_cobranca'] = $planeResult['valor_parcela'];
            $d['valor_cobrancasemjuros'] = $planeResult['valor_parcela'];
            $d['cdstatus'] = 1;
            $d['tipo'] = $planeResult['tipo'];

            if($i > 1) {
                $d['dtvencimento'] = date('Y-m-d', strtotime("+1 months", strtotime($d['dtvencimento'])));
            }

            array_push($plane, $d);

        }

        return $plane;

    }

    protected function getValorType(array $data)
    {
        switch ($this->TypeBill) {

            case 3:

                $planeE = explode('-', $data['planoinscricao']);
                $date =  $this->formatDate($data['dtpagtoinscricao']);
                return $result = [
                    'parcelas' => $planeE[0],
                    'valor_parcela' => $planeE[1],
                    'dtvencimento' => $date,
                    'tipo' => 3
                ];

                break;

            case 14:

                $planeE = explode('-', $data['planomaterial']);
                $date =  $this->formatDate($data['dtpagtomaterial']);
                return $result = [
                    'parcelas' => $planeE[0],
                    'valor_parcela' => $planeE[1],
                    'dtvencimento' => $date,
                    'tipo' => 14
                ];

                break;
        }
    }

    protected function formatDate($d)
    {
        $ed = explode('/', $d);
        return $ed[2] . '-' . $ed['1'] . '-' . $ed[0];
    }

    protected function getCedente($database)
    {
        $data = DB::connection($database)->table('tb_cedente')
                    ->where('ativo', 'S')
                    ->first(['cdcedente']);
        return $data->cdcedente;
    }

}