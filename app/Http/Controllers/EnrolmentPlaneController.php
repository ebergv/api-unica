<?php

namespace Prominas\Http\Controllers;

use Illuminate\Http\Request;
use Prominas\Entities\Course;
use Prominas\Entities\EnrolmentPlane;
use Response;

class EnrolmentPlaneController extends Controller
{
    protected $EnrolmentPlane;
    protected $Course;

    public function __construct(EnrolmentPlane $enrolmentPlane, Course $course)
    {
        $this->EnrolmentPlane = $enrolmentPlane;
        $this->Course = $course;
    }

    public function showPlane($database, $cdcurso)
    {
        $course = $this->Course->setConnection($database)
                    ->where('cdcurso', $cdcurso)->first(['cdtpcurso']);
        $data = $this->EnrolmentPlane->setConnection($database)
                ->where(['cdtpcurso' => $course->cdtpcurso, 'ativo' => 'S'])
                ->get([
                    'nparcelas as parcela',
                    'valor'
                ]);
        return Response::json($data);

    }

    public function getDateVenc($database,$d)
    {
        $data = [];
        for ($i = 1; $i < $d+1; $i++):
            $dias = '+' . $i . ' days';
            $date = date('d/m/Y', strtotime($dias, strtotime(date('Y-m-d H:i:s'))));
            array_push($data,$date);
        endfor;
        return Response::json($data);
    }

}
