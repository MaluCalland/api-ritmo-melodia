<?php

namespace App\controller;

use App\service\AlbumService;
use Psr\Http\Message\ServerRequestInterface;

class AlbumController extends Controller implements IController
{
    private $albumService;

    public function __construct(ServerRequestInterface $serverRequestInterface)
    {
        $this->albumService = new AlbumService();
        $this->request = $serverRequestInterface;
    }

    public function listar()
    {
        
    }

    public function detalhar()
    {
        $arrParam = $this->request->getQueryParams();
        $this->albumService->detalhar($arrParam['id']);
    }
}