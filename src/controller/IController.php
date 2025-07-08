<?php
namespace App\controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface IController
{
    public function __construct(ServerRequestInterface $serverRequestInterface);
}