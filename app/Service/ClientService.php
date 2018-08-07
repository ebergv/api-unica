<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 28/04/17
 * Time: 16:12
 */

namespace Prominas\Service;


use Prominas\Entities\Client;
use Psy\Exception\ErrorException;

class ClientService
{
    protected $Client;

    public function __construct(Client $client)
    {
        $this->Client = $client;
    }

    public function save(array $d, $database)
    {
        $data = $this->filterData($d);
        try {

            return $this->Client->setConnection($database)->insertGetId($data);

        } catch (ErrorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function update(array $d, $id, $database)
    {
        $data = $this->filterData($d);
        try {

            return $this->Client->setConnection($database)->where('cdcliente', $id)->update($data);

        } catch (ErrorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function filterData(array $data)
    {
        $d['nucpfcnpj']             = $data['nucpfcnpj'];
        $d['nuidentidade']          = $data['nuidentidade'];
        $d['cdestado_civil']        = $data['cdestado_civil'];
        $d['sexo']                  = $data['sexo'];
        $d['nmcliente']             = $data['nmcliente'];
        $d['email']                 = $data['email'];
        $d['emailsecundario']       = $data['email'];
        $d['emaildefault']          = $data['email'];
        $d['telefone1']             = $data['telefone1'];
        $d['telefone2']             = $data['telefone2'];
        $d['endereco']              = $data['endereco'];
        $d['complemento']           = ($data['complemento'] != null) ? $data['complemento'] : '';
        $d['numero']                = $data['numero'];
        $d['bairro']                = $data['bairro'];
        $d['cep']                   = $data['cep'];
        $d['cdestado']              = $data['cdestado'];
        $d['cdcidade']              = $data['cdcidade'];
        $d['orgaoexpedidor']        = $data['orgaoexpedidor'];
        $d['dtnascimento']          = $this->formatDate($data['dtnascimento']);
        $d['cdformacaoescolar']     = $data['cdformacaoescolar'];
        $d['nmcursograduacao']      = $data['nmcursograduacao'];
        $d['dtcolacaodegrau']       = $this->formatDate($data['dtcolacaodegrau']);
        $d['cdestadonaturalidade']  = $data['cdestadonaturalidade'];
        $d['cdcidadenaturalidade']  = $data['cdcidadenaturalidade'];
        $d['nmpai']                 = $data['nmpai'];
        $d['nmmae']                 = $data['nmmae'];
        $d['optin']                 = ($data['optin']) ? 'S' : 'N';
        
        return $d;
    }

    protected function formatDate($d)
    {
        $ed = explode('/', $d);
        return $ed[2] . '-' . $ed['1'] . '-' . $ed[0];
    }
}