<?php
namespace App\infra\http;

use Exception;

class Curl
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Curl();
        }
        return self::$instance;
    }

    private function optPost(): array
    {
        return [CURLOPT_CUSTOMREQUEST => "POST"];
    }

    private function optHeader(): array
    {
        return [CURLOPT_HTTPHEADER => ["User-Agent: App/1.0"]];
    }

    public function get($url)
    {
        // Inicializa o cURL
        $c = curl_init();

        try {
            // Configurações da requisição
            curl_setopt_array(
                $c,
                [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                ]
                +
                $this->optHeader()
            );

            // Executa a requisição
            $response = curl_exec($c);

            if ($response === false) {
                throw new Exception(curl_error($c));
            }

            return $response;
        } finally {
            // Fecha a conexão cURL
            curl_close($c);
        }
    }
}