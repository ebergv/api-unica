<?php

namespace Prominas\Http\Controllers;


use Prominas\Entities\Course;
use Prominas\Entities\PagammentPlane;
use Prominas\Entities\PromotionValue;
use Response;

class PagammentPlaneController extends Controller
{
    protected $PagammentPlane;
    protected $PromotionValue;
    protected $Course;

    public function __construct(PagammentPlane $pagammentPlane, PromotionValue $promotionValue, Course $course)
    {
        $this->PagammentPlane   = $pagammentPlane;
        $this->PromotionValue   = $promotionValue;
        $this->Course           = $course;
    }

    public function showPlane($database, $cdcurso)
    {
        $course = $this->Course->setConnection($database)
            ->where([
                'cdcurso' => $cdcurso,
                'ativo' => 'S',
                'ativosite' => 'S'
            ])
            ->first(['cdpromocao']);

        if(!$course) {
            return [
              'status' => false,
                'message' => 'Course not found'
            ];
        }

        if($course->cdpromocao == 1) {
            $data = $this->PagammentPlane->setConnection($database)
                ->where(['cdcurso' => $cdcurso, 'cdmaterial' => 1, 'ativo' => 'S'])
                ->get([
                    'nparcelas as parcela',
                    'valparcela as valor'
                ]);
        }else {
            $data = $this->PromotionValue->setConnection($database)
                ->where(['cdpromocao' => $course->cdpromocao, 'cdmaterial' => 1, 'ativo' => true])
                ->get([
                    'parcela as parcela',
                    'valorparcela as valor'
                ]);
        }

        return Response::json($data);

    }

    public function startMonth($database, $m)
    {
        $data = [];
        for ($i = 1; $i < $m+1; $i++):
            $dias = '+' . $i . ' months';
            $date = date('m', strtotime($dias, strtotime(date('Y-m-d H:i:s'))));
            array_push($data,$date);
        endfor;
        return Response::json($data);
    }
}
