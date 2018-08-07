<?php

namespace Prominas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prominas\Entities\Course;
use Prominas\Entities\CourseArea;
use Prominas\Entities\CourseType;
use Response;


class CourseController extends Controller
{
    protected $CourseType;
    protected $CourseArea;
    protected $Course;

    public function __construct(Course $course, CourseType $courseType, CourseArea $courseArea)
    {
        $this->CourseType = $courseType;
        $this->CourseArea = $courseArea;
        $this->Course = $course;
    }

    public function showCourseType($database)
    {
        $data = $this->CourseType->setConnection($database)
            ->where(['status' => true])
            ->where('cdtpcurso',1)
            ->get(['cdtpcurso', 'nmtpcurso']);
        return Response::json($data);
    }

    public function showCourseArea($database)
    {
        $data = $this->CourseArea->setConnection($database)
            ->get(['cdcurso_area', 'dscurso_area']);
        return Response::json($data);
    }

    public function showCourse($database,$courseType, $courseArea) {

        $data = DB::connection($database)->table('tb_curso')
                    ->join('tb_curso_disciplina', 'tb_curso_disciplina.cdcurso', '=', 'tb_curso.cdcurso')
                    ->where([
                        'tb_curso.cdtpcurso' => $courseType,
                        'tb_curso.cdcurso_area' => $courseArea,
                        'tb_curso.ativo' => 'S',
                        'tb_curso.ativosite' => 'S',
                        'tb_curso_disciplina.ativo' => true
                    ])
                    ->groupBy('tb_curso.cdcurso')
                    ->orderBy('tb_curso.nmcurso')
                    ->select([
                        DB::raw('SUM(tb_curso_disciplina.carga_horaria) as ch'),
                        'tb_curso.cdcurso',
                        'tb_curso.nmcurso'
                    ])
                    ->get();

        return Response::json($data);
    }

    public function getCourse($database,$cdcurso)
    {
        $data = DB::connection($database)->table('tb_curso')
            ->join('tb_curso_tipo', 'tb_curso_tipo.cdtpcurso', '=', 'tb_curso.cdtpcurso')
            ->join('tb_curso_area', 'tb_curso_area.cdcurso_area', '=', 'tb_curso.cdcurso_area')
            ->join('tb_curso_disciplina', 'tb_curso_disciplina.cdcurso', '=', 'tb_curso.cdcurso')
            ->where('tb_curso.cdcurso', $cdcurso)
            ->groupBy('tb_curso.cdcurso')
            ->first([
               'tb_curso.cdcurso',
                'tb_curso.nmcurso',
                'tb_curso_tipo.nmtpcurso',
                'tb_curso_area.dscurso_area',
                DB::raw('SUM(tb_curso_disciplina.carga_horaria) as ch')
            ]);

        return Response::json($data);
    }
}
