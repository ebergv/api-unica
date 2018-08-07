<?php

namespace Prominas\Http\Controllers;

use Illuminate\Http\Request;
use Prominas\Entities\SearchMedia;
use Response;

class SearchMediaController extends Controller
{
    protected $SearchMedia;

    public function __construct(SearchMedia $SearchMedia)
    {
        $this->SearchMedia = $SearchMedia;
    }

    public function showMedia($database)
    {
        $data = $this->SearchMedia->setConnection($database)
            ->where('ativo', true)
            ->where('cdmidia', '<>', 14)
            ->get(['cdmidia', 'nmmidia']);
        return Response::json($data);
    }

    public function getMedia($database,$cdmidia)
    {
        $data = $this->SearchMedia->setConnection($database)
            ->where('cdmidia', $cdmidia)->first(['cdmidia', 'nmmidia']);
        return Response::json($data);
    }
}
