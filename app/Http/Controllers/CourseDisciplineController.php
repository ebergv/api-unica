<?php

namespace Prominas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class CourseDisciplineController extends Controller
{


    public function getDiscipline($database,$id)
    {
        $data = DB::connection($database)
            ->table('tb_curso')
            ->join('tb_curso_disciplina', 'tb_curso_disciplina.cdcurso', '=', 'tb_curso.cdcurso')
            ->join('tb_disciplina', 'tb_disciplina.cddisciplina', '=', 'tb_curso_disciplina.cddisciplina')
            ->where('tb_curso.cdcurso', $id)
            ->where('tb_curso_disciplina.ativo', true)
            ->where('tb_curso_disciplina.ativo', true)
            ->orderBy('tb_curso_disciplina.modulo')
            ->select([
                'tb_curso_disciplina.modulo',
                'tb_disciplina.nome',
                'tb_curso_disciplina.carga_horaria'
            ])->get();

        return Response::json($data);

    }

}
