<?php

namespace App\controller;

class IndexController
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new IndexController();
        }
        return self::$instance;
    }

    public function indexView()
    {
        require_once __DIR__ . '/../../public/view/index/index.html';
    }
}