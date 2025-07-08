<?php

namespace App\controller;

use App\service\ArtistaService;
use Psr\Http\Message\ServerRequestInterface;

class ArtistaController extends Controller implements IController
{
    private $artistaService;

    public function __construct(ServerRequestInterface $serverRequestInterface)
    {
        $this->artistaService = new ArtistaService();
        $this->request = $serverRequestInterface;
    }

    public function listar()
    {
        $arrParam = $this->request->getQueryParams();
        $this->artistaService->listar(rawurlencode($arrParam['name']));
    }

    public function detalhar()
    {
        $arrParam = $this->request->getQueryParams();
        $this->artistaService->detalhar($arrParam['id']);
    }
}