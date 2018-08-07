<?php

namespace Prominas\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Prominas\Entities\CourseDiscipline;
use Prominas\Entities\MaterialPlane;
use Prominas\Entities\MaterialWorkload;
use Prominas\Service\WorkloadService;
use Response;


class MaterialPlaneController extends Controller
{
    protected $MaterialWorkload;
    protected $MaterialPlane;
    protected $CourseDiscipline;
    protected $Cdcourse;
    protected $WorkloadService;

    public function __construct(MaterialWorkload $materialWorkload, MaterialPlane $materialPlane, CourseDiscipline $courseDiscipline, WorkloadService $workloadService)
    {
        $this->MaterialWorkload = $materialWorkload;
        $this->MaterialPlane    = $materialPlane;
        $this->CourseDiscipline = $courseDiscipline;
        $this->WorkloadService  = $workloadService;
    }

    public function showPlane($database,$cdcurso)
    {
        $this->Cdcourse = $cdcurso;
        $chCourse = $this->getWorkload($database);
        $workload = $this->WorkloadService->getWorkload($chCourse->ch);

        if(!$workload) {
            return [
              'status' => false,
                'message' => 'Workload not found'
            ];
        }

        $chPlane = $this->MaterialWorkload->setConnection($database)
            ->where('carga_horaria', $workload)->first(['cdmaterialcargahoraria']);

        if(!$chPlane) {
            return [
                'status' => false,
                'message' => 'Code Workload not found'
            ];
        }

        $workloadPlane = $this->MaterialPlane->setConnection($database)
            ->where(['cdmaterialcargahoraria' => $chPlane->cdmaterialcargahoraria, 'ativo' => 'S'])
            ->get(['nparcelas as parcela', 'valor']);

        return Response::json($workloadPlane);

    }

    public function getWorkload($database)
    {
        $data = DB::connection($database)->table('tb_curso_disciplina')
                ->where([
                    'cdcurso' => $this->Cdcourse,
                    'ativo' => true
                ])->select(DB::raw('SUM(carga_horaria) as ch'))
                ->first();
        return $data;
    }

}
