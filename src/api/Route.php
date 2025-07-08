<?php
namespace App\api;

use Exception;
use App\controller\IndexController;

class Route
{
    private static $instance;
    private $arrPathInfo = array();
    private $route;
    private $controller;
    private $method;

    /**
     * Instância da classe
     *
     * @return Route
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Route();
        }
        return self::$instance;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route ?? '';
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * 
     * @param mixed $controller
     * @return void
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return array
     */
    public function getArrPathInfo()
    {
        return $this->arrPathInfo;
    }

    /**
     * @param array $arrPathInfo
     */
    public function setArrPathInfo($arrPathInfo)
    {
        $this->arrPathInfo = $arrPathInfo;
        if (array_key_exists(0, $this->getArrPathInfo()) && $this->getArrPathInfo()[0]) {
            $this->setRoute($this->getArrPathInfo()[0]);
        }
        if (array_key_exists(1, $this->getArrPathInfo()) && $this->getArrPathInfo()[1]) {
            $this->setController($this->getArrPathInfo()[1]);
        }
        if (array_key_exists(2, $this->getArrPathInfo()) && $this->getArrPathInfo()[2]) {
            $this->setMethod($this->getArrPathInfo()[2]);
        }
    }

    /**
     * 
     */
    public function __construct()
    {
        try {
            if (array_key_exists('PATH_INFO', $_SERVER)) {
                $this->setArrPathInfo(explode('/', substr($_SERVER['PATH_INFO'], 1)));
            }
            // Acesso das funções da classe
            if (method_exists($this, strtolower($this->getRoute()))) {
                $this->{strtolower($this->getRoute())}();
            } else {
                throw new Exception('URL inválida.');
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array("erro" => $e->getMessage()));
        }
    }

    /**
     * 
     * 
     * @throws Exception
     */
    private function api()
    {
        try {
            if (!$this->getRoute() || !$this->getController()) {
                IndexController::getInstance()->indexView();
            } else {
                if (file_exists(__DIR__ . "/../controller/" . ucfirst($this->getController()) . "Controller.php")) {
                    $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

                    $creator = new \Nyholm\Psr7Server\ServerRequestCreator(
                        $psr17Factory, // ServerRequestFactory
                        $psr17Factory, // UriFactory
                        $psr17Factory, // UploadedFileFactory
                        $psr17Factory  // StreamFactory
                    );

                    $serverRequest = $creator->fromGlobals();

                    $class = "\\App\\controller\\" . ucfirst($this->getController()) . "Controller";
                    $method = $this->getMethod();
                    $ob = new $class($serverRequest);
                    $ob->$method();
                } else {
                    throw new Exception('URL inválida.');
                }
            }
        } catch (Exception $e) {
            echo json_encode(array("erro" => $e->getMessage()));
        }
    }

    /**
     * Documentação da API
     * 
     * @return void
     */
    private function doc()
    {
        require_once __DIR__ . '/../../public/view/swagger/index.html';
    }
}