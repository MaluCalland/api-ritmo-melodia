<?php
namespace App\controller;

use App\service\GeneroService;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GeneroController extends Controller implements IController
{
    private $generoService;

    public function __construct(ServerRequestInterface $serverRequestInterface)
    {
        $this->generoService = new GeneroService();
        $this->request = $serverRequestInterface;
    }

    public function listar()
    {
        $arrParam = $this->request->getQueryParams();
        $this->generoService->listar(rawurlencode($arrParam['tag']));
    }
}