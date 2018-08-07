<?php

namespace Prominas\Http\Controllers;

use Illuminate\Http\Request;
use Prominas\Entities\Document;
use Response;


class DocumentController extends Controller
{
    protected $Document;

    public function __construct(Document $document)
    {
        $this->Document = $document;
    }

    public function getDocument($database, $type)
    {
        $data = $this->Document->setConnection($database)
            ->where('cdtpcurso', $type)
            ->where('ativo', 'S')
            ->get(['descricao as docs']);
        return Response::json($data);
    }
}
