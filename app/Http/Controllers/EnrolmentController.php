<?php

namespace Prominas\Http\Controllers;

use Illuminate\Http\Request;
use Prominas\Service\BillService;
use Prominas\Service\ClientService;
use Prominas\Service\EnrolmentService;
use Prominas\Service\TransactionService;
use Psy\Exception\ErrorException;
use Response;

class EnrolmentController extends Controller
{
    protected $EnrolmentService;
    protected $ClientService;
    protected $BillService;
    protected $TransactionService;

    public function __construct(EnrolmentService $enrolmentService, ClientService $clientService, BillService $billService, TransactionService $transactionService)
    {
        $this->EnrolmentService = $enrolmentService;
        $this->ClientService = $clientService;
        $this->BillService = $billService;
        $this->TransactionService = $transactionService;
    }

    public function save($database, Request $request)
    {

        $id = $request->get('cdcliente');
        $codeMaterial = null;

        try {

            /*
             * Insert or Update Client
             */
            if($id) {
                $this->ClientService->update($request->all(), $id, $database);
            } else {
                $id = $this->ClientService->save($request->all(), $database);
            }

            /*
             * If the enrolment is incomplete, it updates or inserts.
             */

            if($request->get('cdinscricao') == null) {

                /*
                 * Insert Enrolment
                 */
                $enrolment = $this->EnrolmentService->save($request->all(), $id, $database);

            } else {

                /*
                 * Update Enrolment
                 */
                $enrolment = $this->EnrolmentService->update($request->all(), $request->get('cdinscricao'), $id, $database);
            }

            /*
             * Insert Enrolment Transaction
             */
            $this->TransactionService->save($enrolment, $database);

            /*
             * Insert Bills Plane Enrolment
             */
            $this->BillService->save($request->all(),$enrolment, 3, $database);

            /*
             * Insert Bills Plane Material if exists
             */
            if($request->get('planomaterial') != 0) {
                $this->BillService->save($request->all(),$enrolment, 14, $database);
                $codeMaterial = $this->BillService->searchBill($enrolment, 14, $database);
            }

            /*
             * Search IdCobranca type enrolment and material
             */
            $codeEnrolment = $this->BillService->searchBill($enrolment,3, $database);

            return Response::json([
                'status' => true,
                'codeEnrolment' => $codeEnrolment->cdcobranca,
                'codeMaterial'  => ($codeMaterial != null) ? $codeMaterial->cdcobranca : $codeMaterial,
                'enrolment'     => $enrolment
            ]);

        } catch (ErrorException $e) {
            return Response::json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }

    }
}
