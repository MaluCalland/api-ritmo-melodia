<?php
namespace App\controller;

use App\service\GeneroService;

class GeneroController
{
    private $generoService;

    public function __construct()
    {
        $this->generoService = new GeneroService();
    }

    public function listar()
    {
        $this->generoService->listar();
    }
}