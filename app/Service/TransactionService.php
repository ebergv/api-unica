<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 02/05/17
 * Time: 11:58
 */

namespace Prominas\Service;

use Prominas\Entities\EnrolmentTransaction;
use Psy\Exception\ErrorException;

class TransactionService
{
    protected $EnrolmentTransaction;

    public function __construct(EnrolmentTransaction $enrolmentTransaction)
    {
        $this->EnrolmentTransaction = $enrolmentTransaction;
    }

    public function save($enrolment, $database)
    {
        try {

            return $this->EnrolmentTransaction->setConnection($database)->insertGetId([
                'cdinscricao'   => $enrolment,
                'tid'           => 'boleto'
            ]);

        } catch (ErrorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}