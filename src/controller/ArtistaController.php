<?php

namespace App\controller;

use App\service\ArtistaService;

class ArtistaController
{
    private $artistaService;

    public function __construct()
    {
        $this->artistaService = new ArtistaService();
    }

    public function listar()
    {
        $this->artistaService->listar();
    }
}